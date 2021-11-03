<?php

namespace App\Http\Controllers;
use Auth;
use Storage;
use App\User;
use App\Models\Send;
use App\Models\Currency;
use App\Models\Receive;
use App\Models\Transaction;
use Validator;
use Illuminate\Http\Request;

class MoneyTransferController extends Controller
{
    public function sendMoneyForm(Request $request){
        //$currencies = Currency::where('id' , '!=', Auth::user()->currentCurrency()->id)->get();
        $currencies = Currency::get();

        //$codes = [];
        //foreach($currencies as $currency)
        //{
            // if(! $currency->is_crypto)
                //array_push($codes, $currency->code);
                //crypto case should be taken care here
        //}
        //$codes_str = implode(",", $codes);

        // dd($codes_str);
        $code = Auth::user()->currentCurrency()->code;
        $metalPrice = setting('site.silver_price');
        return view('sendmoney.index')
        ->with('currencies', $currencies)
        ->with('metalPrice', $metalPrice);
    }

    public function requestMoneyForm(Request $request){
        //$currencies = Currency::where('id' , '!=', Auth::user()->currentCurrency()->id)->get();
        $currencies = Currency::get();
        $code = Auth::user()->currentCurrency()->code;
        $metalPrice = setting('site.silver_price');
        return view('requestmoney.index')
            ->with('currencies', $currencies)
            ->with('metalPrice', $metalPrice);
    }
 
    public function sendMoney(Request $request) {

        if ($request->ounce <= 0) {
            flash(__('Please insert an amount greater than 0'),'danger');
                return back();
        }

        if ($request->amount <= 0) {
            flash(__('Please insert an amount greater than 0'),'danger');
                return back();
        }
      
        $current_currency_amount = Auth::user()->balance * $request->price;
        
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
          
            $this->validate($request, [
                // 'amount'    =>  'required|numeric|between:0,'.Auth::user()->currentWallet()->amount,
                'ounce'         =>  'required|numeric',
                'description'   =>  'required|string',
                'email' =>  'required|email|exists:users,email',
            ]);

        } else {
           
            $this->validate($request, [
                // 'amount'    =>  'required|numeric|between:0,'.Auth::user()->currentWallet()->amount,
                'ounce'         =>  'required|numeric',
                'description'   =>  'required|string',
                
            ]);

            $valid_user = User::where('name', $request->email)->first();



            if (is_null($valid_user)) {

                flash(__('The Username '). $request->email .__(' is invalid'), 'danger');
                return back();
            }
        }        

        $currency = Currency::find(Auth::user()->currency_id);

        if ( $currency->is_crypto == 1 ) {
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        $auth_wallet = Auth::user()->walletByCurrencyId($currency->id);

        if((boolean)$currency == false ) {
          flash(__('Oops, something went wrong... looks like we do not support this currency. please contact support if this error persists !'), 'danger');
            return back();
        }

        if ( Auth::user()->account_status == 0 ) {
            flash(__('Your account is under a withdrawal request review proccess. please wait for a few minutes and try again') , 'info');
             return  back();
        }


        if ($request->email == Auth::user()->email) {
            flash(__('You can\'t send money to the same account you are in') , 'danger');
            return  back();
        } 

        if ($request->ounce > Auth::user()->balance) {
            flash(__('You have insufficient funds to send').' <strong>'.$request->amount.'</strong>'.Auth::user()->currentCurrency()->code.__(' to').' <strong>'.$request->email .'</strong>', 'danger');
            return  back();
        }

        if ($request->amount > $current_currency_amount) {
            flash(__('You have insufficient funds to send').' <strong>'.$request->amount.'</strong>'.Auth::user()->currentCurrency()->code.__(' to').' <strong>'.$request->email .'</strong>', 'danger');
            return  back();
        }

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
        }else {
            $user = $valid_user ;
        }
 
        if($user->id == Auth::user()->id ){
              flash(__('Not allowed to send or receive funds from your own account'), 'danger');
            return  back();
        }
        
        if(Auth::user()->isAdministrator()) {
            $send_fee = 0;
            $receive_fee = 0;
        } else
            $send_fee = $receive_fee = setting('money-transfers.mt_fixed_fee');


        $send_gross = $request->amount + $send_fee;
        $receive_gross = $request->amount;

        if ( ($request->amount - (float) $receive_fee) < 0 ) {
            flash(__('The minimum amount to send is').' <strong>'. bcsub($request->amount , $receive_fee, $precision ) .'</strong>', 'danger');
            return  back();
        }

        $result = $this->TransferMoney(
            Auth::user(),
            $user,
            $currency,
            3,
            $send_gross,
            $send_fee,
            $receive_gross,
            $receive_fee,
            $request->ounce * $send_gross / $request->amount,
            $request->ounce * ($receive_gross - $receive_fee) / $request->amount,
            $precision,
            $request->description
        );
        
