@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">БОНУСЫ</div>

                <div class="card-body">
                    <h2>Какие БОНУСЫ можно получить?</h2>
                    <h3>1. Бонус <span style="font-weight: bold;color: #b19500;">50</span> рублей каждому новому игроку!</h3>
                    <p>Что нужно чтобы получить?</p>
                    <p>Зарегистрироваться и написать с почты, которую указали для регистрации, письмо в нашу техподдержку <input type="text" value="support@fnvst.com" disabled style="text-align: center;background: transparent;border-radius: 10px;"> с просьбой зачислить вам бонус на игровой счет.<img src="/gold.png" style="float: right;width: 25%;"></p>

                    <h3>2. Бонус <span style="font-weight: bold;color: #b19500;">100</span> рублей за каждого нового приглашенного вами активного игрока!</h3>
                    <p>Что нужно чтобы получить?</p>
                    <p>Зайти в личный кабинет в раздел <a href="/partners">Партнеры</a></p>
                    <p>Скопировать любую из ваших партнерских ссылок и разослать её всем друзьям и знакомым, которых вы хотите пригласить.</p>
                    <p>После регистрации такого игрока - мы проверим его профиль, активность и начислим вам бонус!</p>
                    <p>Кроме того вы будете получать бонус от 1 до 2000 рублей с каждой игры, которую сыграет этот игрок - независимо от того выиграет он или проиграет!<img src="/dollar.jpg" style="float: right;width: 25%;"></p>

                    <h3>2. Супер Бонус <span style="font-weight: bold;color: #b19500;">500</span> рублей!</h3>
                    <p>Что нужно чтобы получить?</p>
                    <p>Вы просто играете на сайте и внезапно можете получить бонус 500 рублей!</p>
                    <p>Каждая тысячная игра, сыгранная на сайте - назависимо от того ваша или чужая получает бонус 500 рублей. Эти 500 рублей получает игрок, выигравший эту игру дополнительно к выигрышу от самой игры!</p>
                    <p>Выигрыш начисляется автоматически - на сайте существует счетчик сыгранных игр. Каждые сыграные 1000 игр счетчик обнуляется и отсчет начинается заново!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection