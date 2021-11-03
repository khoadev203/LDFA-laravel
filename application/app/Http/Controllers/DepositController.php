<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Mail;
use App\Models\Deposit;
use App\Mail\Deposit\depositCompletedUserNotificationEmail;
use App\Models\Wallet;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    public function myDeposits(Request $request) {
        
        $deposits = Deposit::with('Method')->where('user_id', Auth::user()->id)->orderby('created_at', 'desc')->paginate(10);
        return view('deposits.index')->with('deposits', $deposits);
    }

    public function confirmDeposit(Request $request) {
        
        if (!Auth::user()->isAdministrator()) {
            abort (404);
        }

        $deposit = Deposit::with('Method')->findOrFail($request->id);

        if (   $deposit->transaction_state_id == 1   ) {
            return redirect(url('/').'/admin/deposits/'.$deposit->id);
        }

        $user = User::findOrFail($request->user_id);

        $wallet = Wallet::where('user_id', $user->id)->where('currency_id', $deposit->currency_id)->first();

        $currency = Currency::where('id', $deposit->currency_id)->first();

        if ( $currency->is_crypto == 1 ) {
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        $wallet->amount = (float)(bcadd(''.$user->balance, ''.$request->gross, $precision));

        $user->RecentActivity()->save($deposit->Transactions()->create([
            'user_id' => $user->id,
            'entity_id'   =>  $user->id,
            'entity_name' =>  $deposit->Method->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '+',
            'activity_title'    =>  'Deposit',
            'balance'   =>   $user->balance,
            'currency_id'   =>  $deposit->currency_id,
            'currency_symbol'   =>  $deposit->currency_symbol,
            'thumb' =>  $deposit->Method->thumb,
            'gross' =>  $request->gross,
            'fee'   =>  0,
            'net'   =>  $request->gross
        ]));

        $deposit->gross = $request->gross;
        $deposit->fee = 0;
        $deposit->net = $request->gross;
        $deposit->transaction_state_id = 1;

        $deposit->save();
        $wallet->save();

        Mail::send(new depositCompletedUserNotificationEmail( $deposit, $user));
        
        return redirect(url('/').'/admin/deposits/'.$deposit->id);

    }
}
