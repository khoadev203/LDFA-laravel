<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\CurrencyExchangeRate;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{


    public function getExchangeRequestForm(Request $request, $currency_id = null, $second_currency_id = null ){

        $firstCurrency = Currency::find(Auth::user()->currency_id);

        // $secondCurrenciesExchanges = CurrencyExchangeRate::with('secondCurrency')->where('first_currency_id', $firstCurrency->id)->get();
        $secondCurrenciesExchanges = Currency::where('id', '<>', $firstCurrency->id)->get();//currencies which are exchangeable with second currency

        if (count($secondCurrenciesExchanges) == 0) {
            dd('Please Contact the site admin to add currency exchange rates for '.$firstCurrency->name.' currency  -> '. url('/') . '/update_rates' );
        }

        // $firstCurrenciesExchages = CurrencyExchangeRate::with('firstCurrency')->select('first_currency_id')->distinct()->get();
        $firstCurrenciesExchages = Currency::get();//currencies which are exchangeable with first currency

        if (count($firstCurrenciesExchages) == 0 ) {
            dd('Please Contact the site admin to add currency exchange rates ');
        }

        //validate second currency
        if (is_null($second_currency_id) or !($second_currency_id)) {
            // $secondCurrency = $secondCurrenciesExchanges[0]->secondCurrency;
            $secondCurrency = $secondCurrenciesExchanges[0];
        }else{
            $secondCurrency = Currency::find($second_currency_id);
            if (is_null($secondCurrency)) {
                abort(404);
            }
        }
        if ($firstCurrency->id == $secondCurrency->id) {
            return redirect(url('/home'));
        }

        if ($secondCurrency == null) {
            return back();
        }

        //Auth::user()->currency_id = $firstCurrency->id;
        //Auth::user()->save();
        
        if ( $secondCurrency->id == Auth::user()->currency_id) {
             $currency = Auth::user()->walletByCurrencyId($firstCurrency->id);
                if ($currency) {
                    Auth::user()->currency_id = $firstCurrency->id;
                    Auth::user()->save();
                }
            return redirect($request->url());
        } else {
            $wallet = Wallet::with('Currency')->where('user_id', Auth::user()->id)->where('currency_id',$secondCurrency->id)->first();//wallet of second currency

            if ($wallet == null) {
                $wallet = Auth::user()->newWallet($secondCurrency->id);
            }
        }

        // $exchange = CurrencyExchangeRate::where('first_currency_id', $firstCurrency->id)->where('second_currency_id', $secondCurrency->id)->first();
        $show_exchange_rates_form = false ;
        $currencies = Currency::all();

        if (Auth::user()->isAdministrator() and !is_null($currencies)) {
            $show_exchange_rates_form = true;
        }
        
        $exchange = $this->getExchangeRate($firstCurrency['code'], $secondCurrency['code']);//first->second exchange rate

        if ($exchange == null) {
            dd('Please Contact the site admin to add exchange rate for ' .  $firstCurrency->name . ' to '. $secondCurrency->name);
        }
        
        // $update_rates = CurrencyExchangeRate::with('secondCurrency')->where('first_currency_id', $firstCurrency->id)->get();
        
        $update_rates = $this->getExchangeRate($secondCurrency['code'], $firstCurrency['code']);//second->first exchnage rate

        return view('exchange.exchangeRequestForm')
        ->with('show_exchange_rates_form', $show_exchange_rates_form)
        ->with('currencies', $currencies)
        ->with('wallet',$wallet)
        ->with('update_rates', $update_rates)
        ->with('exchange', $exchange)
        ->with('secondCurrency',$secondCurrency)
        ->with('firstCurrency',$firstCurrency)
        ->with('secondCurrenciesExchanges',$secondCurrenciesExchanges)
        ->with('firstCurrenciesExchages',$firstCurrenciesExchages);
    }

    public function getExchangeRate($from_Currency, $to_Currency)
    {
        $from_price = 1;
        $to_price = 1;
        if($from_Currency == 'SILVER' || $from_Currency == 'COPPER') {
            $from_price = $this->getMetalExchangeRate($from_Currency);
            $from_Currency = 'USD';
        }

        if($to_Currency == 'SILVER' || $to_Currency == 'COPPER') {
            $to_price = $this->getMetalExchangeRate($to_Currency);
            $to_Currency = 'USD';
        }

        $from_Currency = urlencode($from_Currency);
        $to_Currency = urlencode($to_Currency);
        $query =  "{$from_Currency}_{$to_Currency}";

        $apikey = 'd1ded944220ca6b0c442';
   
        // change to the free URL if you're using the free version
        $json = file_get_contents("http://free.currencyconverterapi.com/api/v5/convert?q={$query}&compact=y&apiKey={$apikey}");
   
        $obj = json_decode($json, true);
         
        if(empty($obj))
        {
            dd('Exchange rate for ' .  $from_Currency . ' to '. $to_Currency. ' has not been configured yet!');
        }

        $val = $obj["$query"];
   
        $total = $val['val'] * $to_price / $from_price;//multiply price in case it's metal
   
        $precision = 8;

        $formatValue = number_format($total, $precision, '.', '');
            
        return $formatValue;
    }

    function getMetalExchangeRate($metal) {//get silver price as USD
        // $curlUrl = 'https://xml.dgcsc.org/xml.cfm?password=73A134056310BCD75627CDB21CCD011D299B694B&action=SilverJBAO';
        // $curl = curl_init();
        // curl_setopt_array($curl, [
        //     CURLOPT_URL => $curlUrl,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_CUSTOMREQUEST => 'GET', 
        // ]);
                    
        // $curlResponse = json_decode(curl_exec($curl), true);
        // curl_close($curl);
        // return number_format(floatval($curlResponse['SilverPrice']['USD']['bid']), 2);//it has bid and ask price

        $endpoint = 'latest';
        $access_key = '9z1sufigd5cdwq8635c0t6fkomw7jxmgft22cubcgpdeiqb5ncu4zk2m77zc';
        $base = 'USD';
        $symbols = 'XAG,XCU';
        // Initialize CURL:
        $ch = curl_init('https://metals-api.com/api/'.$endpoint.'?access_key='.$access_key.'&base='.$base.'&symbols='.$symbols);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);
        
        // Decode JSON response:
        $exchangeRates = json_decode($json, true);
        
        // Access the exchange rate values, e.g. GBP:
        if($metal == 'SILVER')
            return $exchangeRates['rates']['XAG'];
        else if($metal == 'COPPER')
            return $exchangeRates['rates']['XCU'];
    }

    public function exchange(Request $request){
        $this->validate($request, [
            'amount'    =>  'required|numeric|between:0.0001,'.Auth::user()->currentWallet()->amount,
            'first_currency_id'   =>  'required',
            'second_currency_id' => 'required'
        ]);

        $firstCurrency = Currency::find($request->first_currency_id);
        $secondCurrency = Currency::find($request->second_currency_id);

        if ( Auth::user()->account_status == 0 ) {
            flash(__('Your account is under a withdrawal request review proccess. Please wait until your request is complete in a few minutes to continue with your activities.') , 'info');
             return  back();
        }

        $currencyexchange = $this->getExchangeRate($firstCurrency->code, $secondCurrency->code);

        // $currencyexchange = CurrencyExchangeRate::with('firstCurrency','secondCurrency')->find($request->exchange_id);

        $firstWallet = Wallet::where('currency_id', $firstCurrency->id)->where('user_id', Auth::user()->id)->first();

        $secondWallet = Wallet::where('currency_id', $secondCurrency->id)->where('user_id', Auth::user()->id)->first();

        if ( $firstCurrency->is_crypto == 1 ){
            $first_precision = 8 ;
        } else {
            $first_precision = 2;
        }

        $firstWallet->amount = bcsub(''.$firstWallet->amount , ''.$request->amount, $first_precision);

        if ( $secondCurrency->is_crypto == 1 ){
            $second_precision = 8 ;
        } else {
            $second_precision = 2;
        }
        $secondCurrencyExchangedValue = bcmul(''.$request->amount, $currencyexchange, $second_precision );

        $secondWallet->amount = bcadd(''.$secondWallet->amount, ''.$secondCurrencyExchangedValue,  $second_precision ) ;

        $firstWallet->save();
        $secondWallet->save();

        $fee = 0;
        if($secondCurrency->code == 'SILVER' || $secondCurrency->code=='COPPER')
        {
            $fee =  $request->amount * 0.075;
        }

        $exchange = Exchange::create([
            'user_id'   =>  Auth::user()->id,
            'first_currency_id' =>   $firstCurrency->id,
            'second_currency_id'    =>  $secondCurrency->id,
            'gross' =>  $request->amount + $fee,
            'fee'   =>  $fee,
            'net'   =>  $request->amount,
        ]);

        Auth::User()->RecentActivity()->save($exchange->Transactions()->create([
            'user_id' => Auth::User()->id,
            'entity_id'   =>  $exchange->id,
            'entity_name' =>   $firstCurrency->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '-',
            'currency_id' =>  $firstCurrency->id,
            'currency_symbol' =>  $firstCurrency->symbol,
            'activity_title'    =>  'Currency Exchange',
            'thumb' =>  $firstCurrency->thumb,
            'gross' =>  $exchange->gross,
            'fee'   =>  $exchange->fee,
            'net'   =>  $exchange->net,
            'balance'   =>  $firstWallet->amount
        ]));

        Auth::User()->RecentActivity()->save($exchange->Transactions()->create([
            'user_id' => Auth::User()->id,
            'entity_id'   =>  $exchange->id,
            'entity_name' =>   $secondCurrency->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '+',
            'currency_id' =>  $secondCurrency->id,
            'currency_symbol' =>  $secondCurrency->symbol,
            'thumb' =>  $secondCurrency->thumb,
            'activity_title'    =>  'Currency Exchange',
            'gross' =>  $request->amount * $currencyexchange,
            'fee'   =>  0,
            'net'   =>  $request->amount * $currencyexchange,
            'balance'   =>  $secondWallet->amount
        ]));

        return redirect('home');
    }

    //is not needed
    public function updateRate(Request $request) {

        $this->validate($request, [
            'second_currency_id' => 'exists:currencies,id|numeric',
            'amount'    =>  'required'
        ]);

        $currency_exchange_rate = CurrencyExchangeRate::where('first_currency_id', Auth::user()->currency_id)->where('second_currency_id', $request->second_currency_id)->first();

        if (is_null($currency_exchange_rate)) {
            CurrencyExchangeRate::create([
                'first_currency_id' => Auth::user()->currency_id,
                'second_currency_id' => $request->second_currency_id,
                'exchanges_to_second_currency_value'    =>  $request->amount
            ]);
            return back();
        }

        $currency_exchange_rate->exchanges_to_second_currency_value = $request->amount;
        $currency_exchange_rate->save();

        return back();
    }

    //is not needed
    public function updateRateForm() {

        $show_exchange_rates_form = false ;
        $currencies = Currency::all();

        if (Auth::user()->isAdministrator() and !is_null($currencies)) {
            $show_exchange_rates_form = true;
        }else{
            return back();
        }

        $update_rates = CurrencyExchangeRate::with('secondCurrency')->where('first_currency_id', Auth::user()->currency_id)->get();
        return view('exchange.ExchangeRates')
        ->with('show_exchange_rates_form', $show_exchange_rates_form)
        ->with('currencies', $currencies)
        ->with('update_rates', $update_rates) ;
    }
}

