<?php

namespace App\Http\Controllers;

use App\Models\UserBalance;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Cookie;

class InviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if(!Auth::check()){
			return redirect('/login');
		}
        $referrals = User::where('referral_id', Auth::user()->id)->get();
        $active = User::where('referral_id', Auth::user()->id)->where('approved', 'yes')->count();
        $inactive = User::where('referral_id', Auth::user()->id)->where('approved', 'no')->count();

        $earn = UserBalance::where('user_id', Auth::user()->id)->first()->histories()->where('type', 'referral')->sum('amount');

        return view('user.invite')->with(compact('referrals', 'active', 'inactive', 'earn'));
    }
	
	public function getId($id)
    {	
		return redirect('/influencers/apply')->withCookie(cookie()->forever('refer', $id));
	}

	public function showCo(){
		 $value = Cookie::get('refer');
		 echo $value;
	}
}
