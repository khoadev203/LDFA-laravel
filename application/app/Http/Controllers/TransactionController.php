<?php

namespace App\Http\Controllers;
use Auth;
use Mail;
use App\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\Exchange;
use App\Models\Redeem;
use App\Models\Buy_certificate;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Receive;
use App\Models\Send;
use App\Models\Currency;
use App\Models\Merchant;
use App\Mail\Certificate\orderDeliveredUserNotificationEmail;
use Illuminate\Http\Request;
use App\Mail\generalNotification;

class TransactionController extends Controller
{ 


	public function show(Request $request, int $id){
		$transaction = Transaction::findOrFail($id);

		switch ($transaction->transactionable_type) {
			case 'App\Models\Sale':
				
					$sale = Sale::findOrFail($transaction->transactionable_id);
					$purchase = Purchase::findOrFail($sale->purchase_id);
					$client = User::findOrFail($purchase->user_id);
					$merchant = Merchant::findOrFail($sale->merchant_id);
					return view('Transactions.show')
					->with('transaction',$transaction)
					->with('sale', $sale)
					->with('client', $client)
					->with('invoice', json_decode($transaction->json_data))
					->with('merchant', $merchant)
					->with('purchase', $purchase);

				break;
			case 'App\Models\Purchase':
					$purchase = Purchase::findOrFail($transaction->transactionable_id);
					$merchant = Merchant::findOrFail($purchase->merchant_id);
					return view('Transactions.show')
					->with('transaction',$transaction)
					->with('invoice', json_decode($transaction->json_data))
					->with('merchant', $merchant)
					->with('purchase', $purchase);
				break;
			case 'App\Models\Receive':
				# code...
				break;
			case 'App\Models\Send':
				# code...
				break;
			case 'App\Models\Exchange':
				# code...
				break;
			case 'App\Models\Deposit':
				# code...
				break;
			case 'App\Models\Withdrawal':
				# code...
				break;
			case 'App\Models\Voucher':
				# code...
				break;
			
			default:
				# code...
				break;
		}
		
	}

	public function deleteMapper(Request $request){

		$this->validate($request, [
			'tid'	=>	'exists:transactionable,id|required'
		]);

		$transaction = Transaction::where('id', $request->tid)->first();

		if (Auth::user()->id != $transaction->user_id or !Auth::user()->isAdministrator() ) {
			flash(__('Woops, something went wrong'), 'danger');
			return back();
		}

		$delete = str_replace('App\Models\\', 'delete', $transaction->transactionable_type);

		if ($delete == 'deletePurchase') {

			$this->deletePurchase($transaction);
			return back();
			
		}

		if ($delete == 'deleteSend') {

			$this->deleteSend($transaction);
			return back();
			
		}
		
	}

	private function deletePurchase(Transaction $trans){


		$purchase = Purchase::findOrFail($trans->transactionable_id);
		$sale = Sale::findOrFail($purchase->sale_id);
		
		$trans->delete();
		$purchase->delete();
		$sale->delete();

		flash(__('Transaction deleted'), 'danger');

		
	}

	private function  deleteSend(Transaction $trans){

		$trans_wallet = Wallet::where('user_id', $trans->user_id)->where('currency_id', $trans->currency_id)->first();
		
		$send = Send::findOrFail($trans->transactionable_id);
		$receive = Receive::findOrFail($send->receive_id);

		$receive_transaction = Transaction::where('transactionable_type', 'App\Models\Receive')->where('transactionable_id', $receive->id)->first();

		$receive_transaction_wallet = Wallet::where('user_id', $receive_transaction->user_id)->where('currency_id', $receive_transaction->currency_id)->first();

		$trans->transaction_state_id = 2 ;
		$trans->balance = $trans_wallet->amount ;
		$trans->save();
		$send->delete();
		$receive->delete();
		$receive_transaction->transaction_state_id = 2 ;
		$receive_transaction->balance = $receive_transaction_wallet->amount ;
		$receive_transaction->save();

		flash(__('Transaction deleted'), 'danger');

	}

	private function  deleteReceive(Transaction $trans){
		
		$receive = Send::findOrFail($trans->transactionable_id);
		$send = Receive::findOrFail($receive->send_id);

		$send_transaction = Transaction::where('transactionable_type', 'App\Models\Send')->where('transactionable_id', $send->id)->first();

		$trans->transaction_state_id = 2 ;
		$trans->save();
		$send->delete();
		$receive->delete();
		$send_transaction->transaction_state_id = 2 ;
		$send_transaction->save();

		flash(__('Transaction deleted'), 'danger');

	}

    public function my_cert_orders() {
        $pending_orders = Buy_certificate::where('transaction_state_id', 3)->where('user_id', Auth::user()->id)->get();
        $complete_orders = Buy_certificate::where('transaction_state_id', 1)->where('user_id', Auth::user()->id)->get();

        return view('certificates.index')
            ->with('pending_orders', $pending_orders)
            ->with('complete_orders', $complete_orders);
    }


    public function buy_certificate(Request $request) {

        $currencies = Currency::where('id' , '!=', Auth::user()->currentCurrency()->id)->get();
        $code = Auth::user()->currentCurrency()->code;
        $metalPrice = setting('site.silver_price');
        $input = $request->all();

        if(!empty($input)) {

            $certificates = $input['certificates'];
            $address = $input['address'];
            $added_rec = false;

            foreach($certificates as $key => $quantity) {
                $quantity = floor($quantity);

                if($quantity < 0) {
                    flash(__('Can not be negative value!') , 'danger');
                    return  back();
                } else if($quantity > 0) {
                    switch ($key) {
                        case 'v10th':
                            $cert_type = "One Tenth Ounce Certificate";
                            $divider = 10;
                            break;
                        case 'v4th':
                            $cert_type = "One Fourth Ounce Certificate";
                            $divider = 4;
                            break;
                        case 'v2nd':
                            $cert_type = "One Second Ounce Certificate";
                            $divider = 2;
                            break;
                        case 'v1':
                            $cert_type = "One Ounce Certificate";
                            $divider = 1;
                            break;
                        case 'v2':
                            $cert_type = "Two Ounces Certificate";
                            $divider = 0.5;
                            break;
                        case 'v5':
                            $cert_type = "Five Ounces Certificate";
                            $divider = 0.2;
                            break;
                        default:
                            break;
                    }

                    $currency_amount = $quantity * ($metalPrice + setting('money-transfers.buy_certificate_fixed_fee')) / $divider;
                    $withdrawal = Buy_certificate::create([
                        'user_id'   =>   Auth::user()->id,
                        'currency_id'  =>  Auth::user()->currentCurrency()->id,
                        'currency_amount'   =>  $currency_amount,
                        'currency_net'  =>  $quantity * $metalPrice / $divider,
                        'currency_fee'  =>  $quantity * setting('money-transfers.buy_certificate_fixed_fee') / $divider,
                        'metal_amount'  =>  $currency_amount / $metalPrice,
                        'transaction_state_id'  =>  3,
                        'cert_type' =>  $cert_type,
                        'quantity' =>  $quantity,
                        'shipping_address'  =>  $address
                    ]);
                    $added_rec = true;
                    flash(__('Your Certificate Order has been placed successfully!') , 'info');
                } 
            }

            if(! $added_rec) {
                flash(__('At least one field should be filled!') , 'danger');
                return back();
            } else {
                Mail::send(new generalNotification( "You've Got a New Certificate Order!", Auth::user()->name." has ordered certificates", "admin@ldfa.nl"));
            }
            return redirect(route('buy_certificate'));
        }

        return view('Transactions.sell_redeem')
        ->with('metalPrice', $metalPrice)
        ->with('fee', setting('money-transfers.buy_certificate_fixed_fee'));
    }

    public function reject_certificate(Request $request, $id) {
        $id = unserialize(base64_decode($id));
        if (!Auth::user()->isAdministrator()) {
            abort (404);
        }

        $order = Buy_certificate::findOrFail($id);

        if ($order->transaction_state_id != 3 ) {

            flash(__('Transaction Already completed !'), 'info' );

            return back();
        } else {
            $order->transaction_state_id = 2;//rejected
            $order->save();
        }

        return redirect(url('/').'/admin/BuyCertificate'); 
    }
    
