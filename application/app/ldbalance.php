<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ldbalance extends Model
{
	 protected $fillable = ['user_id','amount','type','other_currency_amount','description'];

     public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }
}
