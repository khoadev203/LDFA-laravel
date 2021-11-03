<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\User;
use Illuminate\Http\Request;
use App\Models\Button;
use App\Models\Purchase;
use App\Models\Subscription;
use App\Models\Donation;
use Illuminate\Support\Facades\Storage;
use App\Models\Currency;

class ButtonController extends Controller
{
    public function index() {
        return view('button.index');
    } 

    public function createbutton($type, Request $request) {
        $user = Auth::user();
        $input = $request->all();

        if( ! empty($input)) {

            unset($input['_token']);

            $dropdowns = null;
            if(! empty($input['dropdown-item']))
                $dropdowns = implode('^', $input['dropdown-item']);

            // dd($input);
            if($type == 'Buy') {
                $button = Button::create([
                    'user_id'   =>  Auth::user()->id,
                    'itemname'  =>  $input['itemname'],
                    'price'     =>  $input['price'],
                    'shipping'  =>  $input['shipping'],
                    'type'      =>  $type,
                    'dropdowns' =>  $dropdowns,
                    'quantity'  =>  $input['quantity'],
                ]);
            } else if($type == 'Subscribe') {
                $button = Button::create([
                    'user_id'   =>  Auth::user()->id,
                    'itemname'  =>  $input['itemname'],
                    'price'     =>  $input['price'],
                    'type'      =>  $type,
                    'dropdowns' =>  $dropdowns,
                    'billing_cycle'  =>  $input['billing_cycle'],
                    'billing_cycle_unit'  =>  $input['billing_cycle_unit'],
                    'billing_stop'  =>  $input['billing_stop'],
                ]);
            } else {//Donate
                $button = Button::create([
                    'user_id'   =>  Auth::user()->id,
                    'price'     =>  $input['price'],
                    'type'      =>  $type,
                    'description'   =>  $input['description']
                ]);
            }

            flash(__('You have created a new button!'));
            return redirect(route('button.addbutton',$button->id));
        } else {    
            return view('button.create')
                ->with('type', $type);
        }
    }

    public function addbutton($id) {
        $getdata = Button::where('id', $id)->first();
        $str_dropdowns = $getdata['dropdowns'];

        return view('button.addbutton')
            ->with('data', $getdata)
            ->with('dropdowns', $this->getDropdownArray($str_dropdowns));
    }

    public function deleteButton($id) {

    }

    public function getDropdownArray($str_dropdowns)
    {
        $dropdowns = array();

        if( ! is_null($str_dropdowns))
        {
            $arr_dropdowns = explode("^", $str_dropdowns);
            foreach($arr_dropdowns as $item)
            {
                $name_options = explode(": ", $item);

                $item_name = $name_options[0];
                $item_options = explode(", ", $name_options[1]);
                array_push($dropdowns, ['name' => $item_name, 'options' => $item_options]);
            }
        }
        return $dropdowns;
    }

    public function paypage(Request $request) {
        $id = $_GET['hosted_button_id'];
        $getid = unserialize(base64_decode($id));
        $req = $request->all();
        
        $items = [];
        if(array_key_exists('item', $req))
            $items = $req['item'];

        $button = Button::where('id',$getid)->first();

        return view('button.pay',compact('req', 'button', 'items'));
    }

    public function paymoney($id, Request $request) {

        // $getid = unserialize(base64_decode($id));

        $button = Button::where('id', $id)->first();
        $metalPrice = setting('site.silver_price');
        $gross = $button->price() + $button->shipping();
        $net = $gross;
        $fee = 0;
        $user_id = Auth::user()->id;
        $merchant_id = $button->user_id;
        $json_data = $request->json_data;
        
        if($gross <= 0) {
            flash(__('Amount should not be less than or equals to zero'));
            return  back();
        }

        if($gross > Auth::user()->balance) {
            flash(__('You have insufficient funds'), 'danger');
            return  back();
        }

        if ($user_id == $merchant_id) {
            flash(__('You can\'t send money to the same account you are in') , 'danger');
            return  back();
        }

        $purchase = Purchase::create([
            'user_id'       =>  $user_id,
            'merchant_id'   =>  $merchant_id,
            'button_id'     =>  $button->id,
            'gross'         =>  $gross,
            'fee'           =>  $fee,
            'net'           =>  $net,
            'metal_price'   =>  $metalPrice,
            'json_data'     =>  $json_data
        ]);

        $merchant = User::find($merchant_id);
        $sender = User::find($user_id);

        $currency = Currency::where('code', 'USD')->first();

        $result = $this->TransferMoney(
            $sender,
            $merchant,
            $currency,
            1,
            $gross * $metalPrice,
            0,
            $gross * $metalPrice,
            0,
            $gross,
            $gross,
            2,
            "Purchased product"
        );

        $sender->balance -= $gross;
        $merchant->balance += $gross;

        $sender->save();
        $merchant->save();

        flash('You paid '.$gross.' ounces for the product!');
        return redirect(route('purchasehistory'));
    }

