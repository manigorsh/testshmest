@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">БОНУСЫ</div>

                <div class="card-body">
                    <h2>Какие БОНУСЫ можно получить?</h2>
                    <h4>1. Бонус <span style="font-weight: bold;color: #b19500;">50</span> рублей каждому новому игроку!</h4>
                    <p>Чтобы получить зарегистрироуйся и напиши с почты, которую указал для регистрации, письмо в нашу техподдержку <input type="text" value="support@fnvst.com" disabled style="text-align: center;background: transparent;border-radius: 10px;"> с требованием СРОЧНО зачислить тебе бонус на игровой счет!<img src="/gold.png" style="float: right;width: 25%;"></p>

                    <h4>2. Партнёрский Бонус <span style="font-weight: bold;color: #b19500;">100</span> рублей за каждого нового приглашенного тобой активного игрока!</h4>
                    <p>Зайди в личный кабинет в раздел <a href="/partners">Партнеры</a></p>
                    <p>Скопируй любую из своих партнерских ссылок и разошли её всем друзьям и знакомым, которых хочешь пригласить.</p>
                    <p>После регистрации такого игрока - мы проверим его профиль, активность и начислим тебе бонус 100 рубликов!</p>
                    <p>Кроме того ты будешь получать бонус от 1 до 2000 рублей с каждой игры, которую сыграет этот игрок - независимо от того выиграет он или проиграет!<img src="/dollar.jpg" style="float: right;width: 25%;"></p>

                    <h4>3. Супер Бонус <span style="font-weight: bold;color: #b19500;">500</span> рублей!</h4>
                    <p>Просто играя на сайте ты можешь внезапно получить бонус 500 рублей!</p>
                    <p>Каждая тысячная игра, сыгранная на сайте - назависимо от того, твоя или чужая, получает бонус 500 рублей! Эти 500 рублей получает игрок, выигравший эту игру дополнительно к выигрышу от самой игры!</p>
                    <p>Выигрыш начисляется автоматически - на сайте существует счетчик сыгранных игр. Каждые сыграные 1000 игр счетчик обнуляется и отсчет начинается заново! Ещё раз - это не твои тысяча игр, а все игры в общем сыгранные на сайте, понимаешь, Карл?</p>

                    <h4>4. Партнёрский Бонус от <span style="font-weight: bold;color: #b19500;">15</span> до <span style="font-weight: bold;color: #b19500;">30</span> рублей!</h4>
                    Скопируй свою партнерскую ссылку из раздела <a href="/partners">Партнеры</a> и размести её на страничке любой из своих соцсетей. А затем пришли ссылочку на эту запись. Мы проверим и накинем тебе ещё 15 рубликов на счет! Но только учти, Карл - страничка в соцсети должна быть реальной, а не для выполнения заданий на сайтах для заработка и прочей ерунды! Мы проверим! Если еще добавишь красивый и содержательный отзыв к этой записи, то получишь ещё от 5 до 15 рублей дополнительно!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