    public function confirm_certificate(Request $request,$id){
        $id = unserialize(base64_decode($id));
        if (!Auth::user()->isAdministrator()) {
            abort (404);
        }

        $order = Buy_certificate::findOrFail($id);

        if ($order->transaction_state_id != 3 ) {

            flash(__('Transaction Already completed !'), 'info' );

            return back();
        }
  
        $sender = User::findOrFail($order->user_id);
        $receiver = User::where('role_id', 3)->first();//ldadmin
        $currency = Currency::where('code', 'USD')->first();
        $transaction_state = 1;
        $receive_fee = 0;
        $send_fee = $order->currency_fee;
        $send_gross = $order->currency_amount;
        $receive_gross = $order->currency_net;
        $spot = setting('site.silver_price');
        $send_ounce = $send_gross / $spot;
        $receive_ounce = $receive_gross / $spot;
        $description = "Payment for certificate orders";
        $precision = 2;

        $result = $this->TransferMoney(
            $sender, 
            $receiver,
            $currency,
            $transaction_state,
            $send_gross,
            $send_fee,
            $receive_gross,
            $receive_fee,
            $send_ounce,
            $receive_ounce,
            $precision,
            $description
        );

        if($result) {
            Mail::send(new orderDeliveredUserNotificationEmail( $order, $sender));
            $sender->balance -= $send_ounce;
            $receiver->balance += $receive_ounce;

            $sender->save();
            $receiver->save();

            $order->transaction_state_id = 1;
            
            $order->save();

            $sender->account_status = 1;
            $sender->save();
        }

        return redirect(url('/').'/admin/BuyCertificate'); 
    }

    public function redeem(Request $request ,$method_id = false){
        $user = Auth::user();

        $currencies = Currency::where('id' , '!=', Auth::user()->currentCurrency()->id)->get();
        $code = Auth::user()->currentCurrency()->code;
        $metalPrice = setting('site.silver_price');

        $input = $request->all();
        if(!empty($input)) {
            if(Auth::user()->balance < $input['ounce']) {
                flash(__('Your balance is not enouth to redeem '.  $input['ounce']) , 'danger');
                return  back();
            }

            $currency = Auth::user()->currentCurrency();

            if ( $currency->is_crypto == 1 ) {
                $precision = 8 ;
            } else {
                $precision = 2;
            }

            $withdrawal =   Redeem::create([
                'user_id'   =>   Auth::user()->id,
                'currency_id'  =>  Auth::user()->currentCurrency()->id, 
                'transaction_state_id'  =>  3,
                'ounce' =>  $input['ounce'],
            ]);

            flash(__('You requested redemption of '.$input['ounce'].' ounces successfully!') , 'info');

            return redirect(route('redeem'));
        
        }
        return view('Transactions.redeem')
        ->with('metalPrice', $metalPrice);
    }


    public function reject_redeem(Request $request, $id) {
        $id = unserialize(base64_decode($id));

        if (!Auth::user()->isAdministrator()) {
            abort (404);
        }

        $redeem = Redeem::findOrFail($id);
        if ($redeem->transaction_state_id != 3 ) {
            flash(__('Transaction Already completed !'), 'info' );

            return back();
        } else {
            $redeem->transaction_state_id = 2;//rejected
            $redeem->save();
        }
        return redirect(url('/').'/admin/redeem');
    }

