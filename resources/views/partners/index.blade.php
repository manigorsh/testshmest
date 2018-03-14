@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">{{ __('partners.PARTNER_PERSONAL_PAGE') }}</div>
                <div class="card-body">
                    <p>Ваши партнерские ссылки</p>
                    <p>Главная страница</p>
                    <p><input type="text" value="{{ config('app.url', 'http://partners.fnvst.com/') }}/?ref={{Auth::user()->id}}" disabled style="width:100%;text-align: center;background: transparent;border-radius: 10px;"></p>
                    <p>Страница с Бонусами</p>
                    <p><input type="text" value="{{ config('app.url', 'http://partners.fnvst.com/') }}/bonus?ref={{Auth::user()->id}}" disabled style="width:100%;text-align: center;background: transparent;border-radius: 10px;"></p>
                    <p>Скопируйте любую из этих ссылок и отправьте тому, кого хотите пригласить или просто разместите у себя на странице.</p>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">{{ __('partners.REFERRAL_NAME') }}</th>
                          <th scope="col"></th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($referrals as $referral)
                          <tr>
                              <th scope="row">{{ $referral->id }}</th>
                              <td>{{ $referral->name }}</td>
                              <td></td>
                              <td></td>
                            </tr>
                          @endforeach
                      </tbody>
                    </table>
                    {{ $referrals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
