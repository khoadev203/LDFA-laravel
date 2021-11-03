<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Models\Escrow;
use App\Models\Send;
use App\Models\Receive;
use App\Models\Wallet;
use App\Models\Currency;
use Illuminate\Http\Request;

class EscrowController extends Controller
{
    public function sendForm(Request $request){
    	$currencies = Currency::all();

    	return view('escrow.form')
    	->with('currencies', $currencies);
    }

    public function store(Request $request){

        if ($request->amount <= 0) {
            flash(__('Please insert an amount greater than 0'),'danger');
                return back();
        }

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
          
            $this->validate($request, [
                // 'amount'    =>  'required|numeric|between:0,'.Auth::user()->currentWallet()->amount,
                'ounce'         =>  'required|numeric',
                'description'   =>  'required|string',
                'email' =>  'required|email|exists:users,email',
            ]);

        } else {
           
            $this->validate($request, [
           //     'amount'    =>  'required|numeric|between:0,'.Auth::user()->currentWallet()->amount,
                'description'   =>  'required|string',
                
            ]);

            $valid_user = User::where('name', $request->email)->first();

            if (is_null($valid_user)) {

                flash(__('The Username '). $request->email .__(' is invalid'), 'danger');
                return back();
            }
        }        
        
        $current_currency_amount = Auth::user()->balance * $request->price;

        $currency = Currency::find(Auth::user()->currency_id);

        $auth_wallet = Auth::user()->walletByCurrencyId($currency->id);

        if((boolean)$currency == false ){
          flash(__('Oops, something went wrong... looks like we do not support this currency. Please contact support if this error persists !'), 'danger');
            return back();
        }

        if ( Auth::user()->account_status == 0 ) {
            flash(__('Your account is under a withdrawal request review proccess. Please wait for a few minutes and try again') , 'info');
             return  back();
        }

        if ($request->email == Auth::user()->email) {
            flash(__('You can\'t send money to the same account you are in') , 'danger');
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

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
        }else{
            $user = $valid_user ;
        }
        
        $send_fee = 0; //free to send money
        //$receive_fee = ((setting('money-transfers.mt_percentage_fee')/100)* (double)$request->amount) + setting('money-transfers.mt_fixed_fee') ;

         if ( $currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        $percent_fee = bcmul( setting('escrows.percent_fee') / 100, $request->amount , $precision );
        // dd(bcadd(3.5, 0, 2));
        // $escrow_fee =  bcadd( $percent_fee, setting('escrows.fixed_fee'), $precision ); // create a fee on admin dashboard 
        $escrow_fee = floatval($percent_fee) + floatval(setting('escrows.fixed_fee'));
        if ( ($request->amount + $escrow_fee) < 0 ) {
            flash(__('The minimum amount to send is').' <strong>'.abs($request->amount + $escrow_fee) .'</strong>', 'danger');
            return  back();
        }

        // if(( $request->amount + $escrow_fee ) >  $auth_wallet->amount ){
        //      flash(__('Not enough funds to make transaction ( Escrow ['. $currency->symbol . $request->amount.'] + Fee ['. $currency->symbol . $escrow_fee .'] )   = ').' <strong>' . $currency->symbol .bcadd($request->amount , $escrow_fee, $precision) .'</strong>', 'danger');
        //     return  back();
        // }

        $escrow = Escrow::create([
            'user_id'   => Auth::user()->id,
            'to'    =>  $user->id,
            'gross' =>  $request->amount + $escrow_fee,
            'metal_value'   => $request->ounce * ($request->amount + $escrow_fee) / $request->amount,//gross metal value
            'description'   =>  $request->description,
            'currency_id'   =>  $currency->id,
            'currency_symbol'   =>  $currency->symbol,
            'escrow_transaction_status' => 'On Hold',
        ]);

        // $b = bcadd(''.$request->amount, ''. $escrow_fee , $precision); // amount plus fee
        // $auth_wallet->amount = bcsub(''.$auth_wallet->amount, $b, $precision); // subtract amount plus fee from the user wallet
        // $auth_wallet->save();

        Auth::user()->balance = Auth::user()->balance - $escrow->metal_value;
        Auth::user()->save();

        return redirect('/home');

    }

