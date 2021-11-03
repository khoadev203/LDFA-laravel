<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use App\Models\Voucher;
use App\User;
use PayPal;
use App\Models\Sale;
use App\Models\Wallet;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Receive;
use App\Models\Send;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;

use Notification;
use App\Notifications\AdminNotification;

class PayPalController extends Controller
{
	protected $provider; 

	public function __construct()
    {

    }

    public function buyvoucher(Request $request) {
    	$user = Auth::user();
        //$user->currency_id = 1;
        $user->save();
        return view('paypal.buyvoucher');
    }

    public function sendRequestToPayPal(Request $request)
    {
        $this->validate($request,[
            'amount'  =>  'required|integer|min:1',
        ]);
        
        $total = $request->amount;
      	
      	$data['items'] = [
            [
                'name' => 'Voucher',
                'price' => $this->Money($request->amount),
                'qty' => 1
            ]
        ];

        $data['invoice_id'] = time();
        $data['invoice_description'] = "Order ".time()." Invoice";

        $data['return_url'] = url('pay/voucher/paypal/success');
        $data['cancel_url'] = url('pay/voucher/paypal/cancel');

        // $total = 0;
        // foreach($data['items'] as $item) {
        //     $total += $item['price']*$item['qty'];
        // }

        $user = Auth::user();
        $currency = Auth::user()->currentCurrency()->code;
		Config::set('paypal.currency', $currency);

       	$this->provider = PayPal::setProvider('express_checkout'); 

        $data['total'] = $this->Money($total);
        $response = $this->provider->setExpressCheckout($data);
        // dd($data);
    	// dd($this->provider);

        session()->put(['cart' => $data ]);
        return redirect($response['paypal_link']);
    }
    

