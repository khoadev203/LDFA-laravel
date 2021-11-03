<?php

namespace App\Http\Controllers;
use Auth;
use Storage;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
	public function index()
	{
		return view('affiliate.index');
	}

	public function showDownlines()
	{
		return view('affiliate.downlines');
	}

	public function showBanners()
	{
		return view('affiliate.banners');
	}

	public function getDownlines()
	{
		$result = [];
		$me = Auth::user();
		array_push($result, (object)[
			'head'=> $me->name,
			'id'=> $me->id,
			'contents'=> '<b>Email</b>:<br>'.$me->email.'<br><b>Joined at</b>:<br>'.$me->created_at,
			'children'=> []
		]);

		foreach (Auth::user()->referrals()->get() as $referral1) {
			$user1 = (object)[
				'head'=> $referral1->name,
				'id'=> $referral1->id,
				'contents'=> '<b>Email</b>:<br>'.$referral1->email.'<br><b>Joined at</b>:<br>'.$referral1->created_at,
				'children'=> []
			];
			foreach ($referral1->referrals()->get() as $referral2) {
				$user2 = (object)[
					'head'=> $referral2->name,
					'id'=> $referral2->id,
					'contents'=> '<b>Email</b>:<br>'.$referral2->email.'<br><b>Joined at</b>:<br>'.$referral2->created_at,
					'children'=> []
				];
				foreach ($referral2->referrals()->get() as $referral3) {
					$user3 = (object)[
						'head'=> $referral3->name,
						'id'=> $referral3->id,
						'contents'=> '<b>Email</b>:<br>'.$referral3->email.'<br><b>Joined at</b>:<br>'.$referral3->created_at,
						'children'=> []
					];
					array_push($user2->children, $user3);
				}
				array_push($user1->children, $user2);
			}
			array_push($result[0]->children, $user1);
		}
		return response()->json($result);
	}
}
