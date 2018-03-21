<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'KnbGameController@index');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/knbgames/statistics', 'KnbGameController@statistics')->name('knbgames.statistics');
Route::post('/knbgames/play', 'KnbGameController@play')->name('knbgames.play');
Route::post('/knbgames/cancel', 'KnbGameController@cancel')->name('knbgames.cancel');
Route::resource('knbgames','KnbGameController');

Route::get('/partners', 'PartnerController@index')->name('partners.index');

Route::get('/paygate/payout', 'PayGate\PayOutController@index')->name('paygate.payout.index');
Route::get('/paygate/payout/create', 'PayGate\PayOutController@create')->name('paygate.payout.create');
Route::post('/paygate/payout/store', 'PayGate\PayOutController@store')->name('paygate.payout.store');

Route::get('/paygate/freekassa', 'PayGate\FreeKassaController@create')->name('paygate.freekassa.create');
Route::post('/paygate/freekassa/store', 'PayGate\FreeKassaController@store')->name('paygate.freekassa.store');
Route::get('/paygate/freekassa/result', 'PayGate\FreeKassaController@result')->name('paygate.freekassa.result');
Route::get('/paygate/freekassa/success', 'PayGate\FreeKassaController@success')->name('paygate.freekassa.success');
Route::get('/paygate/freekassa/fail', 'PayGate\FreeKassaController@fail')->name('paygate.freekassa.fail');

Route::view('/project-rules', 'project-rules');
Route::view('/game-rules', 'game-rules');
Route::view('/public-offer', 'public-offer');
Route::view('/bonus', 'bonus');

Route::post('/chat/store', 'ChatMessageController@store')->name('chat.store');
Route::get('/chat', 'ChatMessageController@index')->name('chat.index');
