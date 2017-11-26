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
//Route::get('/', ['as' => 'home', function () {
//        return redirect(route('showList', 1, 1));
//    }
//]);
//
//Route::get('/home', function () {
//    return redirect(route('home'));
//});

Route::get('/riparazioni/cliente/{customerId?}', ['as' => 'showList', 'uses' => 'FixingController@showList']);

Route::get('/nuova-riparazione/', ['as' => 'newfixing', function () {
	$user = Auth::user();
	$userId = Auth::id();
	$user = User::where('id', $userId)->get()[0];
	$fixingList = User::find(1)->fixings()->get()->groupBy('customer_id');
	$customerList = array();
	foreach ($fixingList as $fixing) {
	    $identityDocument = Customer::find($fixing[0]->customer_id)->identityDocument;
	    $customerList[$fixing[0]->customer_id] = $identityDocument->name . " " . $identityDocument->surname;
//            $customerList[] = $identityDocument;
	}
//        $customerList = [1,2,43];
	Debugbar::info("fixingList - start", $fixingList, "fixingList - end");
	Debugbar::info($customerList);
	if (isset($customerId)) {
	    $customer = Customer::where('id', $customerId)->get()[0];
	} else {
	    $customer = new Customer;
	}

	$fixing = new Fixing;
//        Debugbar::info($user);
//        Debugbar::info($fixing);

	$data = array(
	    'customerList' => $customerList,
	    'customer' => $customer,
	    'fixing' => $fixing,
	    'user' => $user,
	);
	return View::make('fixing/create')->with('data', $data);
    }]
);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
