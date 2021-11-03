<?php

namespace App;

use Storage;
use Illuminate\Database\Eloquent\Model;
use App\TdaccountUser;

class Tdaccount extends Model
{
	protected $fillable = ['name', 'term_month', 'interest_rate', 'penalty_rate', 'risk_factor', 'maximum_cap', 'description'];

	public function getUserBalance($user_id)
	{
		$user = $this->hasMany(TdaccountUser::class, 'tdaccount_id')->where('user_id', $user_id)->first();

		if(! is_null($user))
			return number_format($user->balance, 2, ".", ",");
		else
			return 0;
	}
}