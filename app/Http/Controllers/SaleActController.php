<?php

namespace Tentazioninoro\Http\Controllers;

use Auth;
use Debugbar;
use \Input as Input;
use PDF;
use View;
use Illuminate\Http\Request;
use Tentazioninoro\Customer;
use Tentazioninoro\SaleAct;
use Tentazioninoro\User;

class SaleActController extends Controller {

    public function __construct() {
	$this->middleware('auth');
	$this->middleware('has-permissions:' . \Config::get('constants.permission.SALES_ACTS') . ',');
    }

    private function isAllowedAccess() {
//	if (Auth::check() && Auth::user()->permissions === \Config::get('constants.permission.FIXINGS')) {
//	    return true;
//	} else {
////	    return redirect('/access-not-allowed');
//	    return redirect()->route('accessNotAllowed');
//	    return false;
//	}
	return true;
    }

    public static function createPDF($pdfFilename, $data) {
	$pdf = PDF::loadView('welcome', $data);
	return $pdf->setPaper('a8')->save($pdfFilename);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	$user = Auth::user();
	$userId = $user->id;

	$saleActList = SaleAct::where('user_id', $userId)->get();
	Debugbar::info($saleActList);

	$customersIds = User::find($userId)->customers()->get();
	$identityDocumentList = array();
	foreach ($customersIds as $customerId) {
	    //            Debugbar::info("customerId - start", $customerId, "customerId - end");
	    $customer = Customer::join("identity_documents", "identity_documents.customer_id", "=", "customers.id", "")
		    ->where("customers.id", $customerId->customer_id)
		    ->first(["identity_documents.*", "customers.fiscal_code"]);
//		Debugbar::info('$customer - start', $customer, '$customer - end');
	    $identityDocumentList[$customer->customer_id] = $customer;
	}
	Debugbar::info('$identityDocumentList - start', $identityDocumentList, '$identityDocumentList - end');

	return View::make('saleact/index')->with([
		    'saleActList' => $saleActList,
		    'identityDocumentList' => $identityDocumentList,
	]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
	$userId = Auth::id();
	$customersIds = User::find($userId)->customers()->get(); //->groupBy('customer_id');
//	    Debugbar::info($customersIds);
	$identityDocuments = array([]);
	$customerList = array();
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
	    'saleAct' => $saleAct,
	);

	return View::make('saleact.toBeFilled')->with("data", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
	$data = $request->all();
//	    var_dump($data);
	\Debugbar::info($data);
	$customerId = $request->customer;
	if ($customerId === 0) {
	    $customerData = array(
		'fiscal_code' => $request->fiscal_code,
	    );
	    $customer = Customer::create($customerData);

	    $identityDocumentData = array(
		'customer_id' => $customer->id,
		'type' => $request->type,
		'release_date' => $request->release_date,
		'name' => $request->name,
		'surname' => $request->surname,
		'birth_residence' => $request->birth_residence,
		'birth_province' => $request->birth_province,
		'birth_date' => $request->birth_date,
		'residence' => $request->residence,
		'street' => $request->street,
		'street_number' => $request->street_number,
	    );
	    IdentityDocument::create($identityDocumentData);

	    UserCustomer::create(array(
		'user_id' => Auth::id(),
		'customer_id' => $customer->id,
	    ));
	}

	if (Input::hasFile('path_photo')) {
//		$file = Input::file('path_photo');
	    $path = $request->file('path_photo')->store('sales_acts');
//		\Storage::disk('local')->move($path, 'uploads/prova.png');
	    move_uploaded_file($path, 'D:\uploads\file1.jpg');
	} else {
	    $path = null;
	}
	$saleActData = array(
	    'user_id' => Auth::id(),
	    'customer_id' => $customerId,
	    'objects' => $request->objects,
	    'weight' => $request->weight,
	    'price' => $request->price,
	    'au_quotation' => $request->gold,
	    'arg_quotation' => $request->silver,
	    'agreed_price' => $request->agreedPrice,
	    'terms_of_payment' => $request->termsOfPayment,
	    'path_photo' => $path,
	);
	$toPrint = ($request->toPrint === 'true');
//	    var_dump($toPrint);
	$saleAct = SaleAct::create($saleActData);
	return redirect()->route('showSaleAct', ['saleActId' => $saleAct->id, 'toPrint' => $request->toPrint]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($saleActId, $toPrint = false) {
	$saleAct = SaleAct::find($saleActId);
	$customer = null;
	$identityDocument = null;
	if ($saleAct !== null) {
//		$saleAct = $saleAct->first();
//		Debugbar::info('$saleAct - start', $saleAct, '$saleAct - end');
	    $customer = $saleAct->customer()->first();
//		Debugbar::info("customer - start", $customer, "customer - end");
	    $identityDocument = $customer->identityDocument()->first();
//		Debugbar::info('$identityDocument - start', $identityDocument, '$identityDocument - end');
	} else {
	    return redirect(route('newSaleAct'));
	}

	$data = array(
	    'saleAct' => $saleAct,
	    'customer' => $customer,
	    'identityDocument' => $identityDocument,
	    'toPrint' => $toPrint,
	);

	return View::make('saleact.pdf')->with('data', $data);
    }

    public function showPhotos($saleActId) {
	$photo_paths = SaleAct::where($saleActId)->get("path_photo");
	return View::make('saleact.photos')->with('photo_paths', $photo_paths);
    }

    public function showList() {
	
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
	
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
	SaleAct::destroy($id);
	return redirect(route('sale-act.index'));
    }

    public function destroySalesActs(Request $request) {
	$ids = $request->input('ids');
	foreach ($ids as $id) {
	    print_r($id);
	    SaleAct::destroy($id);
	}
	return redirect(route('sale-act.index'));
    }

}
