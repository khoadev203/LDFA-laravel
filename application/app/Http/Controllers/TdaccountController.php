<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Tdaccount;
use App\TdaccountUser;
use App\TdaccountTransaction;
use App\Models\Currency;

use Illuminate\Http\Request;
use DateTime;
use Mail;
use App\Mail\generalNotification;


class TdaccountController extends Controller
{
	public function index($id)
	{
		$account = Tdaccount::find($id);
		$str_term = $account->terms_month;
		$terms = explode(",", $str_term);

		$tdaccount_user = TdaccountUser::where('user_id', Auth::user()->id)
							->where('tdaccount_id', $id)
							->first();
		$transactions = null;

		if( ! is_null($tdaccount_user))
		{
			$transactions = $tdaccount_user->transactions()
								->with('currency')
								->get();
		}


		return view('tdaccounts.index')
					->with('tdaccount', $account)
					->with('transactions', $transactions)
					->with('tdaccount_user', $tdaccount_user)
					->with('terms', $terms);
	}

	public function overview()
	{
		$tdaccounts = Tdaccount::get();
		return view('tdaccounts.overview')
			->with('tdaccounts', $tdaccounts);
	}

	public function withdraw(Request $request)
	{
		$user_id = Auth::user()->id;
		$tdaccount_id = $request->tdaccount_id;
		$tdaccount_user = TdaccountUser::where('user_id', $user_id)
						->where('tdaccount_id', $tdaccount_id)
						->first();

		if(is_null($tdaccount_user))
			return back();

		if($request->ounce > $tdaccount_user->balance)
		{
			flash('You don\'t have enough balance!', 'danger');
			return back();
		}

		$tdaccount_trasaction = TdaccountTransaction::create([
			'tdaccount_user_id'	=> $tdaccount_user->id,
			'currency_id'	=> Auth::user()->currency_id,
			'amount'	=> -$request->amount,
			'metal_value'	=> -$request->ounce
		]);

		$tdaccount_user->balance = $tdaccount_user->balance - $request->ounce;
		$tdaccount_user->save();

		$credited_ounce = number_format($request->ounce * (100 - $request->penalty_rate) / 100, 2, '.', '');
		Auth::user()->balance = Auth::user()->balance + $credited_ounce;
		Auth::user()->save();

		flash('You have successfully withdrawn '.$request->ounce.' ounces from this TD account!<br>'.$credited_ounce.' ounces have been credited to the main account!');

		return back();

	}

	public function deposit(Request $request)
	{
		$user_id = Auth::user()->id;
		$tdaccount_id = $request->tdaccount_id;

		$tdaccount_user = TdaccountUser::where('user_id', $user_id)
						->where('tdaccount_id', $tdaccount_id)
						->first();

		if(Auth::user()->balance < $request->ounce) {
			return back();//show error dialog here...
		}

		if(is_null($tdaccount_user)) {
			$tdaccount_user = TdaccountUser::create([
				'user_id'	=> $user_id,
				'tdaccount_id'	=> $tdaccount_id,
				'term_joined'	=>	$request->term_joined
			]);
		}

		// dd($tdaccount_user);

		$tdaccount_trasaction = TdaccountTransaction::create([
			'tdaccount_user_id'	=> $tdaccount_user->id,
			'currency_id'	=> Auth::user()->currency_id,
			'amount'	=> $request->amount,
			'metal_value'	=> $request->ounce
		]);

		$tdaccount_user->balance = $tdaccount_user->balance + $request->ounce;
		$tdaccount_user->save();

		Auth::user()->balance = Auth::user()->balance - $request->ounce;
		Auth::user()->save();

		flash('You have successfully deposited '.$request->ounce.' ounces to this TD account!');

		return back();
	}

	public function sendLoanApplication(Request $request)
	{
	    $this->validate($request, [
	    	'amount'	=>	'required|numeric',
            'name'    	=>  'required',
            'address'   =>  'required',
            'contact' 	=>  'required',
            'purpose'	=>  'required',
            'time' 		=>  'required'
        ]);

	    $message = array();

	    array_push($message, "Amount: " . $request->amount);
	    array_push($message, "Name: " . $request->name);
	    array_push($message, "Address: " . $request->address);
	    array_push($message, "Phone or Skype ID: " . $request->contact);
	    array_push($message, "Purpose of Loan: " . $request->purpose);
	    array_push($message, "Best time to call: " . $request->time);

	    $ldadmin = User::where('role_id', 3)->first();

	    Mail::send(new generalNotification( "You received a loan application!", $message, $ldadmin->email));

	    flash('You submitted a loan application!');

	    return back();
	}

	public function checkMonthlyInterest()
	{
		$tdaccounts = TdaccountUser::all();
		$ldadmin = User::where('role_id', 3)->first();
		$currency = Currency::where('code', 'USD')->first();
		$silver_price = setting('site.silver_price');

		foreach($tdaccounts as $td)
		{
			// dd($td->account->interest_rate);

			$user = User::find($td->user_id);

			$balance_mv = $td->balance * $silver_price;

			$send_gross = $receive_gross = $balance_mv * $td->account->interest_rate / 100;
			$send_fee = $receive_fee = 0;
			$send_ounce = $td->balance * $td->account->interest_rate / 100;


			$from_date = new DateTime($td->got_interest_at);
			$today = new DateTime(date('Y-m-d H:i:s'));
			$interval = $from_date->diff($today)->format('%a');
			
			if(is_null($td->got_interest_at) || $interval >= 28) {
		        $result = $this->TransferMoney(
		            $ldadmin,
		            $user,
		            $currency,
		            1,
		            $send_gross,
		            $send_fee,
		            $receive_gross,
		            $receive_fee,
		            $send_ounce,
		            $send_ounce,
		            2,
		            "Interest from ".$td->account->name." account"
		        );

		        if($result) {
	    	        $ldadmin->balance -= $send_ounce;
			        $user->balance += $send_ounce;

			        $ldadmin->save();
			        $user->save();

			        $td->got_interest_at = $today;
			        $td->save();
		        }
			}
		}
	}
}