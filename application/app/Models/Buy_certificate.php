<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buy_certificate extends Model
{
    protected $fillable = ['user_id','currency_id', 'currency_amount', 'currency_net', 'currency_fee', 'metal_amount', 'cert_type', 'quantity', 'transaction_state_id', 'shipping_address'];

    public function getCreatedAtAttribute($value)
    {
        $time = strtotime($value);
        $time -= 14400;//gmt-4

        return date('d M Y', $time);
    }

    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    public function getCurrencyNetAttribute($value)
    {
        return number_format(floor($value * 100) / 100, 2, '.', '');
    }

    public function getCurrencyAmountAttribute($value)
    {
        return number_format(floor($value * 100) / 100, 2, '.', '');
    }

    public function getCurrencyFeeAttribute($value)
    {
        return number_format(floor($value * 100) / 100, 2, '.', '');
    }
}
