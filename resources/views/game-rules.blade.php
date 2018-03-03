@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">{{ __('common.GAME_RULES') }}</div>

                <div class="card-body">
                    <b>Камень, ножницы, бумага</b><br>
Вам доступны три предмета: камень, ножницы и бумага.<br>
Победитель определяется по следующим правилам:<br>
 - Камень побеждает ножницы («камень затупляет или ломает ножницы»)<br>
 - Ножницы побеждают бумагу («ножницы разрезают бумагу»)<br>
 - Бумага побеждает камень («бумага обворачивает камень»)<br>
Если игроки показали одинаковый знак, то засчитывается ничья и ставки возвращаются игрокам.<br><br>

Победитель определяется по правилам выше и забирает себе весь банк игры за вычетом комиссии системы, которая составляет 3%<br><br>

Например, создана игра со ставкой в 10 очков.<br>
Банк игры = 100 + 100 = 200 очков (100%)<br>
Размер выигрыша = 194 очка (97%), где 3% комиссия, которая составляет 6 очков.<br><br><br>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
