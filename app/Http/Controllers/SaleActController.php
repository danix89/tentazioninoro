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
use Tentazioninoro\UserCustomer;

class SaleActController extends Controller {

    public function __construct() {
	$this->middleware('auth');
	$this->middleware('has-permissions:' . \Config::get('constants.permission.SALES_ACTS') . ',');
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

	$customersIds = $user->customers()->get();
	$identityDocumentList = array();
	foreach ($saleActList as $saleAct) {
	    //            Debugbar::info("customerId - start", $customerId, "customerId - end");
	    $customer = Customer::join("identity_documents", "identity_documents.customer_id", "=", "customers.id", "")
		    ->where("customers.id", $saleAct->customer_id)
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
	$users_customers = User::find($userId)->customers()->get(); //->groupBy('customer_id');
//	Debugbar::info($customersIds);
	$customerList = array();
	$identityDocuments = array([]);
	foreach ($users_customers as $user_customer) {
//	    Debugbar::info('$user_customer - start', $user_customer, '$user_customer - end');
	    $customer = Customer::join("identity_documents", "identity_documents.customer_id", "=", "customers.id", "")
		    ->where("customers.id", $user_customer->customer_id)
		    ->first(["identity_documents.*", "customers.fiscal_code"]);
//	    Debugbar::info('$customer - start', $customer, '$customer - end');
	    $identityDocuments[] = $customer;
	    if (!empty($customer->aka)) {
		$aka = " (" . $customer->aka . ")";
	    } else {
		$aka = "";
	    }
	    $date = explode("-", $customer->birth_date);
	    $year = $date[0];
	    $month = $date[1];
	    $day = $date[2];
	    $birthDate = $day . "/" . $month . "/" . $year;
	    $customerList[$user_customer->customer_id] = $customer->name . " " . $customer->surname . $aka . " - " . $birthDate;
	    $identityDocuments[] = $customer;
	}
//	setcookie('identityDocuments', json_encode($identityDocuments), time() + (60 * 30), "/");

	$saleAct = SaleAct::orderBy('id', 'desc')->take(1)->first();
	if (!isset($saleAct)) {
	    $saleActId = 1;
	} else {
	    $saleActId = ++$saleAct->id;
	}
	Debugbar::info($saleActId);

	$data = array(
	    'newSaleActId' => $saleActId,
	    'customerList' => $customerList,
	    'identityDocuments' => $identityDocuments,
	    'saleAct' => $saleAct,
	);
	Debugbar::info('$data - start', $data, '$data - end');

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
	$customerId = $request->customerSelect;
	if ($customerId == 0) {
	    $customerData = array(
		'fiscal_code' => $request->fiscalCode,
	    );
	    $customer = Customer::create($customerData);
	    $customerId = $customer->id;

	    $identityDocumentData = array(
		'customer_id' => $customerId,
		'type' => $request->type,
		'release_date' => $request->releaseDate,
		'name' => $request->name,
		'surname' => $request->surname,
		'birth_residence' => $request->birthResidence,
		'birth_province' => $request->birthProvince,
		'birth_date' => $request->birthDate,
		'residence' => $request->residence,
		'street' => $request->street,
		'street_number' => $request->streetNumber,
	    );
	    \Tentazioninoro\IdentityDocument::create($identityDocumentData);

	    UserCustomer::create(array(
		'user_id' => Auth::id(),
		'customer_id' => $customer->id,
	    ));
	}

	if (Input::hasFile('path_photo')) {
//		$file = Input::file('path_photo');
	    $path = "";
	    $i = 1;
	    $salesActs = SaleAct::orderBy('id', 'desc')->get(["id"]);
	    if (isset($salesActs)) {
		$saleAct = $salesActs->take(1)->first();
		if (!isset($saleAct)) {
		    $saleActId = 1;
		} else {
		    $saleActId = ++$saleAct->id;
		}
		Debugbar::info($saleActId);
	    } else {
		$saleActId = 1;
	    }
	    foreach ($request->path_photo as $photo) {
		$ext = $photo->extension();
		$path .= $photo->storeAs(\Config::get('constants.folders.SALES_ACTS'), $saleActId . "-" . $request->name . "_" . $request->surname . "-" . date("d.m.Y") . "_n." . $i++ . "." . $ext) . "~";
	    }
	    $path = substr($path, 0, strlen($path) - 1);
	    var_dump($path);
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

//	if (!empty($path)) {
//	    file_put_contents('F:\uploads\file1.jpg', Storage::get($path));
//	}

	$toPrint = ($request->toPrint === 'true');
//	var_dump($toPrint);
	$saleAct = SaleAct::create($saleActData);
//	Debugbar::info('$saleAct - start', $saleAct, '$saleAct - end');
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
//	    Debugbar::info('customer - start', $customer, 'customer - end');
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
	$saleAct = SaleAct::where("id", $saleActId)->first(["id", "path_photo"]);
	Debugbar::info('$saleAct - start', $saleAct, '$saleAct - end');
	if (isset($saleAct)) {
	    $photo_paths = $saleAct->path_photo;
	} else {
	    $photo_paths = "";
	}
	return View::make('saleact.photos')->with([
		    'saleActId' => $saleActId,
		    'photo_paths' => $photo_paths
	]);
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
