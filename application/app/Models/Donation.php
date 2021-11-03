<?php

namespace App\Models;
use App\User;
use App\Models\Button;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
	protected $fillable = ['user_id', 'button_id', 'metal_price'];
	
    public function getCreatedAtAttribute($value)
    {
        $time = strtotime($value);
        $time -= 14400;//gmt-4

        return date('d M Y', $time);
    }

	public function User() {
		return $this->belongsTo(User::class);
	}

	public function Button() {
		return $this->belongsTo(Button::class);
	}
}