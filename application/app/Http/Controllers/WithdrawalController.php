<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use Hash;
use App\User;
use App\Mail\Withdrawal\withdrawalRequestUserEmail;
use App\Mail\Withdrawal\withdrawalRequestAdminNotificationEmail;
use App\Mail\Withdrawal\withdrawalCompletedUserNotificationEmail;
use App\Models\Transaction;
use App\Models\Currency;
use App\Models\Wallet;  
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Models\WithdrawalMethod;

class WithdrawalController extends Controller
{
   
    public function index(Request $request){
    	$withdrawals = Withdrawal::with(['Method','Status'])->where('user_id', Auth::user()->id)->orderby('id', 'desc')->paginate(10);
    	return view('withdrawals.index')
    	->with('withdrawals', $withdrawals);

    }

    public function getWithdrawalRequestForm(Request $request, $method_id = false){

    	$methods = Auth::user()->currentCurrency()->WithdrawalMethods()->get();
        if ($method_id) {

            $current_method = WithdrawalMethod::where('id', $method_id)->first();

            if ($current_method == null) {
                dd('please contact admin to link a withdrawal method to '.Auth::user()->currentCurrency()->name.' currency');
            }
        } else {
            if (isset($methods[0]) ) {
               $current_method = $methods[0];
            } else{
                dd('please contact admin to link a withdraw method to '.Auth::user()->currentCurrency()->name.' currency');
            }
        }
        
        $currencies = Currency::where('id' , '!=', Auth::user()->currentCurrency()->id)->get();

    	return view('withdrawals.withdrawalRequestForm')
    	->with('current_method', $current_method)
        ->with('currencies', $currencies)
    	->with('methods', $methods);
    }

