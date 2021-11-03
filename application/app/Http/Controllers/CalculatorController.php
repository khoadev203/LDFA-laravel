<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Currency;

class CalculatorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        $currencies = Currency::get();
        return view('calculator.index')->with('currencies', $currencies);
    }
}