<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

use App\AuthorizenetLogs;
use Auth;
use App\Models\Currency;

use App\User;
use Notification;
use App\Notifications\AdminNotification;

class AuthorizenetController extends Controller
{
    public function __construct() {
        $this->middleware('auth'); // later enable it when needed user login while payment
    }

    public function index()
    {
        $checks = AuthorizenetLogs::where('user_id', Auth::user()->id)->get();
        return view('authorizenet.index')->with('checks', $checks);
    }

    // start page form after start
    public function pay() {
        $user = Auth::user();
        return view('authorizenet.pay')->with('user', $user);
    }

    public function handleonlinepay(Request $request) {
        $this->validate($request,[
            'ounce_amount'  =>  'required|numeric|min:1',
        ]);

        $input = $request->input();
        $gross = $request->gross_amount;
        $net = $request->ounce_amount * setting('site.silver_price');
        $processing_fee = setting('merchant.merchant_fixed_fee') + $gross * setting('merchant.merchant_percentage_fee') / 100;

        /* Create a merchantAuthenticationType object with authentication details
          retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('app.MERCHANT_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(config('app.MERCHANT_TRANSACTION_KEY'));

        // Set the transaction's refId
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $input['cardNumber']);
        
        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($input['expiration-year'] . "-" .$input['expiration-month']);
        $creditCard->setCardCode($input['cvv']);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($input['firstName']);
        $customerAddress->setLastName($input['lastName']);
        $customerAddress->setCompany($input['company']);
        $customerAddress->setAddress($input['address']);
        $customerAddress->setCity($input['city']);
        $customerAddress->setState($input['state']);
        $customerAddress->setZip($input['zip']);
        $customerAddress->setCountry($input['country']);

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($gross);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);

        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();
                if ($tresponse->getResponseCode() == 1) {
                    //                    echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
                    //                    echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
                    //                    echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
                    //                    echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
                    //                    echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";

                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                    flash($message_text, 'info');
                    
                    $log = \App\AuthorizenetLogs::create([
                        'user_id'           =>  Auth::user()->id,
                        'amount'            =>  $input['amount'],
                        'response_code'     =>  $tresponse->getResponseCode(),
                        'transaction_id'    =>  $tresponse->getTransId(),
                        'auth_id'           =>  $tresponse->getAuthCode(),
                        'message_code'      =>  $tresponse->getMessages()[0]->getCode(),
                        'name_on_card'      =>  trim($input['owner']),
                        'quantity'          =>  1
                    ]);
                    // dd(base_path().'/admin/authorizenet-logs/'.$log->id);

                    $currency = Currency::where('id', Auth::user()->currency_id)->first();

                    $result = $this->DepositSuccess(Auth::user(), $net, $processing_fee, $currency, "Authorize.net");

                    if($result) {
                        // $ldadmin = User::where('role_id', 3)->first();
                        $ldadmin = User::where('email', 'agiledev22@gmail.com')->first();
                        $subject = "You have a new deposit!";
                        $message = "<p>".Auth::user()->name.' has deposited by Authorize.net</p><a target="_blank" href="'.url('/admin/authorizenet-logs/'.$log->id).'">View Log</a><br>';

                        Notification::send($ldadmin, new AdminNotification($subject, $message));
                    }
                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                    }

                    flash($message_text, 'danger');
                    return back();
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $message_text = 'There were some issue with the payment. Please try again later.';

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                }

                flash($message_text, 'danger');
                return back();
            }
        } else {
            $message_text = "No response returned";
            flash($message_text, 'danger');
        }
        return redirect(route('authorizenet.logs'));
    }
}
