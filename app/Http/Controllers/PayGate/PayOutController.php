<?php

namespace App\Http\Controllers\PayGate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payout;
use Illuminate\Support\Facades\Auth;

class PayOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
		$payouts = Payout::where('user_id', Auth::user()->id)->paginate(10);
        return view('paygate.payout.index', ['payouts' => $payouts]);
    }

    public function create()
    {
        return view('paygate.payout.create');
    }

    public function store(Request $request)
    {
        if(Auth::user()->balance < $request->get('amount')) {
            return redirect('paygate/payout')->with('fail', __('paygate.NOT_ENOUGH_MONEY_TO_CREATE_THIS_PAYOUT'));
        }
        if($request->get('amount') <= 500) {
            return redirect('paygate/payout')->with('fail', __('paygate.MINIMAL_AMOUNT_WITHDRAW'));
        }
        $payout = new Payout();
        $payout->amount = $request->get('amount');
        $payout->type = $request->get('type');
        $payout->wallet_number = $request->get('wallet_number');
        $payout->user_id = Auth::user()->id;
        $payout->save();
		
		Auth::user()->addToBalance(-$payout->amount, 'withdraw', $payout->id);

        return redirect('paygate/payout')->with('success', __('paygate.NEW_PAYOUT_REQUEST_CREATED'));
    }
}
