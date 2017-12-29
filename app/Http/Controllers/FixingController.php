<?php

namespace Tentazioninoro\Http\Controllers;

use Auth;
use Config;
use Debugbar;
use \Input as Input;
use View;
use Illuminate\Http\Request;
use Tentazioninoro\Customer;
use Tentazioninoro\Fixing;
use Tentazioninoro\Jewel;
use Tentazioninoro\User;

class FixingController extends Controller {

    private function isAllowedAccess() {
	if (Auth::check() && Auth::user()->permissions === \Config::get('constants.permission.FIXINGS')) {
	    return true;
	} else {
	    redirect('/access-not-allowed');
	    return false;
	}
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	if ($this->isAllowedAccess()) {
	    $userId = Auth::id();
	    $fixingList = Fixing::where('user_id', $userId)->get();
	    Debugbar::info($fixingList);
	    return View::make('fixing/index')->with('fixingList', $fixingList);
	}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
	if ($this->isAllowedAccess()) {
//	    $user = Auth::user();
//	    $fixingList = Fixing::where('user_id', $user->id)->orderBy('customer_id', 'asc')->get();
//	    Debugbar::info($fixingList);
//	    return View::make('fixing/create', ['user' => $user]);

	    $userId = Auth::id();
	    $customersIds = User::find($userId)->customers()->get(); //->groupBy('customer_id');
//	    Debugbar::info($customersIds);
	    $customerList = array();
	    foreach ($customersIds as $customerId) {
		Debugbar::info("customerId - start", $customerId, "customerId - end");
		$identityDocument = Customer::find($customerId->customer_id)->identityDocument;
		$customerList[$customerId->customer_id] = $identityDocument->name . " " . $identityDocument->surname;
//		$customerList[] = $identityDocument;
	    }
//	    $customerList = [1, 2, 43];
//	    Debugbar::info("fixingList - start", $fixingList, "fixingList - end");
//	    Debugbar::info($customerList);
	    if (isset($customerId)) {
		$customer = Customer::where('id', $customerId)->get();
	    } else {
		$customer = new Customer;
	    }

	    $fixing = new Fixing;
//	    Debugbar::info($user);
//	    Debugbar::info($fixing);

	    $data = array(
		'showCustomerList' => true,
		'customerList' => $customerList,
		'fixing' => $fixing,
		'customer' => $customer,
	    );
	    return View::make('fixing/create')->with('data', $data);
	}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
	if ($this->isAllowedAccess()) {
	    $this->validate($request, Fixing::$rules);
	    $fixing = $request->all();
	    $id = Auth::id();
	    if (Input::hasFile('path_photo')) {
//		$uploadDirectory = "uploads";
//		$file = Input::file('path_photo');
//		$file->move($uploadDirectory, $file->getClientOriginalName());
//		$path_to_photo = $uploadDirectory . "\\" . $file->getClientOriginalName();
//		var_dump($request->file('path_photo'));
		$path = "";
		foreach ($request->path_photo as $photo) {
		    $path .= $photo->store(Config::get('constants.folders.FIXINGS')) . "~";
		}
//		echo $path;
//		$path = $request->file('path_photo')->store(Config::get('constants.folders.FIXINGS'));

		$jewelData = array(
		    "typology" => $fixing["typology"],
		    "weight" => $fixing["weight"],
		    "metal" => $fixing["metal"],
		    "path_photo" => $path,
		);
		$jewel = Jewel::create($jewelData);

		$fixingData = array(
		    "user_id" => $id,
		    "customer_id" => $fixing["customer_id"],
		    "jewel_id" => $jewel->id,
		    "description" => $fixing["description"],
		    "deposit" => $fixing["deposit"],
		    "estimate" => $fixing["estimate"],
		    "notes" => $fixing["notes"],
		    "state" => Config::get('constants.fixing.state.NOT_YET_STARTED'),
		);
		Fixing::create($fixingData);
	    }

	    return redirect(route('fixing.index'));
	}
    }

    /**
     * Display the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function show($fixingId) {
	if ($this->isAllowedAccess()) {
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function showList($customerId = NULL) {
	if ($this->isAllowedAccess()) {
	    $userId = Auth::id();
	    if (isset($customerId)) {
		$whereArray = [
		    'user_id' => $userId,
		    'customer_id' => $customerId,
		];
	    } else {
		$whereArray = [
		    'user_id' => $userId,
		];
	    }
	    $fixingList = Fixing::where($whereArray)->get();
	    DebugBar::info($fixingList);
	    return View::make('fixing/index')->with('fixingList', $fixingList);
	} else {
//	    return redirect('/access-not-allowed');
	}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function edit(Fixing $fixing) {
	if ($this->isAllowedAccess()) {
//	    return View::make('fixing/create', ['user' => $user]);
	}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fixing $fixing) {
	if ($this->isAllowedAccess()) {
	    
	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
//	var_dump($id);
	if ($this->isAllowedAccess()) {
	    Fixing::destroy($id);
	    return redirect(route('fixing.index'));
	}
    }

    public function destroyFixings(Request $request) {
	if ($this->isAllowedAccess()) {
	    $ids = $request->input('ids');
	    foreach ($ids as $id) {
		print_r($id);
		Fixing::destroy($id);
	    }
	    return redirect(route('fixing.index'));
	}
    }

}
