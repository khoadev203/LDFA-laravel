<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Voucher;
use App\Models\Wallet;
use App\Models\Currency;
use Illuminate\Http\Request;

class SquareController extends Controller
{
     public function buyvoucher(Request $request){
    	$user = Auth::user();
        $user->currency_id = 1;
        $user->save();
        return view('square.buyvoucher');
    }

    public function sendRequestToSquare(Request $request){
    	  $this->validate($request,[
            'amount'  =>  'required|integer|min:1',
            'squareToken'	=>	'required'
        ]);

    	$fee = (( $request->amount * 3.99 ) / 100 ) + 0.5 ;
    	$amount_without_fees = $request->amount - $fee ;

    	$access_token = ($_ENV['SQUARE_SECRET_KEY']);
		$api_config = new \SquareConnect\Configuration();
		$api_config->setHost("https://connect.sandboxsquareup.com");
		$api_config->setAccessToken($access_token);
		$api_client = new \SquareConnect\ApiClient($api_config);
		$nonce = $_POST['nonce'];
		$TPRICE = $_POST['amount'];	
		$payments_api = new \SquareConnect\Api\PaymentsApi($api_client);
		$request_body = array (
		  "source_id" => $nonce,
		  "amount_money" => array (
		    "amount" => $request->amount * 100,
		    'currency'	=> 'usd',
		    'source' => $request->squareToken,
		    'description' => 'sample discription',
		  ),
		  "idempotency_key" => uniqid()
		);
    	// Square fee 3.99% + R$0.50;


    	try{
		$result = $payments_api->createPayment($request_body);
		
	    	$wallet = Auth::user()->currentWallet() ;
		           		
       		$voucherValue = (float)$amount_without_fees;

       		$voucher = Voucher::create([
	            'user_id'   =>  Auth::user()->id,
	            'voucher_amount'    =>  $request->amount,
	            'voucher_fee'   =>  $fee,
	            'voucher_value' =>  $voucherValue,
	            'voucher_code'  =>  Auth::user()->id.str_random(4).time().str_random(4),
	            'currency_id'   =>  $wallet->currency->id,
	            'currency_symbol'   =>  $wallet->currency->symbol,
	            'wallet_id' =>  $wallet->id
	        ]);

	        $wallet->amount = $wallet->amount + $voucherValue ;

	    	$voucher->user_loader = Auth::user()->id;
	    	
	    	$voucher->is_loaded = 1 ;

	    	$voucher->save();

	    	$wallet->save();

	        Auth::user()->RecentActivity()->save($voucher->Transactions()->create([
	            'user_id' =>  Auth::user()->id,
	            'entity_id'   =>  $voucher->id,
	            'entity_name' =>  $wallet->currency->name,
	            'transaction_state_id'  =>  1, // waiting confirmation
	            'money_flow'    => '+',
	            'activity_title'    =>  'Voucher Load',
	            'thumb'	=>	$wallet->currency->thumb,
	            'currency_id' =>  $voucher->currency_id,
	            'currency_symbol' =>  $voucher->currency_symbol,
	            'gross' =>  $request->amount,
	            'fee'   =>  $fee,
	            'net'   =>  $voucherValue,
	            'balance'	=>	$wallet->amount,
	        ]));

    		flash('Payment Success');
    		return redirect('/home');

    	}catch(\Exception $e){
    		dd($e);
    	}
    }
}
