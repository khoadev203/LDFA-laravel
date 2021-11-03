<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use App\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller{
	public function creditCardInfo(Request $request)
    {
        $user = Auth::user();
        return view('profile.creditcard')
            ->with('owner', $user->card_owner)
            ->with('cvv', $user->card_cvv)
            ->with('cardNumber', $user->card_number)
            ->with('company', $user->card_company)
            ->with('address', $user->card_address)
            ->with('city', $user->card_city)
            ->with('state', $user->card_state)
            ->with('zip', $user->card_zip)
            ->with('country', $user->card_country);
    }

    public function storeCreditCardInfo(Request $request)
    {
        $user = Auth::user();
        $user->card_owner = $request->owner;
        $user->card_cvv = $request->cvv;
        $user->card_number = $request->cardNumber;
        $user->card_company = $request->company;
        $user->card_address = $request->address;
        $user->card_city = $request->city;
        $user->card_state = $request->state;
        $user->card_zip = $request->zip;
        $user->card_country = $request->country;
        $user->save();

        flash(__('Credit card info updated with success '), 'success');
        return back();
    }

    public function bankInfo(Request $request)
    {
        $user = Auth::user();
        return view('profile.bankinfo')->with('user', $user);
    }

    public function storeBankInfo(Request $request)
    {
        $user = Auth::user();
        $user->bank_name = $request->bank_name;
        $user->bank_checknum = $request->number;
        $user->bank_accountnum = $request->bank_account;
        $user->bank_routingnum = $request->bank_routing;
        $user->save();
        
        flash(__('Bank account info updated with success '), 'success');
        return back();
    }

	public function personalInfo(Request $request){
        //\QrCode::size(500)
        //    ->format('png')
        //    ->generate('eyJyZXNfdHlwZSI6InVzZXJfcHJvZmlsZSIsICJRckNvZGVfZ2VuZXJhdGlvbiI6IjEifQ==', public_path('images/qrcode.png'));

        $strQR = base64_encode('{"res_type":"user_profile", "QrCode_generation":"'.Auth::user()->email.'"}');
		return view('profile.info')->with('strQR', $strQR);
	}

    public function impersonateUser(Request $request, $user_id){
        if ( ! Auth::user()->isAdministrator()) {
            return back();
        }
        $user = User::FindOrFail($user_id);
        Auth::user()->impersonate($user);

        return redirect('/home');

    }

    public function getUsers(Request $request){
        if( ! Auth::User()->isAdministrator() ){
            return back();
        }

        $users = User::paginate(10);

        return view('users.index')->with('users', $users);
    }

    public function suspendUser($user_id) {
        if( ! Auth::User()->isAdministrator() ){
            return back();
        }

        $user = User::find($user_id);
        $user->account_status = 0;
        $user->save();

        return back();
    }

    public function recoverUser($user_id) {
        if( ! Auth::User()->isAdministrator() ){
            return back();
        }

        $user = User::find($user_id);
        $user->account_status = 1;
        $user->save();

        return back();
    }

    public function verifyUser($user_id) {
        if( ! Auth::User()->isAdministrator() ){
            return back();
        }

        $user = User::find($user_id);
        $user->verified = 1;
        $user->save();

        return back();
    }

	public function storePersonalInfo(Request $request){
		
		$this->validate($request, [
            // 'avatar' => 'required|mimes:jpeg,jpg,png',
            'firstName'    =>  'required',
            'lastName'	=>	'required'
        ]);

		$user = Auth::user();


 		$file = $request->file('avatar');
        if(! is_null($file)) {
            $filename = hash('sha1',$file->getClientOriginalName().'-'.time()).'.'.$file->getClientOriginalExtension() ;
            $filePath = 'users/'. Auth::user()->name.'/'.$filename;

            $image = Image::make($file);
            $image->fit(200, 200);

            

            if (Storage::put($filePath, (string) $image->encode())) {
                
                $user->avatar = Storage::url($filePath);
            
            }
        }


   //      else{
 		// 	return back();
 		// }

 		$user->first_name = $request->firstName;
 		$user->last_name = $request->lastName;
        $user->referral_note = $request->referral_note;
 		$user->save();

 		flash(__('Profile info updated with success '), 'success');
        return back();
	}

	public function newpasswordInfo(Request $request){
		return view('profile.newpassword');
	}

	public function storeNewpasswordInfo(Request $request){
        if(setting('site.demo_mode')){
            return back();
        }

		$this->validate($request, [
            'newpassword' => 'required|min:6',
            'newpasswordagain'    =>  'required|same:newpassword',
            // 'oldpassword'	=>	'required'
        ]);

		if (Auth::user()->email == 'demouser@demouser.com' or Auth::user()->email == 'admin@admin.com') {
            flash(__('Please Do not change the password of a demonstration account'), 'success');
            return back();
        }

        // if ( password_verify($request->oldpassword, Auth::user()->password) ) {
        	$user = Auth::user();
        	$user->password = bcrypt($request->newpassword);
            $user->save();
        	flash(__('Password changed with success'), 'success');

        // }else{

        // 	flash('The old password is incorrect. ','danger');
        // }

        return back();

	}

	public function profileIdentity(Request $request){
		return view('profile.identity');
	}

	public function storeProfileIdentity(Request $request){

		$this->validate($request, [
            'document' => 'required|mimes:jpeg,jpg,png'
        ]);

        $file = $request->file('document');

 		$filename = hash('sha1',$file->getClientOriginalName().'-'.time()).'.'.$file->getClientOriginalExtension() ;
 		$filePath = 'users/'.Auth::user()->name;
 		$file->storeAs($filePath , $filename );  

        $profile = Profile::where('user_id',Auth::user()->id)->first();

        if ($profile != null ) {
        	$profile->document = $filePath .'/'.$filename ;
            $profile->save();
        }else{
        	Profile::create([
        		'user_id'	=>	Auth::user()->id,
        		'document'	=>  $filePath .'/'.$filename
        	]);
        }

        return back();

		
 		
       
	}

    public function me(Request $request, $username){
        $user = User::where('name', $username)->first();

        if($user == null){
            abort(404);
        }
        
        $qrcode = base64_encode(json_encode([
            'res_type' => 'user_profile', 
            'res_code' => $user->email, 
            'res_act' => 'send'
        ]));

       

        return view('me.index')->with('user', $user)->with('QrCode', $qrcode);
    }

}