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

Route::resource('user', 'UserController');
Route::resource('customer', 'CustomerController');
Route::resource('identity-document', 'IdentityDocumentController');
Route::resource('jewel', 'JewelController');
Route::resource('fixing', 'FixingController');
Route::resource('sale-act', 'SaleActController');

//Route::get('/', function () {
//    return view('welcome');
//});

use Tentazioninoro\User;
use Tentazioninoro\Customer;
Route::get('/', function () {
    $users = User::get();
    $customer = Customer::get();
    Debugbar::info($users);
    Debugbar::info($customer);
    return view('welcome');
});