    public function makeRequest(Request $request){
      
        $wallet = Wallet::where('user_id', Auth::user()->id)->where('currency_id', Auth::user()->currentCurrency()->id)->first();

        $this->validate($request, [
            'withdrawal_method' => 'integer|exists:withdrawal_methods,id',
            'platform_id' => 'required',
            'withdrawal_currency'   =>  'required|integer|exists:currencies,id',
            'amount'   =>  'required|numeric',
            'ounce'    =>   'required|numeric'
        ]);

        $current_currency_amount = Auth::user()->balance * $request->price;

        if(Auth::user()->balance < $request->ounce){
           flash(__('your balance is not enouth to withdrawal '. $request->ounce) , 'danger');
            return  back();
        }

        $currency = Auth::user()->currentCurrency();

        if ( $currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        if ( Auth::user()->account_status == 0 ) {
            flash(__('Your account is under a withdrawal request review proccess. Please wait until your request is complete in a few minutes to continue with your activities.') , 'danger');
             return  back();
        }
        $current_method = WithdrawalMethod::findOrFail($request->withdrawal_method);
        if ($request->amount > $current_currency_amount) {
            flash(__('You have insufficient funds to send').' <strong>'.$request->amount.'</strong>'.Auth::user()->currentCurrency()->code.__(' to').' <strong>'.$request->platform_id .'</strong>', 'danger');
            return  back();
        }

        
       
        if( $currency->is_crypto == 1) {
            $fee = bcadd(bcmul(''.($current_method->percentage_fee/100), $request->amount, $precision ) , /*$current_method->fixed_fee*/ 0, $precision ); 
        } else {
            $fee = $current_method->percentage_fee / 100 + $current_method->fixed_fee;
        }
        
        $withdrawal = Withdrawal::create([
            'user_id'   =>  Auth::user()->id,
            'transaction_state_id'  =>  3,
            'withdrawal_method_id'  =>  $request->withdrawal_method,
            'platform_id'  =>  $request->platform_id,
            'send_to_platform_name' =>  $current_method->method_identifier_field__name,
            'gross' =>  $request->amount,
            'fee'   =>  $fee,
            'metal_value'   => $request->ounce,
            'currency_id'   =>  Auth::user()->currentCurrency()->id,
            'currency_symbol'   =>  Auth::user()->currentCurrency()->symbol,
            'wallet_id' => $wallet->id,
            'net'   =>  $request->amount - $fee,
        ]);

        // Send Alert to Admin 
        Mail::send(new withdrawalRequestAdminNotificationEmail($withdrawal, Auth::user()));

        //Send new deposit request notification Mail to user
        Mail::send(new withdrawalRequestUserEmail( $withdrawal, Auth::user()));

        return redirect(route('withdrawal.index'));
   }

   public function cancel($id)
   {
    $withdrawal = Withdrawal::find($id);
    $withdrawal->transaction_state_id = 2;
    $withdrawal->save();
    return back();
   }

    public function confirmWithdrawal(Request $request){

        if (!Auth::user()->isAdministrator()) {
            abort (404);
        }

        $withdrawal = Withdrawal::with('Method')->findOrFail($request->id);
     //   echo "<pre>"; print_r($withdrawal); die;
        if ($withdrawal->transaction_state_id != 3 ) {
            flash(__('Transaction Already completed !'), 'info' );
            //return redirect(url('/').'/admin/withdrawals/'.$withdrawal->id);

            return back();
        }

        $user = User::findOrFail($request->user_id);

        $wallet = Wallet::where('user_id', $user->id)->where('currency_id',$user->currentCurrency()->id)->first();

        $currency = $user->currentCurrency();

        if ( $currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        if ($user->balance < $withdrawal->metal_value) {
            flash('User doesen\'t have enought funds to withdraw '.$withdrawal->gross.' $', 'danger' );

            return back();
        }

        if($request->transaction_state_id == 1 ){
            
            $wallet->amount = bcsub($wallet->amount, $withdrawal->gross, $precision);

        }
        $ldadmin = User::where('role_id',3)->first();
        $user->RecentActivity()->save($withdrawal->Transactions()->create([
            'user_id' => $user->id,
            'entity_id'   =>  $user->id,
            'entity_name' =>  $withdrawal->Method->name,
            'transaction_state_id'  =>  $request->transaction_state_id, // waiting confirmation
            'money_flow'    => '-',
            'activity_title'    =>  'Withdrawal',
            'balance'   =>   $wallet->amount,
            'thumb' =>  $withdrawal->Method->thumb,
            'gross' =>  $withdrawal->gross,
            'fee'   =>  $withdrawal->fee,
            'net'   =>  $withdrawal->net,
            'metal_value'   => $withdrawal->metal_value,
            'currency_id'   =>  $withdrawal->currency_id,
            'currency_symbol'   =>  $withdrawal->currency_symbol,
        ]));
        
        $withdrawal->transaction_state_id = $request->transaction_state_id;
        $user->balance = $user->balance - $withdrawal->metal_value;
        $ldadmin->balance = $ldadmin->balance + $withdrawal->metal_value;

        $ldadmin->RecentActivity()->save($withdrawal->Transactions()->create([
            'user_id' => $ldadmin->id,
            'entity_id'   =>  $withdrawal->id,
            'entity_name' =>  $withdrawal->Method->name,
            'transaction_state_id'  =>  $request->transaction_state_id, // waiting confirmation
            'money_flow'    => '+',
            'activity_title'    =>  'Receive Withdrawal',
            'balance'   =>   $ldadmin->balance,
            'thumb' =>  $withdrawal->Method->thumb,
            'gross' =>  $withdrawal->gross,
            'fee'   =>  $withdrawal->fee,
            'net'   =>  $withdrawal->net,
            'metal_value'   => $withdrawal->metal_value,
            'currency_id'   =>  $withdrawal->currency_id,
            'currency_symbol'   =>  $withdrawal->currency_symbol,
        ]));

        $withdrawal->save();
        $user->account_status = 1;
        $wallet->save();
        $user->save();
        $ldadmin->save();

        //Send Notification to User
        Mail::send(new withdrawalCompletedUserNotificationEmail($withdrawal, $user));
        
        return redirect(url('/').'/admin/withdrawals');        
    }
}
