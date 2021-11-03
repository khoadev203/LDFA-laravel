<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    
    protected $fillable = ['user_id', 'itemname', 'price', 'shipping','type', 'quantity', 'dropdowns', 'billing_cycle', 'billing_cycle_unit', 'billing_stop', 'description', 'created_at', 'updated_at'];


    public function price() {

        return  number_format((float)$this->price, 2, '.', ',');
    } 
    
    public function shipping() {

        return  number_format((float)$this->shipping, 2, '.', ',');
    } 

    public function getBillingCycleUnitAttribute($value) {
        return $value.'(s)';
    }
    
} 
