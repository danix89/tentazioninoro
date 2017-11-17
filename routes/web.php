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

Route::get('/', ['as' => 'home', function () {
        return redirect(route('showList', 1, 1));
    }
]);

Route::get('/home', function () {
    return redirect(route('home'));
});

Route::get('/riparazioni/user/{userId}/cliente/{customerId?}', ['as' => 'showList', 'uses' => 'FixingController@showList']);

Route::get('/nuova-riparazione/user/{userId}/cliente/{customerId?}', ['as' => 'newfixing', function ($userId, $customerId=NULL) { //nomino la rotta 'home'
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
