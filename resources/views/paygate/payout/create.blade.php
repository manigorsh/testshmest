@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">{{ __('paygate.NEW_PAYOUT') }}</div>

                <div class="card-body">
                    <p>{{ __('paygate.YOUR_BALANCE') }} : {{ Auth::user()->balance }} {{ __('auth.RUB') }}</p>
                    <form method="POST" action="{{ route('paygate.payout.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="amount" class="col-sm-4 col-form-label text-md-right">{{ __('paygate.AMOUNT') }}</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" required autofocus>

                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-sm-4 col-form-label text-md-right">{{ __('paygate.TYPE') }}</label>
                            <div class="col-md-6">
                                <select name="type">
                                    <option value="YandexMoney">YandexMoney</option>
                                </select>

                                @if ($errors->has('type'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wallet_number" class="col-sm-4 col-form-label text-md-right">{{ __('paygate.WALLET_NUMBER') }}</label>

                            <div class="col-md-6">
                                <input id="wallet_number" type="text" class="form-control{{ $errors->has('wallet_number') ? ' is-invalid' : '' }}" name="wallet_number" value="{{ old('wallet_number') }}" required autofocus>

                                @if ($errors->has('wallet_number'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('wallet_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                           
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('paygate.CREATE_PAYOUT') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
