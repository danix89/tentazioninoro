<?php

namespace Tentazioninoro\Http\Controllers;

use Auth;
use Config;
use Illuminate\Http\Request;
use Tentazioninoro\Customer;
use Tentazioninoro\IdentityDocument;
use Tentazioninoro\UserCustomer;
use Debugbar;
use View;

class CustomerController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('has-permissions:' . Config::get('constants.permission.FIXINGS') . '-' . Config::get('constants.permission.SALES_ACTS'));
        app('debugbar')->enable();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $userId = Auth::id();
        $customers = UserCustomer::where('user_id', $userId)->get(["customer_id"]);
        $customerList = array();
        $identityDocumentList = array();
        foreach ($customers as $customer) {
            Debugbar::info($customer);
            $customerList[] = Customer::find($customer->customer_id);
            $identityDocumentList[] = IdentityDocument::where("customer_id", $customer->customer_id)->get(["name", "surname", "birth_date"])->first();
        }
//        Debugbar::info($customerList);
//        Debugbar::info($identityDocumentList);
        return View::make('customer/index')->with([
                    'customerList' => $customerList,
                    'identityDocumentList' => $identityDocumentList,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $customer = new Customer();
        return View::make('customer/create')->with("customer", $customer);
    }
    
    private function buildCustomerData($request) {
	$customerData = array(
            'fiscal_code' => $request->fiscalCode,
            'aka' => $request->aka,
            'phone_number' => $request->phoneNumber,
            'mobile_phone' => $request->mobilePhone,
            'email' => $request->email,
            'description' => $request->description,
        );
	
	return $customerData;
    }
    private function buildIdentityDocumentData($request, $customerId) {
	if(isset($request->type)) {
	    $type = $request->type;
	    $releaseDate = $request->releaseDate;
	    $birthResidence = $request->birthResidence;
	    $birthProvince = $request->birthProvince;
	    $streetNumber = $request->streetNumber;
	    $residence = $request->residence;
	    $street = $request->street;
	    $streetNumber = $request->streetNumber;
	} else {
	    $type = "";
	    $releaseDate = "";
	    $birthResidence = "";
	    $birthProvince = "";
	    $streetNumber = "";
	    $residence = "";
	    $street = "";
	    $streetNumber = "";
	}
        $identityDocumentData = array(
            'customer_id' => $customerId,
            'name' => $request->name,
            'surname' => $request->surname,
            'birth_date' => $request->birthDate,
            'birth_residence' => $birthResidence,
            'birth_province' => $birthProvince,
            'residence' => $residence,
            'street' => $street,
            'street_number' => $streetNumber,
            'type' => $type,
            'release_date' => $releaseDate,
        );
	
	return $identityDocumentData;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
//        $this->validate($request, Customer::$rules);
	$customerData = $this->buildCustomerData($request);
        $customer = Customer::create($customerData);
	
	$identityDocumentData = $this->buildIdentityDocumentData($request, $customer->id);
        IdentityDocument::create($identityDocumentData);

        UserCustomer::create(array(
            'user_id' => Auth::id(),
            'customer_id' => $customer->id,
        ));

        return redirect(route('showCustomer', ["customerId" => $customer->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $customer = Customer::where("id", $id)->first();
        $identityDocument = $customer->identityDocument;

        return View::make('customer/show')->with([
                    "customer" => $customer,
                    "identityDocument" => $identityDocument
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $customer = Customer::where("id", $id)->first();
        $identityDocument = $customer->identityDocument;
	
        $customerData = $this->buildCustomerData($request);
        $customer->update($customerData);

        $identityDocumentData = $this->buildIdentityDocumentData($request, $customer->id);
        $identityDocument->update($identityDocumentData);

        return redirect(route('showCustomer', ["customerId" => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        var_dump($id);
        Customer::destroy($id);
        return redirect(route('customer.index'));
    }

    public function destroyCustomers(Request $request) {
        $ids = $request->input('ids');
        foreach ($ids as $id) {
            print_r($id);
            Customer::destroy($id);
        }
        return redirect(route('customer.index'));
    }

}
