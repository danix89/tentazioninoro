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

use Tentazioninoro\Customer;
use Tentazioninoro\Fixing;
use Tentazioninoro\User;

Route::resource('user', 'UserController');
Route::resource('customer', 'CustomerController');
Route::resource('identity-document', 'IdentityDocumentController');
Route::resource('jewel', 'JewelController');
Route::resource('fixing', 'FixingController');
Route::resource('sale-act', 'SaleActController');

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/riparazioni/{userId}', ['as' => 'showList', 'uses' => 'FixingController@showList'])->name('showList');

Route::get('/', ['as' => 'home', function () {
//        $userList = User::orderBy('name', 'asc')->get();
//        Debugbar::info($userList);
        return redirect(route('showList', 1));
//        return View::make('fixing/index')->with('userId', 1);
    }
]);


Route::get('/home', function () {
    return redirect(route('home'));
});

//Route::get('/prova', ['as' => 'prova', function () {
//        $userList = User::orderBy('name', 'asc')->get();
//        Debugbar::info($userList);
//        return View::make('fixing/create')->with('userList', $userList);
//    }]
//);

Route::get('/fixing/create/{userId}/{customerId?}', ['as' => 'newfixing', function ($userId, $customerId) { //nomino la rotta 'home'
        $user = User::where('id', $userId)->get()[0];
        if (isset($customerId)) {
            $customer = Customer::where('id', $customerId)->get()[0];
        } else {
            $customer = new Customer;
        }
//        $fixingList = Fixing::where('user_id', $user->id)->orderBy('customer_id', 'asc')->get();

        $fixing = new Fixing;
//        Debugbar::info($user);
//        Debugbar::info($fixing);

        $data = array(
            'customer' => $customer,
            'fixing' => $fixing,
            'user' => $user,
        );
        return View::make('fixing/create')->with('data', $data);
    }]
);