        return  redirect(route('home'));

    }

    public function requestMoney(Request $request){


        if ($request->amount <= 0) {
            flash(__('Please insert an amount greater than 0'),'danger');
                return back();
        }

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
          
            $this->validate($request, [
                'amount'    =>  'required|numeric|min:2',
                'description'   =>  'required|string',
                'email' =>  'required|email|exists:users,email',
            ]);

        } else {
           
            $this->validate($request, [
                'amount'    =>  'required|numeric|between:0,'.Auth::user()->currentWallet()->amount,
                'description'   =>  'required|string',
                
            ]);

            $valid_user = User::where('name', $request->email)->first();

            if (is_null($valid_user)) {

                flash(__('The Username '). $request->email .__(' is invalid'), 'danger');
                return back();
            }
        }

        $current_currency_amount = Auth::user()->balance * $request->price;

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
        }else{
            $user = $valid_user ;
        }


         if($user->id == Auth::user()->id ){
              flash(__('Not allowed to send or receive funds from your own account'), 'danger');
            return  back();
        }
        

        $currency = Currency::find(Auth::user()->currency_id);

        if ( $currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        $auth_wallet = $user->walletByCurrencyId($currency->id);

        if((boolean)$currency == false ){
          flash(__('Oops, something went wrong... looks like we do not support this currency. Please contact support if this error persists !'), 'danger');
            return back();
        }

        if ( Auth::user()->account_status == 0 ) {
            flash( $user->name . __(' account is under a withdrawal request review proccess. Please wait for a few minutes and try again') , 'info');
             return  back();
        }


        if ($request->email == Auth::user()->email) {
            flash(__('You can\'t request money to the same account you are in') , 'danger');
            return  back();
        } 

       if ($request->ounce > Auth::user()->balance) {
            flash(__('You have insufficient funds to send ').' <strong>'.$request->amount.Auth::user()->currentCurrency()->code.__(' to ').$request->email .'</strong>', 'danger');
            return  back();
        }

        if ($request->amount > $current_currency_amount) {
            flash(__('You have insufficient funds to send').' <strong>'.$request->amount.'</strong>'.Auth::user()->currentCurrency()->code.__(' to').' <strong>'.$request->email .'</strong>', 'danger');
            return  back();
        }
        // if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
        //     $user = User::where('email', $request->email)->first();
        // }else{
        //     $user = $valid_user ;
        // }
        
        $send_fee = 0; //free to send money
         
        if($currency->is_crypto == 1 ){

            $receive_fee = bcmul(''.( setting('money-transfers.mt_percentage_fee')/100) , $request->amount , $precision ) ;

        }else if ($currency->is_crypto == 0 ) {

             $receive_fee = bcadd( bcmul(''.( setting('money-transfers.mt_percentage_fee')/100) , $request->amount , $precision ) , setting('money-transfers.mt_fixed_fee') , $precision ) ;

        }

        if ( ($request->amount - $receive_fee) < 0 ) {
            flash(__('The minimum amount to send is').' <strong>'.bcsub ( $request->amount , $receive_fee , $precision ) .'</strong>', 'danger');
            return  back();
        }

        $receive = Receive::create([
            'user_id'   =>   Auth::user()->id,
            'from_id'        => $user->id,
            'transaction_state_id'  =>  3, // waiting confirmation
            'gross'    =>  $request->amount,
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'fee'   =>  $receive_fee,
            'net'   => bcsub( $request->amount , $receive_fee, $precision ),
            'metal_value'   => $request->ounce * ($request->amount - $receive_fee) / $request->amount,
            'description'   =>  $request->description,
        ]);

        $send = Send::create([
            'user_id'   =>  $user->id,
            'to_id'        =>  Auth::user()->id,
            'transaction_state_id'  =>  3, // waiting confirmation 
            'gross'    =>  $request->amount,
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'fee'   =>  $send_fee,
            'net'   =>  bcsub ( $request->amount , $send_fee, $precision ),
            'metal_value'   => $request->ounce * ($request->amount - $send_fee) / $request->amount,
            'description'   =>  $request->description,
            'receive_id'    =>  $receive->id
        ]);

        $receive->send_id = $send->id;
        $receive->save();

        Auth::user()->RecentActivity()->save($receive->Transactions()->create([
            'user_id' => $receive->user_id,
            'entity_id'   =>  $receive->id,
            'entity_name' =>  Auth::user()->name,
            'transaction_state_id'  =>  3, // waiting confirmation
            'money_flow'    => '+',
            'currency_id' =>  $currency->id,
            'thumb' =>  Auth::user()->avatar,
            'currency_symbol' =>  $currency->symbol,
            'activity_title'    =>  'Payment Received',
            'gross' =>  $receive->gross,
            'fee'   =>  $receive->fee,
            'net'   =>  $receive->net,
            'metal_value'   =>  $receive->metal_value
        ]));

        $user->RecentActivity()->save($send->Transactions()->create([
            'user_id' =>  Auth::user()->id,
            'entity_id'   =>  $send->id,
            'entity_name' =>  $user->name,
            'transaction_state_id'  =>  3, // waiting confirmation
            'money_flow'    => '-',
            'thumb' =>  $user->avatar,
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'activity_title'    =>  'Payment Sent',
            'gross' =>  $send->gross,
            'fee'   =>  $send->fee,
            'net'   =>  $send->net,
            'metal_value'   =>  $send->metal_value
        ]));
        
        return  redirect(route('home'));

    }


    public function sendMoneyConfirm(Request $request){
        $this->validate($request, [
            'tid'   => 'required|numeric',
        ]);

        $transaction = Transaction::find($request->tid);

        $currency = Currency::find($transaction->currency_id);

        if ( $currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        $auth_wallet = Auth::user()->walletByCurrencyId($currency->id);
        if((boolean)$transaction == false ) {
            flash(__('Oops, something went wrong... Please contact to support if this error persists !'), 'danger');
            return back();
        }

        if ( Auth::user()->account_status == 0 ) {
            flash(__('Your account is under a withdrawal request review proccess. Please wait for a few minutes and try again') , 'info');
             return  back();
        }
        
        if(Auth::user()->id != $transaction->user_id ){
            flash(__('Oops, something went wrong... Please contact to support if this error persists !'), 'danger');
            return back();
        }

        $send = Send::find($transaction->transactionable_id);

         if((boolean)$send == false ){
            flash(__('Oops, something went wrong... Please contact to support if this error persists !'), 'danger');
            return back();
        }

        if(Auth::user()->id != $send->user_id ){
            flash(__('Oops, something went wrong... Please contact to support if this error persists !'),'danger');
            return back();
        }

        $receive = Receive::find($send->receive_id);

        if((boolean)$receive == false ){
            flash(__('Oops, something went wrong... Please contact to support if this error persists !'), 'danger');
            return back();
        }

        $user = User::find($receive->user_id);

        $user_wallet = $user->walletByCurrencyId($currency->id);

        if((boolean)$user == false ){
            flash(__('Oops, something went wrong... Please contact to support if this error persists !'), 'danger');
            return back();
        }

        $receive_transaction = transaction::where('transactionable_type', 'App\Models\Receive')->where('user_id', $user->id)->where('transaction_state_id', 3)->where('money_flow', '+')->where('transactionable_id', $receive->id)->first();

        if((boolean)$receive_transaction == false ){
            flash(__('Oops, something went wrong... Please contact to support if this error persists !'), 'danger');
            return back();
        }

        /*if((double)$auth_wallet->amount < (double)$transaction->net ){
             flash(__('You have insufficient funds to send').' <strong>'.$request->amount.__('to').$request->email .'</strong>', 'danger');
            return  back();
        }*/

        $receive->send_id = $send->id;
        $receive->transaction_state_id = 1;
        $receive->save();

        $send->transaction_state_id = 1;
        $send->save();

        $transaction->transaction_state_id = 1;
        $transaction->balance = bcsub( $auth_wallet->amount , $transaction->net, $precision );
        $transaction->save();

        $receive_transaction->transaction_state_id = 1;
        $receive_transaction->balance =  bcadd( $user_wallet->amount , $receive_transaction->net, $precision ) ;
        $receive_transaction->save();

        //$auth_wallet->amount = bcsub ( $auth_wallet->amount , $transaction->net, $precision ) ;
        //$auth_wallet->save();

        //$user_wallet->amount =  bcadd($user_wallet->amount,  $receive_transaction->net, $precision ) ;
        //$user_wallet->save();

        $user->balance = $user->balance + $receive_transaction->metal_value;
        $user->save();
        Auth::user()->balance = Auth::user()->balance - $transaction->metal_value;
        Auth::user()->save();

        flash(__('Transaction Complete'), 'success');

        return  back();
    }
    public function sendMoneyCancel(Request $request){
        $this->validate($request, [
            'tid'   => 'required|numeric',
        ]);

        $transaction = Transaction::findOrFail($request->tid);
        $send = Send::findOrFail($transaction->transactionable_id);

        $receive = Receive::findOrFail($send->receive_id);

        $receive->delete();
        $send->delete();
        $transaction->delete();
        
        flash(__('Transaction Canceled'), 'success');

        return  back();
    }
}
