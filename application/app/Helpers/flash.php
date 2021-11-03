<?php

function flash($message, $level = 'info'){
	session()->flash('flash_message', $message);
	session()->flash('flash_message_level', $level);
}

function getExchangeRate($from_Currency, $to_Currency)
{
    $from_Currency = urlencode($from_Currency);
    $to_Currency = urlencode($to_Currency);
    $query =  "{$from_Currency}_{$to_Currency}";

    $apikey = 'd1ded944220ca6b0c442';

    // change to the free URL if you're using the free version
    $json = file_get_contents("http://free.currencyconverterapi.com/api/v5/convert?q={$query}&compact=y&apiKey={$apikey}");

    $obj = json_decode($json, true);
     
    if(empty($obj))
    {
        var_dump('Exchange rate for ' .  $from_Currency . ' to '. $to_Currency. ' has not been configured yet!');
    }

    $val = $obj["$query"];

    $precision = 8;

    $formatValue = number_format($val['val'], $precision, '.', '');
        
    return $formatValue;
}

function getMetalPrices($metal, $currencyCode) {//get metal price as Currnecy, $metal='SILVER' or 'COPPER'
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

    if($metal == 'SILVER')
    	$metal = "XAG";
    else if($metal == 'COPPER')
    	$metal = "XCU";

    $endpoint = 'latest';
    $access_key = '75e84at4xk5z43irlz5t97pem8b5cpxt6gpfs90a4yq5l2mf8nw3220nod44';
    $base = $metal;
    $symbols = $currencyCode;

    // var_dump($symbols);
    // exit();

    // Initialize CURL:
    $ch = curl_init('https://metals-api.com/api/'.$endpoint.'?access_key='.$access_key.'&base='.$base.'&symbols='.$symbols);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 50);

    // Store the data:
    $json = null;
    $json = curl_exec($ch);
    curl_close($ch);
    // Decode JSON response:
    $exchangeRates = json_decode($json, true);


    if ( is_null($exchangeRates) || ! array_key_exists('rates', $exchangeRates)) {//temporary measure to prevent exception
        $json = '{"success":true,"timestamp":1621701720,"date":"2021-05-22","base":"XAG","rates":{"BTC":0.0007193290872797439,"ETH":0.01165348701943447,"EUR":22.60160411276765,"KES":2980.36145694682,"USD":27.53157271201783},"unit":"per ounce"}';
        $exchangeRates = json_decode($json, true);
    }
    
    // Access the exchange rate values, e.g. GBP:
    $metalPrice = array();

    $metalPrices = $exchangeRates['rates'];
    foreach ($metalPrices as $key => $value) {
       $metalPrice[$key] = number_format((float)$value, 2, '.', '');
    }
    return $metalPrice;
}

// function getMetalPricesWithPremium


