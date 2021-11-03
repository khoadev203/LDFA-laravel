<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use League\Csv\Writer;
use App\Models\Report;
use Schema;
use SplTempFileObject;

class ReportController extends Controller
{

    public function create(Request $request){
    	$input  = $request->all();
    	if(!empty($input)){
    		$date = array();
    		$date = explode("-",$input['daterange']);
    		$startdate = date("Y-m-d", strtotime($date[0]));
    		$enddate = date("Y-m-d", strtotime($date[1]));
    		if($startdate == $enddate){
 			$user = Auth::user()->RecentActivity()->with('Status')->orderby('id','desc')->whereDate('created_at', $startdate)->get();
    		}else{
    	 $user = Auth::user()->RecentActivity()->with('Status')->orderby('id','desc')->whereBetween('created_at', [$startdate, $enddate])->get();
    	} 
	 //   $path = 'D:\newxamp\setup\htdocs\ldfa\application\public\csv';
    		$path = '/home/ldfa/public_html/application/public/csv';
	    $fileName = '/'.time().'.csv';

	    $file = fopen($path.$fileName, 'w');

	    $columns = array('Date', 'Balance before Transaction','Transaction State','Activity Title','Money Flow','Transaction Amount','Balance after Transaction');

	    fputcsv($file, $columns);
	    $data = array();

		$current_balance = Auth::user()->balance;

	    foreach($user as $value){
	    	// $trans = '';
	    	// if($value->transaction_state_id == 3){
	    	// 	$trans = 'Pending';
	    	// }else if($value->transaction_state_id == 1){
	    	// 	$trans = 'Confirmed';
	    	// }
	    	if($value->transaction_state_id == 1) {
	    		$flow_amount = $value->money_flow == '-'?(-$value->metal_value):($value->metal_value);

		        $data = [
		            'Transaction Date' 				=> $value->created_at,
		            'Balance before Transaction' 	=> $current_balance - $flow_amount,
		            'Transaction Type' 				=> $value->transactionable_type,  
		            // 'Entity Name' => $value->entity_name,
		            'Activity Title' 				=> $value->activity_title,
		            'Money Flow' 					=> $value->money_flow,
		            'Transaction Amount' 			=> $value->metal_value,
		            'Balance after Transaction' 	=> $current_balance
		            // 'Transaction Time' => $value->created_at,
		        ];
	    		$current_balance -= $flow_amount;//balance before transaction

			    fputcsv($file, $data);
	    	}
		}

		Report::create([
            'user_id'   =>   Auth::user()->id,
            'path'  =>  $path.$fileName, 
            'daterange'    =>  $input['daterange'],
        ]);

	    fclose($file);
	  return redirect(route('view_report'));	
	}
    	return view('report.create');
    }

    public function index(Request $request){
    	$getdata = Report::where('user_id',Auth::user()->id)->paginate(10);
    	return view('report.view',compact('getdata'));
    }

    public function download_csv($id,Request $request){
    	$getdata = Report::where('id',$id)->first();
    	  $headers = array(
        	'Content-Type' => 'text/csv',
	    );
		    return Response::download($getdata->path, time().'.csv', $headers);
	    }
}
 