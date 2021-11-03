<?php


namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;
use App\Models\Receive;
use App\Models\Send;
use App\Models\Currency;
use Mail;
use App\Mail\Deposit\depositCompletedUserNotificationEmail;
use App\Mail\sentPaymentEmail;
use Illuminate\Http\Request;
use App\Mail\generalNotification;
use App\Models\Deposit;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function TransferMoney(
        User $sender, 
        User $receiver,
        Currency $currency,
        $transaction_state,
        $send_gross,
        $send_fee,
        $receive_gross,
        $receive_fee,
        $send_ounce,
        $receive_ounce,
        $precision,
        $description
    )
    {
        if ($send_ounce <= 0) {
            flash(__('Please insert an amount greater than 0'),'danger');
                return false;
        }

        if($send_ounce > $sender->balance)
        {
            flash(__($sender->name.' do not have enough balance to pay this bill'),'danger');
                return false;
        }

        if($sender->isAdministrator()) {
            $send_fee = 0;
            $receive_fee = 0;
        }


        $ldprofit = User::where('role_id', 4)->first();

        $receive = Receive::create([
            'user_id'               =>  $receiver->id,
            'from_id'               =>  $sender->id,
            'transaction_state_id'  =>  $transaction_state, // waiting confirmation
            'gross'                 =>  $receive_gross,
            'currency_id'           =>  $currency->id,
            'currency_symbol'       =>  $currency->symbol,
            'fee'                   =>  $receive_fee,
            'net'                   =>  bcsub( $receive_gross , $receive_fee, $precision ),
            'metal_value'           =>  $receive_ounce,
            'description'           =>  $description,
        ]);

        if($send_fee > 0 || $receive_fee > 0) {
            $profit = Receive::create([
                'user_id'   =>   $ldprofit->id,
                'from_id'        => $sender->id,
                'transaction_state_id'  =>  $transaction_state, // waiting confirmation
                'gross'    =>  $send_fee,
                'currency_id' =>  $currency->id,
                'currency_symbol' =>  $currency->symbol,
                'fee'   =>  0,
                'net'   =>  $send_fee,
                'metal_value'   =>  $send_ounce - $receive_ounce,
                'description'   =>  $description,
            ]);
        }


        $send = Send::create([
            'user_id'   =>  $sender->id,
            'to_id'        =>  $receiver->id,
            'transaction_state_id'  =>  $transaction_state, // waiting confirmation 
            'gross'    =>  $send_gross,
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'fee'   =>  $send_fee,
            'net'   =>  bcsub( $send_gross , $send_fee, $precision ),
            'metal_value'   => $send_ounce,
            'description'   =>  $description,
            'receive_id'    =>  $receive->id
        ]);

        $receive->send_id = $send->id;
        $receive->save();

        $receiver->RecentActivity()->save($receive->Transactions()->create([
            'user_id'               =>  $receive->user_id,
            'entity_id'             =>  $receive->id,
            'entity_name'           =>  $sender->name,
            'transaction_state_id'  =>  $transaction_state, // waiting confirmation
            'money_flow'            =>  '+',
            'currency_id'           =>  $currency->id,
            'thumb'                 =>  $sender->avatar,
            'currency_symbol'       =>  $currency->symbol,
            'activity_title'        =>  'Money Received - '.$description,
            'gross'                 =>  $receive->gross,
            'fee'                   =>  $receive->fee,
            'net'                   =>  $receive->net,
            'silver_price'          =>  setting('site.silver_price'),            
            'metal_value'           =>  $receive->metal_value,
        ]));

        if($send_fee>0 || $receive_fee>0) {
            $ldprofit->RecentActivity()->save($profit->Transactions()->create([
                'user_id'               =>  $profit->user_id,
                'entity_id'             =>  $profit->id,
                'entity_name'           =>  $sender->name,
                'transaction_state_id'  =>  $transaction_state, // waiting confirmation
                'money_flow'            =>  '+',
                'currency_id'           =>  $currency->id,
                'thumb'                 =>  $sender->avatar,
                'currency_symbol'       =>  $currency->symbol,
                'activity_title'        =>  'Money Received - '.$description,
                'gross'                 =>  $profit->gross,
                'fee'                   =>  $profit->fee,
                'net'                   =>  $profit->net,
                'silver_price'          =>  setting('site.silver_price'),
                'metal_value'           =>  $profit->metal_value,
            ]));
        }
        $sender->RecentActivity()->save($send->Transactions()->create([
            'user_id'               =>  $send->user_id,
            'entity_id'             =>  $send->id,
            'entity_name'           =>  $receiver->name,
            'transaction_state_id'  =>  $transaction_state, // waiting confirmation
            'money_flow'            =>  '-',
            'thumb'                 =>  $receiver->avatar,
            'currency_id'           =>  $currency->id,
            'currency_symbol'       =>  $currency->symbol,
            'activity_title'        =>  'Money Sent - '.$description,
            'gross'                 =>  $send->gross,
            'fee'                   =>  $send->fee,
            'net'                   =>  $send->net,
            'silver_price'          =>  setting('site.silver_price'),
            'metal_value'           =>  $send->metal_value
        ]));

        $ldprofit->balance += ($send_ounce - $receive_ounce);
        $ldprofit->save();

        // if($sender->role_id == 3) {
            Mail::send(new generalNotification( "You sent payment!", "You sent $".$send->gross." to ".$receiver->name."! Please confirm your transaction.", $sender->email));
        // }
        // else if($receiver->role_id == 3) {
            Mail::send(new generalNotification( "You received payment!", "You received $".$receive->net." from ".$sender->name, $receiver->email));
        // }
        return true;
    }

    public function ReverseTransferedMoney(
        User $sender, 
        User $receiver,
        Currency $currency,
        $transaction_state,
        $send_gross,
        $send_fee,
        $receive_gross,
        $receive_fee,
        $send_ounce,
        $receive_ounce,
        $precision,
        $description
    )
    {
        $ldprofit = User::where('role_id', 4)->first();

        $receive = Receive::create([
            'user_id'   =>  $sender->id,
            'from_id'        =>  $receiver->id,
            'transaction_state_id'  =>  $transaction_state, // waiting confirmation 
            'gross'    =>  $send_gross,
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'fee'   =>  $send_fee,
            'net'   =>  bcsub( $send_gross , $send_fee, $precision ),
            'metal_value'   => $send_ounce,
            'description'   =>  $description,
        ]);

        $profit = Send::create([
            'user_id'   =>   $ldprofit->id,
            'to_id'        => $sender->id,
            'transaction_state_id'  =>  $transaction_state, // waiting confirmation
            'gross'    =>  $send_fee,
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'fee'   =>  0,
            'net'   =>  $send_fee,
            'metal_value'   =>  $send_ounce - $receive_ounce,
            'description'   =>  $description,
            'receive_id'    =>  $receive->id
        ]);

        $send = Send::create([
            'user_id'   =>   $receiver->id,
            'to_id'        => $sender->id,
            'transaction_state_id'  =>  $transaction_state, // waiting confirmation
            'gross'    =>  $receive_gross,
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'fee'   =>  $receive_fee,
            'net'   =>  bcsub( $receive_gross , $receive_fee, $precision ),
            'metal_value'   =>  $receive_ounce,
            'description'   =>  $description,
            'receive_id'    =>  $receive->id
        ]);

        $receive->send_id = $send->id;
        $receive->save();

        $sender->RecentActivity()->save($receive->Transactions()->create([
            'user_id' => $receive->user_id,
            'entity_id'   =>  $receive->id,
            'entity_name' =>  $receiver->name,
            'transaction_state_id'  =>  $transaction_state, // waiting confirmation
            'money_flow'    => '+',
            'currency_id' =>  $currency->id,
            'thumb' =>  $receiver->avatar,
            'currency_symbol' =>  $currency->symbol,
            'activity_title'    =>  'Money Received',
            'gross' =>  $receive->gross,
            'fee'   =>  $receive->fee,
            'net'   =>  $receive->net,
            'metal_value'   =>  $receive->metal_value,
        ]));

        $ldprofit->RecentActivity()->save($profit->Transactions()->create([
            'user_id' => $profit->user_id,
            'entity_id'   =>  $profit->id,
            'entity_name' =>  $sender->name,
            'transaction_state_id'  =>  $transaction_state, // waiting confirmation
            'money_flow'    => '-',
            'currency_id' =>  $currency->id,
            'thumb' =>  $sender->avatar,
            'currency_symbol' =>  $currency->symbol,
            'activity_title'    =>  'Money Sent',
            'gross' =>  $profit->gross,
            'fee'   =>  $profit->fee,
            'net'   =>  $profit->net,
            'metal_value'   =>  $profit->metal_value,
        ]));

        $receiver->RecentActivity()->save($send->Transactions()->create([
            'user_id' =>  $send->user_id,
            'entity_id'   =>  $send->id,
            'entity_name' =>  $sender->name,
            'transaction_state_id'  =>  $transaction_state, // waiting confirmation
            'money_flow'    => '-',
            'thumb' =>  $receiver->avatar,
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'activity_title'    =>  'Money Sent',
            'gross' =>  $send->gross,
            'fee'   =>  $send->fee,
            'net'   =>  $send->net,
            'metal_value'   =>  $send->metal_value
        ]));

        $ldprofit->balance -= ($send_ounce - $receive_ounce);
        $ldprofit->save();

        return true;
    }

    public function DepositSuccess(User $user, $voucherValue, $initial_fee, $currency, $deposit_type = '')
    {
        //initial fee: deposit fee
        $metalPrice = setting('site.silver_price');//as currency

        // $processing_fee = setting('merchant.merchant_fixed_fee') + $voucherValue * setting('merchant.merchant_percentage_fee') / 100;

        $premium = setting('money-transfers.premium');

        $netOunce = $voucherValue / $metalPrice;
        $premiumMV = $premium * $netOunce;
        $premiumOunce = $premiumMV / $metalPrice;
        $fee = $premiumMV + $initial_fee;
        $feeOunce = $fee / $metalPrice;
        $gross = $voucherValue + $fee;
        $grossOunce = $gross / $metalPrice;

        $ldadmin = User::where('email', "rlalimurung@gmail.com")->first();
        $ldprofit = User::where('role_id', 4)->first();

        if($ldadmin->balance >= $netOunce) {

            $user->balance = $user->balance + $netOunce;
            $user->save();

            $ldadmin->balance = $ldadmin->balance - $netOunce;
            $ldadmin->save();

            Deposit::create([
                'user_id'               =>  $user->id,
                'transaction_state_id'  =>  1,
                'gross'                 =>  $gross,
                'fee'                   =>  $fee,
                'net'                   =>  $voucherValue,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'message'               =>  "",
                'deposit_type'          =>  $deposit_type,
                'transaction_receipt'   =>  '',
                'deposit_method_id'     =>  1,//just for default value
                'wallet_id'             =>  1,
                'json_data'             =>  ''
            ]);

            $receive = Receive::create([
                'user_id'               =>  $user->id,
                'from_id'               =>  $ldadmin->id,
                'transaction_state_id'  =>  1, // confirmation
                'gross'                 =>  $gross,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'fee'                   =>  $fee,
                'net'                   =>  $voucherValue,
                'metal_value'           =>  $netOunce,
                'description'           =>  "Requested deposit - ".$deposit_type,
            ]);

            $send = Send::create([
                'user_id'               =>  $ldadmin->id,
                'to_id'                 =>  $user->id,
                'transaction_state_id'  =>  1, // confirmation 
                'gross'                 =>  $voucherValue,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'fee'                   =>  0,
                'net'                   =>  $voucherValue,
                'metal_value'           =>  $netOunce,
                'description'           =>  "Approved deposit - ".$deposit_type,
                'receive_id'            =>  $receive->id
            ]);

            $receive->send_id = $send->id;
            $receive->save();

            Mail::send(new depositCompletedUserNotificationEmail( $receive, $user));
            Mail::send(new sentPaymentEmail($send, $user));

            $user->RecentActivity()->save($receive->Transactions()->create([
                'user_id'               =>  $user->id,
                'entity_id'             =>  $receive->id,
                'entity_name'           =>  $currency->name,
                'transaction_state_id'  =>  1,
                'money_flow'            =>  '+',
                'activity_title'        =>  "Requested deposit - ".$deposit_type,
                'thumb'                 =>  $currency->thumb,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'gross'                 =>  $receive->gross,
                'fee'                   =>  $initial_fee,
                'premium_cost'          =>  $premiumMV,
                'net'                   =>  $receive->net,
                'silver_price'          =>  $metalPrice,
                'metal_value'           =>  $receive->metal_value,
                'balance'               =>  $user->balance,//balance in simply currency
            ]));

            $ldadmin->RecentActivity()->save($send->Transactions()->create([
                'user_id'               =>  $ldadmin->id,
                'entity_id'             =>  $send->id,
                'entity_name'           =>  $user->name,
                'transaction_state_id'  =>  1,
                'money_flow'            =>  '-',
                'thumb'                 =>  $user->avatar,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'activity_title'        =>  "Approved deposit - ".$deposit_type,
                'gross'                 =>  $send->gross,
                'fee'                   =>  $send->fee,
                'net'                   =>  $send->net,
                'silver_price'          =>  $metalPrice,
                'metal_value'           =>  $send->metal_value
            ]));


            //transfer profit to the profit account
            $receive = Receive::create([
                'user_id'               =>  $ldprofit->id,
                'from_id'               =>  $ldadmin->id,
                'transaction_state_id'  =>  1, // confirmation
                'gross'                 =>  $premiumMV,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'fee'                   =>  0,
                'net'                   =>  $premiumMV,
                'metal_value'           =>  $premiumMV / $metalPrice,
                'description'           =>  "Profit from deposit received",
            ]);

            $send = Send::create([
                'user_id'               =>  $ldadmin->id,
                'to_id'                 =>  $ldprofit->id,
                'transaction_state_id'  =>  1, // confirmation 
                'gross'                 =>  $premiumMV,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'fee'                   =>  0,
                'net'                   =>  $premiumMV,
                'metal_value'           =>  $premiumMV / $metalPrice,
                'description'           =>  "Profit from deposit sent",
                'receive_id'            =>  $receive->id
            ]);

            $receive->send_id = $send->id;
            $receive->save();

            $ldprofit->RecentActivity()->save($receive->Transactions()->create([
                'user_id'               =>  $ldprofit->id,
                'entity_id'             =>  $receive->id,
                'entity_name'           =>  $currency->name,
                'transaction_state_id'  =>  1, // waiting confirmation
                'money_flow'            => '+',
                'activity_title'        =>  'Profit from deposit received',
                'thumb'                 =>  $currency->thumb,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'gross'                 =>  $receive->gross,
                'fee'                   =>  $receive->fee,
                'net'                   =>  $receive->net,
                'silver_price'          =>  $metalPrice,
                'metal_value'           =>  $receive->metal_value,
                'balance'               =>  $user->balance,//balance in simply currency
            ]));

            $ldadmin->RecentActivity()->save($send->Transactions()->create([
                'user_id'               =>  $ldprofit->id,
                'entity_id'             =>  $send->id,
                'entity_name'           =>  $ldprofit->name,
                'transaction_state_id'  =>  1, // waiting confirmation
                'money_flow'            =>  '-',
                'thumb'                 =>  $ldprofit->avatar,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'activity_title'        =>  'Profit from deposit sent',
                'gross'                 =>  $send->gross,
                'fee'                   =>  $send->fee,
                'net'                   =>  $send->net,
                'silver_price'          =>  $metalPrice,
                'metal_value'           =>  $send->metal_value
            ]));

            $ldprofit->balance = $ldprofit->balance + $premiumMV / $metalPrice;
            $ldprofit->save();

            $ldadmin->balance = $ldadmin->balance - $premiumMV / $metalPrice;
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
                    'user_id'               =>  $referrer->id,
                    'from_id'               =>  $ldprofit->id,
                    'transaction_state_id'  =>  1, // confirmation
                    'gross'                 =>  $commission,
                    'currency_id'           =>  $currency->id,
                    'currency_symbol'       =>  $currency->symbol,
                    'fee'                   =>  0,
                    'net'                   =>  $commission,
                    'metal_value'           =>  $commission / $metalPrice,
                    'description'           =>  "Commission from referral purchase",
                ]);
        
                $send = Send::create([
                    'user_id'               =>  $ldprofit->id,
                    'to_id'                 =>  $referrer->id,
                    'transaction_state_id'  =>  1, // confirmation 
                    'gross'                 =>  $commission,
                    'currency_id'           =>  $currency->id,
                    'currency_symbol'       =>  $currency->symbol,
                    'fee'                   =>  0,
                    'net'                   =>  $commission,
                    'metal_value'           =>  $commission / $metalPrice,
                    'description'           =>  "Commission from referral purchase",
                    'receive_id'            =>  $receive->id
                ]);
        
                $receive->send_id = $send->id;
                $receive->save();

                $referrer->RecentActivity()->save($receive->Transactions()->create([
                    'user_id'               =>  $user->id,
                    'entity_id'             =>  $receive->id,
                    'entity_name'           =>  $currency->name,
                    'transaction_state_id'  =>  1, // waiting confirmation
                    'money_flow'            => '+',
                    'activity_title'        =>  'Commission from referral purchase',
                    'thumb'                 =>  $currency->thumb,
                    'currency_id'           =>  $currency->id,
                    'currency_symbol'       =>  $currency->symbol,
                    'gross'                 =>  $receive->gross,
                    'fee'                   =>  $receive->fee,
                    'net'                   =>  $receive->net,
                    'metal_value'           =>  $receive->metal_value,
                    'balance'               =>  $user->balance,//balance in simply currency
                ]));

                $ldprofit->RecentActivity()->save($send->Transactions()->create([
                    'user_id'               =>  $user->id,
                    'entity_id'             =>  $send->id,
                    'entity_name'           =>  $user->name,
                    'transaction_state_id'  =>  1, // waiting confirmation
                    'money_flow'            =>  '-',
                    'thumb'                 =>  $user->avatar,
                    'currency_id'           =>  $currency->id,
                    'currency_symbol'       =>  $currency->symbol,
                    'activity_title'        =>  'Commission from purchase',
                    'gross'                 =>  $send->gross,
                    'fee'                   =>  $send->fee,
                    'net'                   =>  $send->net,
                    'metal_value'           =>  $send->metal_value
                ]));
                
                $ldprofit->balance = $ldprofit->balance - $send->metal_value;
                $ldprofit->save();

                $referrer->balance = $referrer->balance + $receive->metal_value;
                $referrer->save();
            }
        }
        else
        {
            flash('Insufficient Silver Reservation ! Please contact to support if this error persists !', 'danger');
            return false; 
        }
        return true;
    }

    public function EcheckDepositSuccess(User $user, $net, $fee, $currency, $deposit_type='')
    {
        $metalPrice = setting('site.silver_price');//as currency

        $netOunce = $net / $metalPrice;
        $feeOunce = $fee / $metalPrice;
        $gross = $net + $fee;
        $grossOunce = $gross / $metalPrice;
        $print_fee = 5;
        $premium = $fee - $print_fee;//we can't calculate by ounce and price because silver price might have become different

        $ldadmin = User::where('role_id', 3)->first();
        $ldprofit = User::where('role_id', 4)->first();

        if($ldadmin->balance >= $netOunce) {
            $user->balance = $user->balance + $netOunce;
            $user->save();

            $ldadmin->balance = $ldadmin->balance - $netOunce;
            $ldadmin->save();

            $receive = Receive::create([
                'user_id'               =>  $user->id,
                'from_id'               =>  $ldadmin->id,
                'transaction_state_id'  =>  1, // confirmation
                'gross'                 =>  $gross,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'fee'                   =>  $fee,
                'net'                   =>  $net,
                'metal_value'           =>  $netOunce,
                'description'           =>  "Requested deposit - ".$deposit_type,
            ]);

            $send = Send::create([
                'user_id'               =>  $ldadmin->id,
                'to_id'                 =>  $user->id,
                'transaction_state_id'  =>  1, // confirmation 
                'gross'                 =>  $net,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'fee'                   =>  0,
                'net'                   =>  $net,
                'metal_value'           =>  $netOunce,
                'description'           =>  "Approved deposit - ".$deposit_type,
                'receive_id'            =>  $receive->id
            ]);

            $receive->send_id = $send->id;
            $receive->save();

            Mail::send(new depositCompletedUserNotificationEmail( $receive, $user));
            Mail::send(new sentPaymentEmail($send, $user));

            $user->RecentActivity()->save($receive->Transactions()->create([
                'user_id'               =>  $user->id,
                'entity_id'             =>  $receive->id,
                'entity_name'           =>  $currency->name,
                'transaction_state_id'  =>  1,
                'money_flow'            =>  '+',
                'activity_title'        =>  "Requested deposit - ".$deposit_type,
                'thumb'                 =>  $currency->thumb,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'gross'                 =>  $receive->gross,
                'fee'                   =>  $print_fee,
                'premium_cost'          =>  $premium,
                'net'                   =>  $receive->net,
                'silver_price'          =>  $metalPrice,
                'metal_value'           =>  $receive->metal_value,
                'balance'               =>  $user->balance,//balance in simply currency
            ]));

            $ldadmin->RecentActivity()->save($send->Transactions()->create([
                'user_id'               =>  $ldadmin->id,
                'entity_id'             =>  $send->id,
                'entity_name'           =>  $user->name,
                'transaction_state_id'  =>  1,
                'money_flow'            =>  '-',
                'thumb'                 =>  $user->avatar,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'activity_title'        =>  "Approved deposit - ".$deposit_type,
                'gross'                 =>  $send->gross,
                'fee'                   =>  $send->fee,
                'net'                   =>  $send->net,
                'silver_price'          =>  $metalPrice,
                'metal_value'           =>  $send->metal_value
            ]));


            //transfer profit to the profit account
            $receive = Receive::create([
                'user_id'               =>  $ldprofit->id,
                'from_id'               =>  $ldadmin->id,
                'transaction_state_id'  =>  1, // confirmation
                'gross'                 =>  $fee,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'fee'                   =>  0,
                'net'                   =>  $fee,
                'metal_value'           =>  $fee / $metalPrice,
                'description'           =>  "Profit from deposit received",
            ]);

            $send = Send::create([
                'user_id'               =>  $ldadmin->id,
                'to_id'                 =>  $ldprofit->id,
                'transaction_state_id'  =>  1, // confirmation 
                'gross'                 =>  $fee,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'fee'                   =>  0,
                'net'                   =>  $fee,
                'metal_value'           =>  $fee / $metalPrice,
                'description'           =>  "Profit from deposit sent",
                'receive_id'            =>  $receive->id
            ]);

            $receive->send_id = $send->id;
            $receive->save();

            $ldprofit->RecentActivity()->save($receive->Transactions()->create([
                'user_id'               =>  $ldprofit->id,
                'entity_id'             =>  $receive->id,
                'entity_name'           =>  $currency->name,
                'transaction_state_id'  =>  1, // waiting confirmation
                'money_flow'            => '+',
                'activity_title'        =>  'Profit from deposit received',
                'thumb'                 =>  $currency->thumb,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'gross'                 =>  $receive->gross,
                'fee'                   =>  $receive->fee,
                'net'                   =>  $receive->net,
                'silver_price'          =>  $metalPrice,
                'metal_value'           =>  $receive->metal_value,
                'balance'               =>  $user->balance,//balance in simply currency
            ]));

            $ldadmin->RecentActivity()->save($send->Transactions()->create([
                'user_id'               =>  $ldprofit->id,
                'entity_id'             =>  $send->id,
                'entity_name'           =>  $ldprofit->name,
                'transaction_state_id'  =>  1, // waiting confirmation
                'money_flow'            =>  '-',
                'thumb'                 =>  $ldprofit->avatar,
                'currency_id'           =>  $currency->id,
                'currency_symbol'       =>  $currency->symbol,
                'activity_title'        =>  'Profit from deposit sent',
                'gross'                 =>  $send->gross,
                'fee'                   =>  $send->fee,
                'net'                   =>  $send->net,
                'silver_price'          =>  $metalPrice,
                'metal_value'           =>  $send->metal_value
            ]));

            $ldprofit->balance = $ldprofit->balance + $fee / $metalPrice;
            $ldprofit->save();

            $ldadmin->balance = $ldadmin->balance - $fee / $metalPrice;
            $ldadmin->save();
        }
        else
        {
            flash('Insufficient Silver Reservation ! Please contact to support if this error persists !', 'danger');
            return false; 
        }
        return true;
    }

    public function landing(Request $request)
    {
        $referral_note = null;
        if ($request->has('ref')) {
            $referrer = User::where('name', $request->query('ref'))->first();
            if( ! empty($referrer))
                $referral_note = $referrer->referral_note;
        }
        return view('welcome')
            ->with('referral_note', $referral_note);
    }

    public function landingtest(Request $request)
    {
        return view('welcome_test');
    }

    public function globalTest()
    {
        dd('test');
    }
}
