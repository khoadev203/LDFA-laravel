<?php

namespace TCG\Voyager\Http\Controllers;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use App\ldbalance;
use App\Models\Transaction;
use App\Models\Currency;
use App\Models\Redeem;
use App\Models\Buy_certificate;
use Illuminate\Support\Facades\Auth;

class VoyagerCertificateController extends Controller
{
	public function index(Request $request){
		$getdata = Buy_certificate::where('transaction_state_id',3)->get();
		return view('voyager::certificate.index',compact('getdata'));
	}


	public function redeem(Request $request){
		$getdata = Redeem::where('transaction_state_id',3)->get();
		return view('voyager::certificate.redeem',compact('getdata'));
	}
}