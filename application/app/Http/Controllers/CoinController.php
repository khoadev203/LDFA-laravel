<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\CoinOrder;
use App\Models\Currency;
use App\User;
use Notification;
use App\Notifications\AdminNotification;
class CoinController extends Controller
{
	public function showOrderForm()
	{
		return view('coin.order');
	}

	public function order(Request $request)
	{
		$silver_price = setting('site.silver_price');
		$coin_order_fee = setting('merchant.coin_order_fixed_fee');
		$price = $silver_price + $coin_order_fee;
		$ounce_ordered = $request->quantity;
		$ounce_consumed = $ounce_ordered * $price / $silver_price;

		if(Auth::user()->balance >= $ounce_consumed) {
			CoinOrder::create([
				'user_id'			=>	Auth::user()->id,
				'name'				=>	$request->name,
				'email'				=>	$request->email,
				'shipping_address'	=>	$request->shipping_address,
				'quantity'			=>	$request->quantity,
				'price'				=>	$price
			]);

			$currency = Currency::find(Auth::user()->currency_id);
			$ldadmin = User::where('role_id', 3)->first();

	        $subject = Auth::user()->name.' has ordered coin!';
	        $message = '<p>Name: '.$request->name.'<br>Email: '.$request->email.'<br>Shipping Address:'.$request->shipping_address.'<br>Quantity: '.$request->quantity.' ounce(s)</p><a target="_blank" href="'.url('/admin/coin-orders').'">View Coin Orders</a><br>';
	        Notification::send($ldadmin, new AdminNotification($subject, $message));

			$result = $this->TransferMoney(
	            Auth::user(),
	            $ldadmin,
	            $currency,
	            1,
	            $price * $ounce_ordered,
	            $coin_order_fee * $ounce_ordered,
	            $silver_price * $ounce_ordered,
	            0,
	            $ounce_consumed,
	            $ounce_ordered,
	            2,
	            "Payment for coin order!"
	        );

			if($result) {
				$ldadmin->balance += $ounce_ordered;
				$ldadmin->save();

				Auth::user()->balance -= $ounce_consumed;
				Auth::user()->save();

				flash(__('You have ordered coin!'));

				return redirect(route('coin.myorders'));
			}
			else
				return back();
		} else {
			flash(__('You do not have enough balance'), 'danger');
			return back();
		}
	}

	public function confirmOrder($id)
	{
		$order = CoinOrder::find($id);
		if($order != null)
		{
			$order->status = 1;
			$order->save();
			return back();
		}
	}

	public function myOrders()
	{
		$orders = CoinOrder::where('user_id', Auth::user()->id)->get();
		return view('coin.myOrders')->with('orders', $orders);
	}
}