<?php

namespace TCG\Voyager\Http\Controllers;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use App\ldbalance;
use App\Models\Transaction;
use App\Models\Currency;
use App\User;
use Illuminate\Support\Facades\Auth;

class VoyagerLdbalanceController extends Controller
{
	public function index(Request $request) {
		$input = $request->all();

		$user = Auth::user();
		if(!empty($input)) {
			$description = '';
			if($input['description'] != '') {
				$description = $input['description'];
			}

			$currency_type = '';
			if( $input['type'] == 'ounce') {
				$currency_type = Auth::user()->currentCurrency()->code;
				
			} else {
				$currency_type = 'ounce';
			}

			$ldbalance = ldbalance::create([
				'user_id' => Auth::user()->id,
				'amount' => $input['amount'],
				'type' => $input['type'],
				'other_currency_amount' => $input['fixedamount'].' '.$currency_type,
				'description' => $input['description'],

			]);

			$currency = Currency::where('id' , $user->currency_id)->first();

			$masteruser = User::where('role_id', 3)->first();
			$masteruser->balance = $masteruser->balance + $input['amount'];
			$masteruser->save();

			// $user->RecentActivity()->save($ldbalance->Transactions()->create([
			// 	'user_id' => $user->id,
			// 	'entity_id'   =>  $ldbalance->id,
			// 	'entity_name' =>  Auth::user()->name,
			// 	'transaction_state_id'  =>  1, 
			// 	'money_flow'    => '+',
			// 	'currency_id' =>  $user->currency_id,
			// 	'thumb' =>  Auth::user()->avatar,
			// 	'currency_symbol' =>  $currency->symbol,
			// 	'activity_title'    =>  'LDFAdmin Balance',
			// 	'gross' =>  0,
			// 	'fee'   =>  0,
			// 	'net'   =>  0,
			// 	'metal_value'   =>  0,
        	// ]));



			 return redirect()->route('voyager.LDBalance.history');
		}
		$rate = getMetalPrices('SILVER', Auth::user()->currentCurrency()->code)[Auth::user()->currentCurrency()->code];
		return Voyager::view('voyager::LDBalance.index', compact('rate'));
	}

	public function history() {
		$getdata = ldbalance::paginate(5);
		return Voyager::view('voyager::LDBalance.history', compact('getdata'));
	}
}
?>