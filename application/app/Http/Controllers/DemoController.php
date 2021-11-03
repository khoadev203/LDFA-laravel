<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index(Request $request){
    	return view('demo.index');
    }

    public function user(Request $request){

        if (Auth::attempt(['email' => 'demouser@demouser.com', 'password' =>'123456'])) {
            
            return redirect('/home');

        }
        abort(404);
    }
    public function admin(Request $request){
    	 if (Auth::attempt(['email' => 'admin@admin.com', 'password' =>'brazil'])) {
            
            return redirect('/admin');

        }
        abort(404);
    }
}
