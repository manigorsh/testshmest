@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">{{ __('paygate.PAYOUTS') }}</div>
                <div class="card-body">
                    @if (Session::has('success'))
                      <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('fail'))
                      <div class="alert alert-warning">{{ Session::get('fail') }}</div>
                    @endif
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">{{ __('paygate.CREATED_AT')}}</th>
                          <th scope="col">{{ __('paygate.PAID_AT')}}</th>
                          <th scope="col">{{ __('paygate.AMOUNT')}}</th>
                          <th scope="col">{{ __('paygate.TYPE')}}</th>
                          <th scope="col">{{ __('paygate.WALLET_NUMBER')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($payouts as $payout)
                          <tr>
                              <th scope="row">{{ $payout->id }}</th>
                              <td>{{ $payout->created_at }}</td>
                              <td>{{ $payout->paid_at }}</td>
                              <td>{{ $payout->amount }}</td>
                              <td>{{ $payout->type }}</td>
                              <td>{{ $payout->wallet_number }}</td>
                            </tr>
                          @endforeach
                      </tbody>
                    </table>
                    {{ $payouts->links() }}
                    <a class="btn btn-primary" href="{{ route('paygate.payout.create') }}">{{ __('paygate.CREATE_PAYOUT') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
