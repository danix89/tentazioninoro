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
use Tentazioninoro\Jewel;
use Tentazioninoro\SaleAct;
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

Route::get('/saleact/modify/', [function () {
        $userId = Auth::id();
        $customersIds = User::find($userId)->customers()->get(); //->groupBy('customer_id');
        Debugbar::info($customersIds);
        $identityDocuments = array([]);
        foreach ($customersIds as $customerId) {
//            Debugbar::info("customerId - start", $customerId, "customerId - end");
            $customer = Customer::join("identity_documents", "identity_documents.customer_id", "=", "customers.id", "")
                    ->where("customers.id", $customerId->customer_id)
                    ->first(["identity_documents.*", "customers.fiscal_code"]);
            Debugbar::info('$customer - start', $customer, '$customer - end');
            $identityDocuments[] = $customer;
            $customerList[$customerId->customer_id] = $customer->name . " " . $customer->surname;
        }

        setcookie('identityDocuments', json_encode($identityDocuments), time() + (60 * 30), "/");

        $saleAct = SaleAct::orderBy('id', 'desc')->take(1)->first();
        
        $data = array(
            'newSaleActId' => ++$saleAct->id,
            'customerList' => $customerList,
        );

        return View::make('saleact.toBeFilled')->with("data", $data);
    }
]);

Route::get('/saleact/{saleActId}', [function ($saleActId) {
        $saleAct = User::find($saleActId)->salesActs()->get();
        $customer = SaleAct::find($saleActId)->customer()->first();
        Debugbar::info("customer - start", $customer, "customer - end");

        $data = array(
            'saleAct' => $saleAct,
            'customer' => $customer,
        );

        return View::make('saleact.pdf')->with('data', $data);
    }
]);

Route::get('/pdf/', [function () {
        $data = array();
        Tentazioninoro\Http\Controllers\SaleActController::createPDF("prova.pdf", $data);
    }
]);

//
//Route::get('/home', function () {
//    return redirect(route('home'));
//});

Route::get('/riparazioni/', ['as' => 'showList', 'uses' => 'FixingController@showList']);
Route::post('/fixing/delete', ['as' => 'fixing.destroyAll', 'uses' => 'FixingController@destroyFixings']);

Route::get('/nuova-riparazione/', ['as' => 'newfixing', function () {
        if (Auth::check()) {
            $userId = Auth::id();
            $customersIds = User::find($userId)->customers()->get(); //->groupBy('customer_id');
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

            $fixing = new Fixing;
            //        Debugbar::info($user);
            //        Debugbar::info($fixing);

            $data = array(
                'showCustomerList' => true,
                'customerList' => $customerList,
                'fixing' => $fixing,
                'customer' => $customer,
            );
            return View::make('fixing/create')->with('data', $data);
        } else {
            return redirect(route('home'));
        }
    }]
);

Route::get('/riparazione/{fixingId}', ['as' => 'showFixing', function ($fixingId) {
        if (Auth::check()) {
            $userId = Auth::id();
            $customersIds = User::find($userId)->customers()->get(); //->groupBy('customer_id');

            $customer = new Customer;
            $jewel = new Jewel;
            $fixing = Fixing::where('id', $fixingId)->get()->first();
            $jewel = Jewel::where('id', $fixing->jewel_id)->get()->first();
//            $customer = Customer::where('id', $fixing->customer_id)->get()->first();
            $identityDocument = Customer::find($fixing->customer_id)->identityDocument;

            $data = array(
                'showCustomerList' => false,
                'fixing' => $fixing,
//                'customer' => $customer,
                'identityDocument' => $identityDocument,
                'jewel' => $jewel,
            );

            return View::make('fixing/create')->with('data', $data);
        } else {
            return redirect(route('home'));
        }
    }]
);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
