<?php

namespace App\Http\Controllers\PayGate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Payment;
use Illuminate\Support\Facades\Auth;
use App\User;

class FreeKassaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['result', 'success', 'fail']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paygate.freekassa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment = new Payment();

        $merchant_id = env('FREEKASSA_MERCHANT_ID', '');
        $secret_word = env('FREEKASSA_SECRET_1', '');
        
        $payment->amount = $request->get('amount');
        $payment->user_id = Auth::user()->id;
        $payment->save();

        $sign = md5($merchant_id.':'.$payment->amount.':'.$secret_word.':'.$payment->id);

        $payment->save();

        return view('paygate.freekassa.store', ['payment' => $payment, 'sign' => $sign]);
    }

    public function result(Request $request)
    {
        $ip = '';
        
        if(isset($_SERVER['HTTP_X_REAL_IP'])) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if (!in_array($ip, array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '88.198.88.98'))) {
            die("hacking attempt!");
        }

        $merchant_id = env('FREEKASSA_MERCHANT_ID', '');
        $merchant_secret = env('FREEKASSA_SECRET_2', '');

        $sign = md5($merchant_id.':'.$request->get('AMOUNT').':'.$merchant_secret.':'.$request->get('MERCHANT_ORDER_ID'));

        if ($sign != $request->get('SIGN')) {
            die('wrong sign');
        }

        $payment = Payment::find($request->get('MERCHANT_ORDER_ID'));
 
	if ($payment->amount != $request->get('AMOUNT')) {
            die('wrong amount');
        }    

        if ($payment->completed) {
            die('payment already complete');
        }

        $payment->description = 'FreeKassa'.':'.$request->get('intid').':'.$request->get('CUR_ID').':'.$request->get('P_EMAIL').':'.$request->get('P_PHONE');
        $payment->completed = true;

        $payment->save();

        User::find($payment->user_id)->addToBalance($payment->amount, 'deposit', $payment->id);

        die('YES');
    }

    public function success(Request $request)
    {
        return view('paygate.freekassa.success');
    }

    public function fail(Request $request)
    {
        return view('paygate.freekassa.fail');

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