    public function purchaseHistory() {
        $purchases = Purchase::where('user_id', Auth::user()->id)
            ->get();
        return view('button.purchases', compact('purchases'));
    }

    public function view(Request $request) {
        $getdata = Button::where('user_id', Auth::user()->id)->orderby('created_at', 'desc')->paginate(5);
        return view('button.view',compact('getdata'));
    }

    public function showDonateForm(Request $request)
    {
        $id = $_GET['hosted_button_id'];
        $getid = unserialize(base64_decode($id));
        $button = Button::where('id',$getid)->first();
        $donate_to = User::find($button->user_id)->email;
        return view('button.donate')
            ->with('button', $button)
            ->with('donate_to', $donate_to);
    }

    public function donate(Request $request)
    {
        $btn_id = $request->button_id;
        $button = Button::find($btn_id);
        $metalPrice = setting('site.silver_price');
        $sender = Auth::user();
        $receiver = User::find($button->user_id);
        $gross = $button->price();

        if ($sender->id == $receiver->id) {
            flash(__('You can\'t send money to the same account you are in') , 'danger');
            return  back();
        }
        Donation::create([
            'user_id'   =>  $sender->id,
            'button_id' =>  $button->id,
            'metal_price'   =>  $metalPrice
        ]);

        $currency = Currency::where('code', 'USD')->first();

        $result = $this->TransferMoney(
            $sender,
            $receiver,
            $currency,
            1,
            $gross * $metalPrice,
            0,
            $gross * $metalPrice,
            0,
            $gross,
            $gross,
            2,
            "Donated"
        );

        if($result) {
            $sender->balance -= $gross;
            $receiver->balance += $gross;

            $sender->save();
            $receiver->save();
        }


        flash('You have donated '.$gross.' ounces to '.$receiver->email);
        return redirect(route('donations'));
    }

    public function donations()
    {
        $donations = Donation::where('user_id', Auth::user()->id)
            ->get();
        return view('button.donations', compact('donations'));
    }    

    public function showSubscribeForm(Request $request)
    {
        $id = $_GET['hosted_button_id'];
        $getid = unserialize(base64_decode($id));
        $req = $request->all();
        
        $items = [];
        if(array_key_exists('item', $req))
            $items = $req['item'];

        $button = Button::where('id',$getid)->first();

        return view('button.subscribe',compact('req', 'button', 'items'));
    }

    public function subscribe(Request $request)
    {
        $id = $request->button_id;
        $button = Button::where('id', $id)->first();
        $metalPrice = setting('site.silver_price');
        $user_id = Auth::user()->id;
        $merchant_id = $button->user_id;
        $json_data = $request->json_data;
        

        if ($user_id == $merchant_id) {
            flash(__('You can\'t send money to the same account you are in') , 'danger');
            return  back();
        }

        $subscription = Subscription::create([
            'user_id'       =>  $user_id,
            'merchant_id'   =>  $merchant_id,
            'button_id'     =>  $button->id,
            'metal_price'   =>  $metalPrice,
            'json_data'     =>  $json_data
        ]);

        flash('You have subscribed!');
        return redirect(route('subscriptions'));
    }

    public function subscriptions(Request $request)
    {
        $subscriptions = Subscription::where('user_id', Auth::user()->id)
            ->get();
        return view('button.subscriptions', compact('subscriptions'));
    }
}