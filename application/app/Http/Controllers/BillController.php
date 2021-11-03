<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\BillCheck;
use App\User;
use App\Models\Currency;
use App\Models\Deposit;
use PDF;
use Illuminate\Support\Facades\Storage;

use Notification;
use App\Notifications\AdminNotification;

class BillController extends Controller
{
    public function index(Request $Request) {
        $checks = BillCheck::orWhere('user_id', Auth::user()->id)
            ->orWhere('executer_id', Auth::user()->id)
            ->get();
        return view('bill.index')->with('checks', $checks);
    }

    public function createCheckForm(Request $request) {

        return view('bill.create');
    }

    public function deposit() {
        return view('bill.deposit')->with('user', Auth::user());
    }

    public function confirmEcheckDeposit($id) {
        $deposit = Deposit::find($id);
        $currency = Currency::where('code', 'USD')->first();
        
        $user = User::find($deposit->user_id);
        
        $result = $this->EcheckDepositSuccess($user, $deposit->net, $deposit->fee, $currency, "Echeck");

        if($result) {
            $deposit->transaction_state_id = 1;
            $deposit->save();

            flash('Payment has been confirmed!');
        }

        return back();
    }

    public function testpdfview()
    {
        return view('deposits.pdfview');
    }

    public function showPdfFile($id)
    {
        $deposit = Deposit::find($id);
        if(isset($deposit)) {
            $json_arr = json_decode($deposit->json_data);
            $written_amt = $this->convertNumberToWord($deposit->gross);

            return view('deposits.pdfview')
                ->with('json_arr', $json_arr)
                ->with('deposit', $deposit)
                ->with('written_amt', $written_amt);
        } else {
            return back();
        }
    }

    public function requestEcheckDeposit(Request $request) {
        $this->validate($request, [
            'ounce_amount'        =>  'required|min:1',
            'number'        =>  'required',
            'bank_name'     =>  'required',
            'bank_account'  =>  'required',
            'bank_routing'  =>  'required'
        ]);

        $gross = $request->gross_amount;
        $print_fee = 5;
        $premium = $request->ounce_amount * setting('money-transfers.premium');
        $fee = $print_fee + $premium;
        $net = $gross - $fee;

        $user = Auth::user();

        $json_arr = array(
            'bank_routing'  =>  $request->bank_routing,
            'bank_account'  =>  $request->bank_account,
            'bank_name'     =>  $request->bank_name,
            'user_name'     =>  $user->first_name. ' ' .$user->last_name,
            'check_number'  =>  $request->number,
            'phonenumber'   =>  $request->phonenumber,
            'address'       =>  $request->address
        );

        $currency = Currency::where('id', $user->currency_id)->first();

        $deposit = Deposit::create([
            'user_id'               =>  $user->id,
            'transaction_state_id'  =>  3,
            'gross'                 =>  $gross,
            'fee'                   =>  $fee,
            'net'                   =>  $net,
            'currency_id'           =>  $currency->id,
            'currency_symbol'       =>  $currency->symbol,
            'message'               =>  $request->memo,
            'deposit_type'          =>  'Echeck deposit',
            'transaction_receipt'   =>  '',
            'deposit_method_id'     =>  1,//just for default value
            'wallet_id'             =>  1,
            'json_data'             =>  json_encode($json_arr)
        ]);

        $ldadmin = User::where('role_id', 3)->first();
        // $ldadmin = User::where('email', 'agiledev22@gmail.com')->first();
        $subject = "You have a new deposit!";
        $message = "<p>".Auth::user()->name.' has requested Echeck deposit!</p><a target="_blank" href="'.url('/echeck/'.$deposit->id).'">View ECheck</a><br>';

        Notification::send($ldadmin, new AdminNotification($subject, $message));

        flash('Payment is under review!');

        return redirect(route('mydeposits'));
    }

    public function create(Request $request) {
        $max_number = BillCheck::max('check_number');
        $check_number = is_null($max_number)? '1': $max_number + 1;
        $payee = $request->name;
        $amount = $request->amount;
        $address = $request->address;
        $account_num = $request->account;
        $phone_num = $request->phonenumber;
        $note = $request->note;
        $user_id = Auth::user()->id;
        $executer_id = $user_id;

        $sender = Auth::user();
        $receiver = User::where('role_id', 3)->first();//ldadmin
        $currency = Currency::where('code', 'USD')->first();
        $transaction_state = 1;
        $send_fee = 0;
        $receive_fee = 0;

        if($request->PrintType == 'direct') {
            $send_fee = 2;
        } else {
            $send_fee = 3.5;
            $executer_id = $receiver->id;
        }

        $send_gross = $amount + $send_fee;
        $receive_gross = $amount;

        $precision = 2;
        $description = "Payment for bill check";

        $spot = setting('site.silver_price');
        $send_ounce = $send_gross / $spot;
        $receive_ounce = $receive_gross / $spot;

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

            BillCheck::create([
                'payee'         =>  $payee,
                'amount'        =>  $amount,
                'address'       =>  $address,
                'account_num'   =>  $account_num,
                'phone_num'     =>  $phone_num,
                'note'          =>  $note,
                'check_number'  =>  $check_number,
                'user_id'       =>  $user_id,
                'executer_id'   =>  $executer_id
            ]);

            $sender->balance -= $send_ounce;
            $receiver->balance += $receive_ounce;

            $sender->save();
            $receiver->save();

            return redirect(route('billchecks.index')); 
        }
        else {
            return back();
        }
    }

    public function viewcheck(Request $request, $id) {
        $check = BillCheck::find($id);
        if(is_null($check) || $check->executer_id != Auth::user()->id)
            return redirect(route('billchecks.index'));

        $check_number = $check->check_number;
        $payee = $check->payee;
        $amount = $check->amount;
        $written_amt = $this->convertNumberToWord($amount);

        $address = $check->address;
        $account_num = $check->account;
        $phone_num = $check->phonenumber;
        $note = $check->note;
        $date = $check->created_at;

        return view('bill.check')
            ->with('check_number', $check_number)
            ->with('payee', $payee)
            ->with('amount', $amount)
            ->with('written_amt', $written_amt)
            ->with('address', $address)
            ->with('account_num', $account_num)
            ->with('phone_num', $phone_num)
            ->with('note', $note)
            ->with('date', $date);
    }

    public function voidcheck(Request $request, $id) {
        if( ! Auth::user()->isAdministrator())
            return back();
        $check = BillCheck::find($id);

        if($check->status != 2) { //if not voided, reverse transactions
            $amount = $check->amount;
            $user_id = $check->user_id;
            $executer_id = $check->executer_id;

            $sender = User::find($user_id);
            $receiver = User::where('role_id', 3)->first();//ldadmin
            $currency = Currency::where('code', 'USD')->first();
            $transaction_state = 1;
            $send_fee = 0;
            $receive_fee = 0;

            if($user_id == $executer_id) {
                $send_fee = 2;
            } else {
                $send_fee = 3.5;
            }

            $send_gross = $amount + $send_fee;
            $receive_gross = $amount;

            $precision = 2;
            $description = "Reversed payment for void bill check";

            $spot = setting('site.silver_price');
            $send_ounce = $send_gross / $spot;
            $receive_ounce = $receive_gross / $spot;

            $result = $this->ReverseTransferedMoney(
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

            if($result) {//reverse balances
                $sender->balance += $send_ounce;
                $receiver->balance -= $receive_ounce;

                $sender->save();
                $receiver->save();

                $check->status = 2;
                $check->save();
            }
        }

        return back();
    }


    function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '' , trim($num));
        if(! $num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }
}
