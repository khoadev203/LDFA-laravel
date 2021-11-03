<?php

namespace App;

use Storage;
use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;


class TdaccountTransaction extends Model
{
	protected $fillable = ['tdaccount_user_id', 'amount', 'currency_id', 'metal_value'];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function getAmountAttribute($value)
    {
        return $value>0?'+'.$value:$value;
    }
}