<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CoinOrder extends Model
{
    protected $fillable = ['user_id', 'name', 'email', 'shipping_address', 'quantity', 'price'];

    public function getStatusAttribute($value)
    {
        if($value == 0)
            return "Pending";
        else
            return "Completed";
    }
}