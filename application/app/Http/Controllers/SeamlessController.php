<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Voucher;
use App\Models\Wallet;
use App\Models\Currency;
use App\Models\Deposit;
use \Seamless\Seamless;
use Illuminate\Http\Request;

class SeamlessController extends Controller
{
     public function buyvoucher(Request $request) {
    	$user = Auth::user();
        $user->currency_id = 1;
        $user->save();

        return view('seamless.buyvoucher');
    }

    public function sendRequestToSeamless(Request $request) {
    	$this->validate($request, [
            'amount'  =>  'required|integer|min:1',
        ]);

    	$user = Auth::user();

    	try {
			$curl = curl_init();

			curl_setopt_array ($curl, array(
			  CURLOPT_URL => "https://api.seamlesschex.com/v1/check/create",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => false,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_HTTPHEADER => array(
			    "Content-Type: application/json",
			    "Authorization: sk_live_01f51medxw2hfqt10z2zs61mt2"
			  ),
			  CURLOPT_POSTFIELDS => '{
			  		"number"				:	"'.$request->number.'",
				    "name"					:	"'.$user->name.'",
				    "amount"				:	'.$request->amount.',
				    "memo"					:	"'.$request->memo.'",
				    "email"					:	"'.$user->email.'",
				    "bank_account"			:	"'.$request->bank_account.'",
				    "bank_routing"			:	"'.$request->bank_routing.'",
				    "verify_before_save"	:	true,
				    "fund_confirmation"		:	false
				  }'
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				flash(__('Oops, something went wrong... Please contact to support if this error persists !'), 'danger');
				return back();
			} else {
				$response = json_decode($response);

				if(property_exists($response, 'error'))
				{
					flash($response->message, 'danger');
					return back();
				}

			  	if($response->check->basic_verification->risk_bv != "Pass" || $response->check->basic_verification->pass_bv != 1) {
			  		flash($response->check->basic_verification->description_bv, 'danger');
					return back();
			  	}
			}

			$currency = Currency::where('id', $user->currency_id)->first();

			$result = $this->DepositSuccess($user, $response->check->amount, 0, $currency);

			if($result) {
				Deposit::create([
					'user_id'				=>	$user->id,
					'transaction_state_id'	=>	1,
					'gross'					=>	$response->check->amount,
					'fee'					=>	0,
					'net'					=>	$response->check->amount,
					'currency_id'			=>	$currency->id,
					'currency_symbol'		=>	$currency->symbol,
					'message'				=>	$request->memo,
					'deposit_type'			=>	'Seamless Chex',
					'transaction_receipt'	=>	$response->check->paper,
					'deposit_method_id'		=> 	1,//just for default value
					'wallet_id'				=>	1
				]);

	    		flash('Payment Success!');
			}

    		return redirect('/home');

    	} catch(\Exception $e) {
    		dd($e);
    	}
    }
}