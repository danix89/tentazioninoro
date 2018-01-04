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

app('debugbar')->disable();

Auth::routes();
Route::get('/register', 'HomeController@index')->name('register');

Route::get('/', [function () {
	return redirect(route('home'));
    }
]);
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/access-not-allowed', ['as' => 'accessNotAllowed', 'uses' => 'HomeController@showAccessNotAllowedPage']);

Route::get('/atti-vendita/', ['as' => 'showSaleActList', 'uses' => 'SaleActController@index']);
Route::get('/atti-vendita/new/', ['as' => 'newSaleAct', 'uses' => 'SaleActController@create']);
Route::get('/atti-vendita/show/{saleActId}/{toPrint?}', ['as' => 'showSaleAct', 'uses' => 'SaleActController@show']);
Route::get('/atti-vendita/photos/{saleActId}', ['as' => 'showSaleActPhotos', 'uses' => 'SaleActController@showPhotos']);
Route::post('/atti-vendita/delete', ['as' => 'sale-act.destroyAll', 'uses' => 'SaleActController@destroySalesActs']);

//Route::get('/pdf/', [function () {
//	$data = array();
//	Tentazioninoro\Http\Controllers\SaleActController::createPDF("prova.pdf", $data);
//    }
//]);

Route::get('/riparazioni/list/{state?}', ['as' => 'showList', 'uses' => 'FixingController@index']);
Route::get('/riparazioni/new', ['as' => 'newFixing', 'uses' => 'FixingController@create']);
Route::post('/riparazioni/updateState/{fixingId}', ['as' => 'updateStateFixing', 'uses' => 'FixingController@updateState']);
Route::get('/riparazioni/show/{fixingId}', ['as' => 'showFixing', 'uses' => 'FixingController@show']);
Route::get('/riparazioni/print/{fixingId}/', ['as' => 'printFixing', 'uses' => 'FixingController@printTicket']);
Route::post('/riparazioni/delete', ['as' => 'fixing.destroyAll', 'uses' => 'FixingController@destroyFixings']);

Route::get('/backup/directory/{directoryName}', ['as' => 'photoBackup', 'uses' => 'PhotosBackupController@exec']);
Route::get('/delete/directory/{directoryName}', ['as' => 'photoDelete', 'uses' => 'PhotosBackupController@delete']);