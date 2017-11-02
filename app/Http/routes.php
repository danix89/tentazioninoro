<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index'); 

//Route::get('home', 'LoginController@index');

//Route::get('home', 'HomeController@index');

//Route::controllers([
//	'auth' => 'Auth\AuthController',
//	'password' => 'Auth\PasswordController',
//]);

Route::resource('atto-di-vendita', 'AttoDiVenditaController');
Route::resource('riparazioni', 'RiparazioniController');

Route::get('/', [ 'as' => 'home', 'uses' => 'HomeController@getHome']);
Route::get('book/{id}', [ 'as' => 'bookDetail', 'uses' => 'HomeController@getBookDetail']);
Route::get('/atto-di-vendita/{id}', [ 'as' => 'attoDiVendita', 'uses' => 'AttoDiVenditaController@show']);

