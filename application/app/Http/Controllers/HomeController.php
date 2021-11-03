<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Escrow;
use App\User;
use Twilio;
use Mail;
use App\Models\Otp;
use App\Mail\otpEmail;
use App\Models\Receive;
use App\Models\Transactions;
use App\Models\Currrency;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Page;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getPage']]);
    }

    public function getPage(Request $request, $id) {
        
        $page = Page::where('id', $id)->first();

        if ($page != null) {
            if($id == 14) {
                return redirect(route('calculator'));
            } else {
                return view('page.show')->with('page', $page);
            }
        }

        return abort(404);
    }

    public function accountStatus(Request $request, $user) {
        $user = User::findOrFail($user);
        $user->account_status = 0;
        $user->save();
        return back();
    }
    public function locale(Request $request, $locale) {
        
        dd($locale);
        App::setLocale($locale);
        return view('welcome');
    }
    
    public function wallet(Request $request, $id) {

        $currency = Auth::user()->walletByCurrencyId($id);
        if ($currency) {
            
            Auth::user()->currency_id = $id;
          
            Auth::user()->save();
        }
        return back();
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $agent = new Agent();

        // Twilio::message('+258850586897', array(
        //     'body' => 'hihaa',
        //     'SERVICE SID'  =>  'Envato',
        // ));
        if (!Auth::user()->verified) {
            $id = base64_encode(serialize(Auth::user()->id));

            return view('otp.index',compact('id'));
        }        
 
        $myMoneyRequests = Receive::with('From')->where('transaction_state_id', 3)->where('user_id', Auth::user()->id)->get();
        
        $myEscrows = Escrow::with('toUser')->where('user_id', Auth::user()->id)->where('escrow_transaction_status', '!=' ,'completed')->orderby('id', 'desc')->get();
        $toEscrows = Escrow::with('user')->where('to', Auth::user()->id)->where('escrow_transaction_status', '!=' ,'completed')->orderby('id', 'desc')->get();

        $transactions = Auth::user()->RecentActivity()->with('Status')->orderby('id','desc')->where('transaction_state_id', '!=', 3)->paginate(10);
         
        $referrer = Auth::user()->referrer()->get();

        $transactionsToConfirm =  Auth::user()->RecentActivity()->with('Status')->orderby('id','desc')->where('transaction_state_id', 3)->paginate(10);
        // if($agent->isMobile()){
        //     return view('_mobile.home.index')
        //     ->with('transactions', $transactions)
        //     ->with('transactions_to_confirm', $transactionsToConfirm);
        // } 

        return view('home.index')
        ->with('myRequests', $myMoneyRequests)
        ->with('transactions', $transactions)
        ->with('myEscrows', $myEscrows)
        ->with('toEscrows', $toEscrows)
        ->with('transactions_to_confirm', $transactionsToConfirm)
        ->with('referrer', $referrer);
    }
    public function resendOtp(Request $request){
        $user = Auth::user();
        $generated_otp = $this->randInt(6) . '';
         $Otp = Otp::where('user_id',$user->id)->first();
         $Otp->otp = password_hash($generated_otp, PASSWORD_DEFAULT);
         $Otp->save();
       //  if (Auth::attempt(['email' => $user->email, 'password' => $user->password])) {
            $referrer = DB::table('users')
        ->where('name', session()->pull('referrer'))
        ->where('account_status', '=', '1')
        ->first();
            //Send otp Mail
            Mail::send(new otpEmail( $user->email, $generated_otp));

            //Send otp SMS

           // Twilio::message($user->phonenumber, array(
           //      'body' => __('Your ') . setting('site.title') . __(' one time password (OTP) is :  ') . $generated_otp . __('   Do not share this code with others.'),
           //      'SERVICE SID'  =>  'Envato',
           //  ));
            // if ($referrer !== null) {
            //     Mail::send(new referralNotification($referrer->email));
            // }

            return redirect('/home');
      //  }
        return redirect('/home');
    }
    private function randInt($digits){

        return rand(pow(10, $digits-1), pow(10, $digits)-1);

        // return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

    }
}
 