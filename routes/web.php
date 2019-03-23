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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Chart')->group(function () {

    Route::prefix('chart')->group(function () {
        Route::get('evolucaotopgames', 'EvolucaoTopGames@find');
    });

});

Route::get('ml/channel/', 'HomeController@mlChannel')->name('previsao');
Route::post('ml/channel/api', 'HomeController@mlChannelFindApi')->name('resultado-previsao-api');
Route::get('ml/channel/{id}', 'HomeController@mlChannelFind')->name('resultado-previsao');