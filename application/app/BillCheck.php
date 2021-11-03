<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class BillCheck extends Model
{
    protected $fillable = ['payee', 'amount', 'address', 'account_num', 'phone_num', 'note', 'check_number', 'user_id', 'executer_id'];

    public function getCreatedAtAttribute($value)
    {
        $time = strtotime($value);
        $time -= 14400;//gmt-4

        return date('Y/m/d', $time);
    }

    public function getCheckNumberAttribute($value)
    {
    	$length = 4;
    	return substr(str_repeat(0, $length).$value, - $length);
    }
}
