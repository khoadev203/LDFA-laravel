<?php

namespace App\Models;
use App\User;
use App\Models\Button;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
	protected $fillable = ['user_id', 'merchant_id', 'button_id', 'sale_id', 'gross', 'fee', 'net', 'metal_price', 'json_data'];

	public function User() {
		return $this->belongsTo(User::class);
	}

	public function Merchant() {
		return $this->belongsTo(User::class, 'merchant_id');
	}

	public function Button() {
		return $this->belongsTo(Button::class);
	}

	public function getGrossAttribute($value) {
		return number_format((float)$value, 2, '.', '');
	}
}