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

use Tentazioninoro\User;
use Tentazioninoro\Customer;

Route::resource('user', 'UserController');
Route::resource('customer', 'CustomerController');
Route::resource('identity-document', 'IdentityDocumentController');
Route::resource('jewel', 'JewelController');
Route::resource('fixing', 'FixingController');
Route::resource('sale-act', 'SaleActController');

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', ['as' => 'home', function () { //nomino la rotta 'home'
        $users = User::get();
        $customer = Customer::get();
        Debugbar::info($users);
        Debugbar::info($customer);
        return view('welcome');
    }]);

Route::get('/home', function () {
    return redirect(route('home'));
});

Route::get('/fixing/{userId?}', ['as' => 'fixing', function ($userId) { //nomino la rotta 'home'
    $user = User::where('user_id', $userId)->get();
    $fixingList = Fixing::where('user_id', $user->id)->orderBy('customer_id', 'asc')->get();
    $customer = Customer::get();
    Debugbar::info($user);
    Debugbar::info($customer);
    
    $data = array(
        'user' => $user,
        'fixingList' => $fixingList,
    );
    return View::make('fixing/create')->with('data', $data);
}]);
