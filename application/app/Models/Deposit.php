<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    //protected $with = ['Method','Status'];
    protected $fillable = ['user_id', 'transaction_state_id', 'transaction_receipt', 'deposit_method_id', 'gross', 'fee', 'net', 'json_data', 'wallet_id', 'currency_id', 'currency_symbol','message', 'deposit_type'];

    public function getCreatedAtAttribute($value)
    {
        $time = strtotime($value);
        $time -= 14400;//gmt-4

        return date('m/d/Y', $time);
    }

    public function User() {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }


    public function Transactions() {
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }
    
    public function Method() {
        return $this->hasOne(\App\Models\DepositMethod::class, 'id', 'deposit_method_id');
    }

    public function Status() {
        return $this->hasOne(\App\Models\TransactionState::class, 'id', 'transaction_state_id');
    }

    public function gross() {
        return $this->money_flow .' '. number_format((float)$this->gross, 2, '.', '') .  $this->currency_symbol;
    } 

    public function gross_without_symbol() {
        return number_format((float)$this->gross, 2, '.', ',') ;
    }

    public function fee() {
        if ($this->fee > 0) {
            return  '- ' . number_format((float)$this->fee, 2, '.', '') . $this->currency_symbol;
        }
        return number_format((float)$this->fee, 2, '.', '') . $this->currency_symbol;
    }

    public function net() {
         return $this->money_flow .' '. number_format((float)$this->net, 2, '.', '') .  $this->currency_symbol;
    }

}
