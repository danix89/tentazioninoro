<?php

namespace Tentazioninoro\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Tentazioninoro\Customer;
use Tentazioninoro\IdentityDocument;
use Tentazioninoro\UserCustomer;

class CustomerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
//        $this->validate($request, Customer::$rules);
        $data = $request->all();
        $customerData = array(
            'fiscal_code' => $data["fiscal_code"], 
            'phone_number' => $data["phone_number"], 
            'mobile_phone' => $data["mobile_phone"], 
            'email' => $data["email"], 
            'description' => $data["description"],
        );
        $customer = Customer::create($customerData);
        
        $identityDocumentData = array(
            'customer_id' => $customer->id,
            'release_date' => "1900-01-01",
            'name' => $data["name"], 
            'surname' => $data["surname"],
            'birth_residence' => "",
            'birth_province' => "",
            'birth_date' => "1900-01-01",
            'residence' => "",
            'street' => "",
            'street_number' => "",
        );
        IdentityDocument::create($identityDocumentData);
        
        UserCustomer::create(array(
            'user_id' => Auth::id(),
            'customer_id' => $customer->id,
        ));
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