    public function confirm_redeem(Request $request,$id) {
        $id = unserialize(base64_decode($id));

        if (!Auth::user()->isAdministrator()) {
            abort (404);
        }

        $redeem = Redeem::findOrFail($id);
        if ($redeem->transaction_state_id != 3 ) {
            flash(__('Transaction Already completed !'), 'info' );

            return back();
        }

        $user = User::findOrFail($redeem->user_id);

        $currency = Currency::where('code', 'USD')->first();

        if ( $currency->is_crypto == 1 ) {
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        if ($user->balance < $redeem->ounce) {
            flash('User doesen\'t have enought funds to buy '.$redeem->ounce.' $', 'danger' );

            return back();
        }
        
        $sender = $user;
        $receiver = User::where('role_id', 3)->first();//ldadmin
        $transaction_state = 1;
        $receive_fee = 0;
        $send_fee = 3;
        $spot = setting('site.silver_price');
        $receive_ounce = $redeem->ounce;
        $receive_gross = $receive_ounce * $spot;
        $send_gross = $receive_gross + $send_fee;
        $send_ounce = $send_gross / $spot;

        $description = "Payment for redemption";
        $precision = 2;

        $result = $this->TransferMoney(
            $sender, 
            $receiver,
            $currency,
            $transaction_state,
            $send_gross,
            $send_fee,
            $receive_gross,
            $receive_fee,
            $send_ounce,
            $receive_ounce,
            $precision,
            $description
        );

        if($result) {
            $sender->balance -= $send_ounce;
            $receiver->balance += $receive_ounce;

            $sender->save();
            $receiver->save();

            $redeem->transaction_state_id = 1;
            
            $redeem->save();
            $user->account_status = 1;
            $user->save();
        }

        return redirect(url('/').'/admin/redeem'); 
    }

    public function confirm_transactions(Request $request , $id){
        $id = unserialize(base64_decode($id));
        $transaction_data = Transaction::where('id',$id)->first();
        $user = User::where('id',$transaction_data->user_id)->first();
        $wallet = $user->currentWallet();

        $reciver_data = Receive::where('id',$transaction_data->entity_id)->first();
        $sender_data = Send::where('id',$reciver_data->send_id)->first();

        $transaction_send_data = Transaction::where('entity_id',$sender_data->id)->where('transactionable_type','App\Models\Send')->first();

        $voucherValue = $sender_data->gross;

        $currencyCode = $wallet->currency->code;
        $metalPrice = setting('site.silver_price');//as currency
        $premium = setting('money-transfers.premium') * setting('site.silver_price');

        $metalPrice = $metalPrice + $premium;

        $metalValue = $voucherValue / ($metalPrice + $premium);
        $userAmount = $metalValue * $metalPrice;
        $premiumMV = $premium * $metalValue;

        $premiumOunce = $premiumMV / $metalPrice;
       
        // $metalValue = $reciver_data->metal_value;
        
        if(Auth::user()->isAdministrator())
        {
            $ldadmin = User::where('role_id', 3)->first();
            $ldprofit = User::where('role_id', 4)->first();
            if($ldadmin->balance >= $metalValue) {
                $user->balance = $user->balance + $metalValue;
                $user->save();

                $ldadmin->balance = $ldadmin->balance - $metalValue;
                $ldadmin->save();

                $reciver_data->transaction_state_id = 1;
                $reciver_data->save();

                $sender_data->transaction_state_id = 1;
                $sender_data->save();

                $transaction_data->transaction_state_id = 1;
                $transaction_data->save();

                $transaction_send_data->transaction_state_id = 1;
                $transaction_send_data->save();
                
                //transfer profit to the profit account
                $receive = Receive::create([
                    'user_id'   =>   $ldprofit->id,
                    'from_id'   => $ldadmin->id,
                    'transaction_state_id'  =>  1, // confirmation
                    'gross'    =>  $premiumMV,
                    'currency_id' =>  $wallet->currency->id,
                    'currency_symbol' =>  $wallet->currency->symbol,
                    'fee'   =>  0,
                    'net'   =>  $premiumMV,
                    'metal_value'   =>  $premiumOunce,
                    'description'   =>  "Profit from purchase received",
                ]);
         
                $send = Send::create([
                    'user_id'   =>  $ldadmin->id,
                    'to_id'        =>  $user->id,
                    'transaction_state_id'  =>  1, // confirmation 
                    'gross'    =>  $voucherValue,
                    'currency_id' =>  $wallet->currency->id,
                    'currency_symbol' =>  $wallet->currency->symbol,
                    'fee'   =>  0,
                    'net'   =>  $premiumMV,
                    'metal_value'   => $premiumOunce,
                    'description'   =>  "Profit from purchase sent",
                    'receive_id'    =>  $receive->id
                ]);
        
                $receive->send_id = $send->id;
                $receive->save();

                $ldprofit->RecentActivity()->save($receive->Transactions()->create([
                    'user_id' =>  Auth::user()->id,
                    'entity_id'   =>  $receive->id,
                    'entity_name' =>  $wallet->currency->name,
                    'transaction_state_id'  =>  1, // waiting confirmation
                    'money_flow'    => '+',
                    'activity_title'    =>  'Profit from purchase received',
                    'thumb' =>  $wallet->currency->thumb,
                    'currency_id' =>  $wallet->currency->id,
                    'currency_symbol' =>  $wallet->currency->symbol,
                    'gross' =>  $receive->gross,
                    'fee'   =>  $receive->fee,
                    'net'   =>  $receive->net,
                    'metal_value' => $receive->metal_value,
                    'balance'   =>  $wallet->amount,//balance in simply currency
                ]));

                $ldadmin->RecentActivity()->save($send->Transactions()->create([
                    'user_id' =>  Auth::user()->id,
                    'entity_id'   =>  $send->id,
                    'entity_name' =>  $user->name,
                    'transaction_state_id'  =>  1, // waiting confirmation
                    'money_flow'    => '-',
                    'thumb' =>  $user->avatar,
                    'currency_id' =>  $wallet->currency->id,
                    'currency_symbol' =>  $wallet->currency->symbol,
                    'activity_title'    =>  'Profit from purchase sent',
                    'gross' =>  $send->gross,
                    'fee'   =>  $send->fee,
                    'net'   =>  $send->net,
                    'metal_value'   =>  $send->metal_value
                ]));

                $ldprofit->balance = $ldprofit->balance + $premiumOunce;
                $ldprofit->save();

                $ldadmin->balance = $ldadmin->balance - $premiumOunce;
                $ldadmin->save();  

                //commissions for referrers 3 levels deep
                $referrer = $user;
                $commission = $premiumMV * 0.05;
                
                for($i = 0; $i < 3; $i++)
                {
                    $referrer = User::find($referrer->id)->referrer()->first();

                    if($referrer == null)
                        break;
                    // dd($referrer->id);
                    $receive = Receive::create([
                        'user_id'   =>   $referrer->id,
                        'from_id'   => $ldprofit->id,
                        'transaction_state_id'  =>  1, // confirmation
                        'gross'    =>  $commission,
                        'currency_id' =>  $wallet->currency->id,
                        'currency_symbol' =>  $wallet->currency->symbol,
                        'fee'   =>  0,
                        'net'   =>  $commission,
                        'metal_value'   =>  $commission / $metalPrice,
                        'description'   =>  "Commission from purchase",
                    ]);
            
                    $send = Send::create([
                        'user_id'   =>  $ldprofit->id,
                        'to_id'        =>  $referrer->id,
                        'transaction_state_id'  =>  1, // confirmation 
                        'gross'    =>  $commission,
                        'currency_id' =>  $wallet->currency->id,
                        'currency_symbol' =>  $wallet->currency->symbol,
                        'fee'   =>  0,
                        'net'   =>  $commission,
                        'metal_value'   => $commission / $metalPrice,
                        'description'   =>  "Commission from purchase",
                        'receive_id'    =>  $receive->id
                    ]);
            
                    $receive->send_id = $send->id;
                    $receive->save();

                    $referrer->RecentActivity()->save($receive->Transactions()->create([
                        'user_id' =>  Auth::user()->id,
                        'entity_id'   =>  $receive->id,
                        'entity_name' =>  $wallet->currency->name,
                        'transaction_state_id'  =>  1, // waiting confirmation
                        'money_flow'    => '+',
                        'activity_title'    =>  'Commission from purchase',
                        'thumb' =>  $wallet->currency->thumb,
                        'currency_id' =>  $wallet->currency->id,
                        'currency_symbol' =>  $wallet->currency->symbol,
                        'gross' =>  $receive->gross,
                        'fee'   =>  $receive->fee,
                        'net'   =>  $receive->net,
                        'metal_value' => $receive->metal_value,
                        'balance'   =>  $wallet->amount,//balance in simply currency
                    ]));

                    $ldprofit->RecentActivity()->save($send->Transactions()->create([
                        'user_id' =>  Auth::user()->id,
                        'entity_id'   =>  $send->id,
                        'entity_name' =>  $user->name,
                        'transaction_state_id'  =>  1, // waiting confirmation
                        'money_flow'    => '-',
                        'thumb' =>  $user->avatar,
                        'currency_id' =>  $wallet->currency->id,
                        'currency_symbol' =>  $wallet->currency->symbol,
                        'activity_title'    =>  'Commission from purchase',
                        'gross' =>  $send->gross,
                        'fee'   =>  $send->fee,
                        'net'   =>  $send->net,
                        'metal_value'   =>  $send->metal_value
                    ]));
                    
                    $ldprofit->balance = $ldprofit->balance - $send->metal_value;
                    $ldprofit->save();

                    $referrer->balance = $referrer->balance + $receive->metal_value;
                    $referrer->save();
                }

                //commissions for referrers 3 levels deep
                $referrer = $user;
                $commission = $premiumMV * 0.05;
                
                for($i = 0; $i < 3; $i++)
                {
                    $referrer = User::find($referrer->id)->referrer()->first();

                    if($referrer == null)
                        break;
                    $receive = Receive::create([
                        'user_id'   =>   $referrer->id,
                        'from_id'   => $ldprofit->id,
                        'transaction_state_id'  =>  1, // confirmation
                        'gross'    =>  $commission,
                        'currency_id' =>  $wallet->currency->id,
                        'currency_symbol' =>  $wallet->currency->symbol,
                        'fee'   =>  0,
                        'net'   =>  $commission,
                        'metal_value'   =>  $commission / $metalPrice,
                        'description'   =>  "Commission from purchase",
                    ]);
            
                    $send = Send::create([
                        'user_id'   =>  $ldprofit->id,
                        'to_id'        =>  $referrer->id,
                        'transaction_state_id'  =>  1, // confirmation 
                        'gross'    =>  $commission,
                        'currency_id' =>  $wallet->currency->id,
                        'currency_symbol' =>  $wallet->currency->symbol,
                        'fee'   =>  0,
                        'net'   =>  $commission,
                        'metal_value'   => $commission / $metalPrice,
                        'description'   =>  "Commission from purchase",
                        'receive_id'    =>  $receive->id
                    ]);
            
                    $receive->send_id = $send->id;
                    $receive->save();

                    $referrer->RecentActivity()->save($receive->Transactions()->create([
                        'user_id' =>  Auth::user()->id,
                        'entity_id'   =>  $receive->id,
                        'entity_name' =>  $wallet->currency->name,
                        'transaction_state_id'  =>  1, // waiting confirmation
                        'money_flow'    => '+',
                        'activity_title'    =>  'Commission from purchase',
                        'thumb' =>  $wallet->currency->thumb,
                        'currency_id' =>  $wallet->currency->id,
                        'currency_symbol' =>  $wallet->currency->symbol,
                        'gross' =>  $receive->gross,
                        'fee'   =>  $receive->fee,
                        'net'   =>  $receive->net,
                        'metal_value' => $receive->metal_value,
                        'balance'   =>  $wallet->amount,//balance in simply currency
                    ]));

                    $ldprofit->RecentActivity()->save($send->Transactions()->create([
                        'user_id' =>  Auth::user()->id,
                        'entity_id'   =>  $send->id,
                        'entity_name' =>  $user->name,
                        'transaction_state_id'  =>  1, // waiting confirmation
                        'money_flow'    => '-',
                        'thumb' =>  $user->avatar,
                        'currency_id' =>  $wallet->currency->id,
                        'currency_symbol' =>  $wallet->currency->symbol,
                        'activity_title'    =>  'Commission from purchase',
                        'gross' =>  $send->gross,
                        'fee'   =>  $send->fee,
                        'net'   =>  $send->net,
                        'metal_value'   =>  $send->metal_value
                    ]));
                    
                    $ldprofit->balance = $ldprofit->balance - $send->metal_value;
                    $ldprofit->save();

                    $referrer->balance = $referrer->balance + $receive->metal_value;
                    $referrer->save();
                }
            }
        }
        return redirect(url('/').'/admin/Transactions'); 
    }
}
