<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\APIBaseController as APIBaseController;

use App\User;

class UserAPIController extends APIBaseController
{
	public function getCount()
	{
		$count = User::count();
		return $this->sendResponse($count, "");
	}
}