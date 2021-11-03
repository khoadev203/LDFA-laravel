<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Auth;
use Twilio;
use Mail;
use Storage;
use App\User;
use App\Models\Wallet;
use App\Models\Otp;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Mail\verifyEmail;
use App\Mail\otpEmail;
use App\Mail\Mail\Support;
use App\Mail\referralNotification;
use App\Notifications\MemberNotification;
use Notification;
use App\Mail\TestMail;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class SignUpController extends Controller
{
    public function showRegistrationForm(Request $request)
    {
        // if ($request->has('ref')) {
        //     session(['referrer' => $request->query('ref')]);
        // }
        $referral_note = null;
        if ($request->has('ref')) {
            $referrer = User::where('name', $request->ref)->first();
            if( ! empty($referrer))
                $referral_note = $referrer->referral_note;
        }
        $countries = Country::all();
        return view('auth.register')
            ->with('countries', $countries)
            ->with('referral_note', $referral_note);
    }

    public function supportEmail(Request $request) {
        //prevent spams
        if ($request->faxonly) {
            return redirect()->back()
                ->withSuccess('Your form has been submitted'); 
        }
        if (strpos($request->message, "href=") || strpos($request->message, "http")) {
            return redirect()->back()
                ->withSuccess('Your form has been submitted');
        }

        $input = $request->all();
        $email = $input['email'];
        $name = 'Request From '.$input['name'].' ( '.$input['email'].' )';
        $message = $input['message'];

        $mailto = array();
        $mailto[0] = 'admin@ldfa.nl';
        $mailto[1] = 'agiledev22@gmail.com';

        foreach($mailto as $value){
            Mail::send(new Support( $value, $name, $message));
        }
         return redirect('/');
    }

	public function register(Request $request) {
        $referrer = DB::table('users')
            ->where('name', Cookie::get('referral'))
            ->where('account_status', '=', '1')
            ->first();
        
		$currency = Currency::orderBy('id','asc')->first();

		$this->validate($request, [
            'email' => 'required|unique:users,email|email|max:255',
            'name'  =>  'required|unique:users,name|alpha_dash|min:5',
            'password'  =>  'required|min:6',
            'password_confirmation'	=>	'required|same:password',
            //'phone' =>  'required|phone:US,CA,AF,AL,DZ,AS,AD,AO,AI,AQ,AG,AR,AM,AW,AU,AT,AZ,BS,BH,BD,BB,BY,BE,BZ,BJ,BM,BT,BO,BA,BW,BV,BR,IO,BN,BG,BF,BI,KH,CM,CV,KY,CF,TD,CL,CN,CX,CC,CO,KM,CG,CK,CR,HR,CU,CY,CZ,CD,DK,DJ,DM,DO,TP,EC,EG,SV,GQ,ER,EE,ET,FK,FO,FJ,FI,FR,FX,GF,PF,TF,GA,GM,GE,DE,GH,GI,GR,GL,GD,GP,GU,GT,GN,GW,GY,HT,HM,HN,HK,HU,IS,IN,ID,IR,IQ,IE,IL,IT,CI,JM,JP,JO,KZ,KE,KI,KP,KR,KW,KG,LA,LV,LB,LS,LR,LY,LI,LT,LU,MO,MK,MG,MW,MY,MV,ML,MT,MH,MQ,MR,MU,TY,MX,FM,MD,MC,MN,MS,MA,MZ,MM,NA,NR,NP,NL,AN,NC,NZ,NI,NE,NG,NU,NF,MP,NO,OM,PK,PW,PA,PG,PY,PE,PH,PN,PL,PT,PR,QA,SS,RE,RO,RU,RW,KN,LC,VC,WS,SM,ST,SA,SN,RS,SC,SL,SG,SK,SI,SB,SO,ZA,GS,ES,LK,SH,PM,SD,SR,SJ,SZ,SE,CH,SY,TW,TJ,TZ,TH,TG,TK,TO,TT,TN,TR,TM,TC,TV,UG,UA,AE,GB,UM,UY,UZ,VU,VA,VE,VN,VG,VI,WF,EH,YE,YU,ZR,ZM,ZW,mobile|unique:users,phonenumber|min:6',
            //'CC'    =>  'required_with:phone|exists:countries,code',
            'terms' => 'required'
        ]);

        $number = (string) PhoneNumber::make($request->phone, $request->CC); 

        $user = User::create([
            'name'  => $request->name,
            'email' =>  $request->email,
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'avatar'    => Storage::url('users/default.png'),
            'password'  =>  bcrypt($request->password),
            'currency_id'	=>	 $currency->id,
            'whatsapp'  =>  $number,
            'phonenumber'   =>  $request->phone,
            'verification_token'  => str_random(40),
            'referrer_id' => $referrer ? $referrer->id : null
        ]);

        //dd($user);

        $admin = User::where('email', 'agiledev22@gmail.com')->first();
        Notification::send($admin, new MemberNotification("New user has registered to LDFA!", "Dear Administrator, ".$request->email.' has registered to LDFA!'));

        //Mail::send(new VerifyEmail($user));

        $generated_otp = $this->randInt(6) . '';

        if ($user) {
        	wallet::create([
                'is_crypto' =>  $currency->is_crypto,
        		'user_id'	=> $user->id,
        		'amount'	=>	0,
        		'currency_id'	=> $currency->id
        	]);

            $Otp = Otp::create([
                'user_id'   => $user->id,
                'otp'   => password_hash($generated_otp, PASSWORD_DEFAULT)
           ]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            
            //Send otp Mail 
           Mail::send(new otpEmail( $user->email, $generated_otp));

            //Send otp SMS

           // Twilio::message($user->phonenumber, array(
           //      'body' => __('Your ') . setting('site.title') . __(' one time password (OTP) is :  ') . $generated_otp . __('   Do not share this code with others.'),
           //      'SERVICE SID'  =>  'Envato',
           //  ));
            if ($referrer !== null) {
                Mail::send(new referralNotification($referrer->email, $user->email));
            }

            return redirect('/home');
        }

        return redirect('/');
	}

    public function verifyEmail(Request $request, $email, $token){
        
        if ($email) {
           
           $user = User::where('email', $email)->where('verified', 0)->first();

           if (!is_null($user) and $user->verification_token == $token) {
               
                $user->verified = 1;
                $user->verification_token = NULL;
                $user->save();
           }

           return redirect('/home');
        }
    }

    public function postOtp(Request $request){

        $this->validate($request, [
            'otp'   =>  'required|numeric'
        ]);

        $otp = Otp::where('user_id', Auth::user()->id)->orderby('id', 'desc')->first();

        if (is_null($otp)) {
           abort(404);
        }
        if (password_verify($request->otp, $otp->otp)) {
            Auth::user()->verified = 1;
            Auth::user()->save();
            return back();
        }
        flash('Invalid One Time Password', 'danger');
        return back();
    }

    public function resendActivactionLink(Request $request){
        
        $string = str_random(40);
        
        $user = Auth::user();
        $user->verification_token = $string;
        $user->save();

        Mail::send(new VerifyEmail($user->email));

        flash(__('activation link succesfuly sent'), 'success');

       return back();
    }

    public function TestMail(Request $request){
        
        
    }

    public function OTP(Request $request){
        if (Auth::user()->verified) {
            return redirect('/home');
        }
        return view('otp.index');
    }

    private function randInt($digits){

        return rand(pow(10, $digits-1), pow(10, $digits)-1);

        // return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

    }


}