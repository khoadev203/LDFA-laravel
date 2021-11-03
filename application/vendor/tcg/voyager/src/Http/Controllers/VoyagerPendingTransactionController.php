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

class VoyagerPendingTransactionController extends Controller
{
	public function index(){
		if(Auth()->user()->isAdministrator()){
		$getdata = Transaction::where('transaction_state_id',3)->where('transactionable_type','App\Models\Receive')->where('activity_title','Requested purchase')->paginate(10);
		}else{
			$getdata = array();
		}
		return view('voyager::transactions.index',compact('getdata'));
	}
}
?>