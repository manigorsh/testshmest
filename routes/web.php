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
Route::resource('knbgames','KnbGameController');

Route::get('/partners', 'PartnerController@index')->name('partners.index');

Route::get('/paygate/freekassa', 'PayGate\FreeKassaController@create')->name('paygate.freekassa.create');
Route::post('/paygate/freekassa/store', 'PayGate\FreeKassaController@store')->name('paygate.freekassa.store');
Route::post('/paygate/freekassa/result', 'PayGate\FreeKassaController@result')->name('paygate.freekassa.result');
Route::get('/paygate/freekassa/success', 'PayGate\FreeKassaController@success')->name('paygate.freekassa.success');
Route::get('/paygate/freekassa/fail', 'PayGate\FreeKassaController@fail')->name('paygate.freekassa.fail');