<?php

namespace App;

use Storage;
use Illuminate\Database\Eloquent\Model;

class TdaccountUser extends Model
{
	protected $fillable = ['user_id', 'tdaccount_id', 'term_joined', 'balance', 'got_interest_at'];

    public function account()
    {
        return $this->belongsTo(Tdaccount::class, 'tdaccount_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(TdaccountTransaction::class, 'tdaccount_user_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date("m/d/Y", strtotime($value));
    }

    public function expiration_date()
    {
        $time = strtotime($this->created_at);
        return date("m/d/Y", strtotime("+".$this->term_joined." month", $time));
    }
}