    public function paySuccess(Request $request)
    {
    	if ($request->get('PayerID') and $request->get('token')) {

			$user = Auth::user();

			$token = $request->get('token');
    		
    		$PayerID = $request->get('PayerID');
    		$user = Auth::user();
	        $currency = Auth::user()->currentCurrency()->code;
			Config::set('paypal.currency', $currency);
	       	$this->provider = PayPal::setProvider('express_checkout'); 
	    	$response = $this->provider->getExpressCheckoutDetails($token);

    		if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
    			
	            // Perform transaction on PayPal
	            
	            $payment_status = $this->provider->doExpressCheckoutPayment(session()->get('cart'), $token, $PayerID);
	            
	            if( ! isset($payment_status['PAYMENTINFO_0_PAYMENTSTATUS']) &&  ! array_key_exists('PAYMENTINFO_0_PAYMENTSTATUS', $payment_status))
				{
					flash('Something went wrong !', 'danger');
					return redirect('/home'); 
				}

	            $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];

	           	if ($status == 'Completed') {

	           		$initial_fee = (float)$payment_status['PAYMENTINFO_0_FEEAMT'];

	           		$voucherValue = (float)$payment_status['PAYMENTINFO_0_AMT'] - $initial_fee;

	           		$wallet = Auth::user()->currentWallet();

					$this->DepositSuccess($user, $voucherValue, $initial_fee, $wallet->currency);

	           	}
	           	
	        	session()->forget('cart');
	            return redirect('/home');
        	}
    	}
    }

    public function payButtonSuccess(Request $request)
    {
    	$this->validate($request,[
            'ounce_amount'  =>  'required|numeric|min:1',
        ]);

    	$user = Auth::user();

   		$voucherValue = $request->ounce_amount * setting('site.silver_price');
   		$gross = $request->gross_amount;
   		$paypal_fee = setting('merchant.merchant_fixed_fee') + $gross * setting('merchant.merchant_percentage_fee') / 100;

   		$wallet = Auth::user()->currentWallet();

		$result = $this->DepositSuccess($user, $voucherValue, $paypal_fee, $wallet->currency, 'Paypal');

		if($result){
	        // $ldadmin = User::where('role_id', 3)->first();
	        $ldadmin = User::where('email', 'agiledev22@gmail.com')->first();
	        $subject = "You have a new deposit!";
	        $message = "<p>".Auth::user()->name.' has requested Paypal deposit.</p><a target="_blank" href="'.url('/admin/transactionable').'">View Transactions</a><br>';

	        Notification::send($ldadmin, new AdminNotification($subject, $message));

			flash('Thank you for the payment!');
			return redirect('/home');
		}
		else {
			flash('Something went wrong!', 'danger');
			return back();
		}
    }

    public function postStoreFront(Request $request)
    {	
    	$this->validate($request,	[
    		'ref'	=>	'required',
    	]);

    	$user = Auth::user();
		        $currency = Auth::user()->currentCurrency()->code;
				Config::set('paypal.currency', $currency);
		       $this->provider = PayPal::setProvider('express_checkout'); 

    	$sale_fee = ((setting('merchant.merchant_percentage_fee')/100)* (float)session()->get('PurchaseRequestTotal')) + setting('merchant.merchant_fixed_fee') ; 

        $minimum = (float)session()->get('PurchaseRequestTotal') +  $sale_fee;

        if ((float)session()->get('PurchaseRequestTotal') - $sale_fee <= 0 ) {
            
            flash(__('We only support invoices with a total greater than ').$minimum.$currency->symbol, 'danger');
            return  back();
        }

    	$PurchaseRequest = PurchaseRequest::with('Transaction')->with('Currency')->where('ref', $request->ref)->first();

        if($PurchaseRequest == null)
        	return abort(404);

    	if ($PurchaseRequest->Currency->id != 10) {
    		dd('PayPal only supports US Dollar ( USD ). Please Return back and use Your Wallet or another tird part');
    	}

    	if ( ( $PurchaseRequest != null and $PurchaseRequest->is_expired == false ) or session()->has('PurchaseRequest')) {
            $total = 0;

            $merchant = Merchant::where('merchant_key', $PurchaseRequest->merchant_key)->first();
            
            if($merchant == null)
            return abort(404);
            $data['items'] = [];
            foreach ($PurchaseRequest->data->items as $item) {
            	array_push($data['items'], (array) $item);
               	$total += ( $item->price * $item->qty );
            }

            /*
            $PayPalHandlingFee = (( $total * 4.4 ) / 100 ) + 2 ;

            $total += $PayPalHandlingFee ;
           
            array_push($data['items'], [ "name" => "handling fee", "price" => $PayPalHandlingFee , "qty" => 1, "description" => "PayPal handling fee ( 4.4% + 2$ ) " ]);
			*/


            $data['invoice_id'] = time();
	        $data['invoice_description'] = "Payment for ".setting('site-title')."'s Purchase Ref#". $request->ref;

	        $data['return_url'] = url('/merchant/storefront/paypal/success?ref='.$request->ref);
	        $data['cancel_url'] = url('/merchant/storefront/paypal/cancel');

	        // $total = 0;
	        // foreach($data['items'] as $item) {
	        //     $total += $item['price']*$item['qty'];
	        // }

	        $data['total'] = $this->Money($total);

	        $response = $this->provider->setExpressCheckout($data);
	        session()->put(['cart' => $data ]);

	        return redirect($response['paypal_link']);
        }
        /*
     	session()->put('PurchaseRequest', $PurchaseRequest);
        session()->put('PurchaseRequestTotal', $total);

        if( $PurchaseRequest->is_expired == false ){
            $PurchaseRequest->is_expired = true ;
            $PurchaseRequest->save();
        }
    	dd($request);
    	*/

    }

    public function postStoreFrontSuccess(Request $request)
    {

    	if ($request->get('PayerID') and $request->get('token') and $request->get('ref')) {

    		$PurchaseRequest = PurchaseRequest::with('Transaction')->with('Currency')->where('ref', $request->ref)->first();

    		$currency = Currency::where('code', $PurchaseRequest->currency_code)->first();

    		if ($currency == null) {
    			return abort(404);
    		}

	        if($PurchaseRequest == null)
	        return abort(404); 

	    	
		    if( $PurchaseRequest->is_expired == true ){
		    	return abort(404); 
	        }
	        
    			$token = $request->get('token');
	    		
	    		$PayerID = $request->get('PayerID');
		    	
		    	$response = $this->provider->getExpressCheckoutDetails($token);
		    
	    		if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
	    			
		            // Perform transaction on PayPal
		            
		            $payment_status = $this->provider->doExpressCheckoutPayment(session()->get('cart'), $token, $PayerID);
		            
		            if( ! isset($payment_status['PAYMENTINFO_0_PAYMENTSTATUS']) &&  ! array_key_exists('PAYMENTINFO_0_PAYMENTSTATUS', $payment_status))
						{
							flash('Something went wrong !', 'danger');
							return redirect('/home'); 
						}
						
		            $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
		          
		           if ($status == 'Completed') {
		           		
		           		$merchant = Merchant::with('User')->where('merchant_key',session()->get('PurchaseRequest')->merchant_key)->first();

		           		$wallet = Wallet::where('user_id', $merchant->User->id)->where('currency_id', $currency->id)->first();

		           		$sale_fee = ((setting('merchant.merchant_percentage_fee')/100)* (float)session()->get('PurchaseRequestTotal')) + setting('merchant.merchant_fixed_fee') ; 
		           		
		           		$wallet->amount = $wallet->amount + (float)$payment_status['PAYMENTINFO_0_AMT'] - (float)$payment_status['PAYMENTINFO_0_FEEAMT']; ;

				    	$wallet->save();

		           		$sale = Sale::create([
				          'user_id' =>  $merchant->User->id,
				          'merchant_id' =>  $merchant->id, 
				          'purchase_id' =>  0,
				          'transaction_state_id'  =>  1,
				          'gross' =>  (float)session()->get('PurchaseRequestTotal'),
				          'fee' =>  $sale_fee, 
				          'net' =>  (float)session()->get('PurchaseRequestTotal') - $sale_fee,
				          'currency_id' =>  $currency->id,
				          'currency_symbol' =>  $currency->symbol,
				          'json_data' =>  json_encode($PurchaseRequest->data)
				        ]);

				        $merchant->User->RecentActivity()->save($sale->Transactions()->create([
				            'user_id' => $sale->user_id,
				            'entity_id'   =>  $merchant->id,
				            'entity_name' =>  $merchant->name,
				            'transaction_state_id'  =>  1, // waiting confirmation
				            'money_flow'    => '+',
				            'currency_id' =>  $currency->id,
				            'currency_symbol' =>  $currency->symbol,
				            'thumb' =>  url('/').'/storage/imgs/N7EVK0hQpVT3p0PrB95QIufkOOOmKXQ2WqiO2sPi.png',
				            'activity_title'    =>  'Sale',
				            'gross' =>  $sale->gross,
				            'fee'   =>  $sale->fee,
				            'net'   =>  $sale->net,
				            'balance'	=>	$wallet->amount,
				            'request_id'  =>  $PurchaseRequest->id,
				            'json_data' =>  json_encode($PurchaseRequest->data),
				        ]));


				        return redirect( http_build_url($PurchaseRequest->data->return_url, array("query" => "token=$PurchaseRequest->ref"), HTTP_URL_JOIN_QUERY));
		           }

		           	session()->forget('cart');
		           	$PurchaseRequest->is_expired = true ;
	        		$PurchaseRequest->save();
    		
		            dd($response);

	        	}
    		
    	}

    }

    public function postStoreFrontCancel(Request $request)
    {

    }

    private function Money($value)
    {
    	return number_format((float)$value, 2, '.', '');
    }
}