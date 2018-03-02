@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Pay Now {{ $payment->amount }}</div>

                <div class="card-body">
                    <form method="POST" action="http://www.free-kassa.ru/merchant/cash.php">
                         <div class="form-group row">
                            <input type="hidden" name="m" value="{{ env('FREEKASSA_MERCHANT_ID', '') }}" />
                            <input type="hidden" name="oa" value="{{ $payment->amount }}" />
                            <input type="hidden" name="o" value="{{ $payment->id }}" />
                            <input type="hidden" name="s" value="{{ $sign }}" />
                            <input type="hidden" name="i" value="45">
                            <input type="hidden" name="lang" value="ru">
                            <input type="hidden" name="us_login" value="{{ Auth::user()->name }}">
                            <input type="hidden" name="em" value="{{ Auth::user()->email }}">
                            <input class="btn btn-primary" type="submit" name="pay" value="Оплатить">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