    public function release(Request $request){
        
        $this->validate($request, [
            'eid'   =>  'exists:escrows,id|required',
        ]);

        $escrow = Escrow::findOrFail($request->eid);
        
        $currency = Currency::where('id', $escrow->currency_id)->first();

        if ( $currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        if ($escrow->escrow_transaction_status == 'completed') {
            flash('Money Already Sent', 'danger');
            return back();
        }

        if (Auth::user()->id != $escrow->user_id and !Auth::user()->isAdministrator()) {
                flash('You dont have permission to release this payment', 'danger');
                return back();
        }
        
        $percent_fee = ''.bcmul( ''.(setting('escrows.percent_fee')/100) , ''.$request->amount, $precision );

        // $escrow_fee =  bcadd( $percent_fee , setting('escrows.fixed_fee') , $precision);
        $escrow_fee = floatval($percent_fee) + floatval(setting('escrows.fixed_fee'));

        $escrow_sender = User::where('id', $escrow->user_id)->first();
        $escrow_receiver = User::where('id', $escrow->to)->first();

        $receiver_wallet = Wallet::where('currency_id', $escrow->currency_id)->where('user_id', $escrow->to)->first();
        $sender_wallet = Wallet::where('currency_id', $escrow->currency_id)->where('user_id', $escrow->user_id)->first();

        $receive = Receive::create([
            'user_id'   =>   $escrow->to,
            'from_id'        => $escrow->user_id,
            'transaction_state_id'  =>  1, // waiting confirmation
            'gross'    =>  $escrow->gross,
            'currency_id' =>  $escrow->currency_id,
            'currency_symbol' =>  $escrow->currency_symbol,
            'fee'   =>  $escrow_fee,
            'net'   =>  bcsub(''.$escrow->gross , ''. $escrow_fee, $precision),
            'metal_value'   => $escrow->metal_value * bcsub(''.$escrow->gross , ''. $escrow_fee, $precision) / $escrow->gross,
            'description'   =>  $escrow->description,
        ]);

        $send = Send::create([
            'user_id'   =>  $escrow->user_id,
            'to_id'        =>  $escrow->to,
            'transaction_state_id'  =>  1, // waiting confirmation 
            'gross'    =>  $escrow->gross,
            'currency_id' =>  $escrow->currency_id,
            'currency_symbol' =>  $escrow->currency_symbol,
            'fee'   =>  $escrow_fee,
            'net'   =>  bcsub(''.$escrow->gross, ''.$escrow_fee, $precision),
            'metal_value'   => $escrow->metal_value * bcsub(''.$escrow->gross , ''. $escrow_fee, $precision) / $escrow->gross,
            'description'   =>   $escrow->description,
            'receive_id'    =>  $receive->id
        ]);

        $receive->send_id = $send->id;
        $receive->save();

        $escrow_receiver->balance = $escrow_receiver->balance + $receive->metal_value;
        $escrow_receiver->save();

        // $b = bcsub(''.$escrow->gross,''. $escrow_fee , $precision);
        // $receiver_wallet->amount =  bcadd( ''.$receiver_wallet->amount, ''. $b , $precision);
        // $receiver_wallet->save();
        
        $escrow_receiver->RecentActivity()->save($receive->Transactions()->create([
            'user_id' => $receive->user_id,
            'entity_id'   =>  $receive->id,
            'entity_name' => $escrow_sender->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '+',
            'thumb' =>  $escrow_sender->avatar,
            'currency_id' =>   $escrow->currency_id,
            'currency_symbol' =>   $escrow->currency_symbol,
            'activity_title'    =>  'Payment Received',
            'gross' =>  $receive->gross,
            'fee'   =>  $receive->fee,
            'net'   =>  $receive->net,
            'metal_value'   => $receive->metal_value,
            'balance'   => $receiver_wallet->amount,
        ]));

        $escrow_sender->RecentActivity()->save($send->Transactions()->create([
            'user_id' =>  $escrow_sender->id,
            'entity_id'   =>  $send->id,
            'entity_name' =>  $escrow_receiver->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '-',
            'thumb' =>  $escrow_receiver->avatar,
            'currency_id' =>   $escrow->currency_id,
            'currency_symbol' =>   $escrow->currency_symbol,
            'activity_title'    =>  'Payment Sent',
            'gross' =>  $send->gross,
            'fee'   =>  $send->fee,
            'net'   =>  $send->net,
            'metal_value'   => $send->metal_value,
            'balance'   => $sender_wallet->amount,
        ]));

        $escrow->escrow_transaction_status = 'completed';
        $escrow->save();
        
        return  redirect(route('home'));

    }

    public function refund(Request $request){
         $this->validate($request, [
            'eid'   =>  'exists:escrows,id|required',
        ]);

        $escrow = Escrow::findOrFail($request->eid);
        $currency = Currency::where('id', $escrow->currency_id)->first();

        if ( $currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        if ($escrow->escrow_transaction_status == 'completed') {
            flash('Money Already Refunded', 'danger');
            return back();
        }

        if (Auth::user()->id != $escrow->to and !Auth::user()->isAdministrator()) {
                flash('You dont have permission to release this payment', 'danger');
                return back();
        }

        $escrow_sender = User::where('id', $escrow->user_id)->first();
        $escrow_sender->balance = $escrow_sender->balance + $escrow->metal_value;
        $escrow_sender->save();
        // $sender_wallet = Wallet::where('currency_id', $escrow->currency_id)->where('user_id', $escrow->user_id)->first();

        // $sender_wallet->amount = bcadd(''.$sender_wallet->amount ,''. $escrow->gross, $precision ) ;
        // $sender_wallet->save();

        $escrow->escrow_transaction_status = 'completed';
        $escrow->save();

        flash('money refunded successfully');
        return back();
    }

    public function agreement(Request $request, $escrow_id){

        $escrow = Escrow::findOrFail($escrow_id);

        if (!Auth::user()->isAdministrator() and Auth::user()->id != $escrow->user_id and $escrow->user_id) {
            abort(404);
        }

        $sender = User::findOrFail($escrow->user_id);
        $receiver = User::findOrFail($escrow->to);

        return view('escrow.escrow_agreement')
        ->with('escrow_fee', $escrow->fee)
        ->with('sender', $sender)
        ->with('receiver', $receiver)
        ->with('escrow', $escrow);
    }
}
