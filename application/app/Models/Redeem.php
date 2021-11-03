<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class Redeem extends Model
{
    protected $fillable = ['user_id','currency_id','ounce','transaction_state_id'];

    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }
}
 