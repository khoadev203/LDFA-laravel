<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorizenetLogs extends Model
{
    protected $table = 'authorizenet_logs';

    protected $fillable = [
        'amount','response_code','transaction_id', 'auth_id','quantity','message_code','name_on_card', 'user_id'
    ];

    public function getCreatedAtAttribute($value)
    {
        $time = strtotime($value);
        $time -= 14400;//gmt-4

        return date('d M Y', $time);
    }
}
