<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $referrals = User::where('referrer_id', Auth::user()->id)->paginate(10);
        return view('partners.index', ['referrals' => $referrals]);
    }

}
