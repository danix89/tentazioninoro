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
use Tentazioninoro\IdentityDocument;
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

Route::get('/', [function () {
        return redirect(route('home'));
    }
]);
//
//Route::get('/home', function () {
//    return redirect(route('home'));
//});

Route::get('/riparazioni/cliente/{customerId?}', ['as' => 'showList', 'uses' => 'FixingController@showList']);

Route::get('/nuova-riparazione/', ['as' => 'newfixing', function () {
        if(Auth::check()) {
            $user = Auth::user();
            $userId = Auth::id();
            $user = User::where('id', $userId)->get()[0];
            $customersIds = User::find(1)->customers()->get(); //->groupBy('customer_id');
            Debugbar::info($customersIds);
            $customerList = array();
            foreach ($customersIds as $customerId) {
                Debugbar::info("customerId - start", $customerId, "customerId - end");
                $identityDocument = Customer::find($customerId->customer_id)->identityDocument;
                $customerList[$customerId->customer_id] = $identityDocument->name . " " . $identityDocument->surname;
    //            $customerList[] = $identityDocument;
            }
    //        $customerList = [1,2,43];
//            Debugbar::info("fixingList - start", $fixingList, "fixingList - end");
//            Debugbar::info($customerList);
            if (isset($customerId)) {
                $customer = Customer::where('id', $customerId)->get();
            } else {
                $customer = new Customer;
            }

            $customerId = new Fixing;
    //        Debugbar::info($user);
    //        Debugbar::info($fixing);

            $data = array(
                'customerList' => $customerList,
                'customer' => $customer,
                'fixing' => $customerId,
                'user' => $user,
            );
            return View::make('fixing/create')->with('data', $data);
        } else {
            return redirect(route('home'));
        }
    }]
);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
