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

    public function __construct() {
	$this->middleware('auth');
	$this->middleware('has-permissions:' . \Config::get('constants.permission.FIXINGS') . ',');
	app('debugbar')->disable();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($state = null) {
	$userId = Auth::id();
	if (isset($state)) {
	    $fixingList = Fixing::where(['user_id' => $userId, 'state' => $state])->get();
	} else {
	    $fixingList = Fixing::where('user_id', $userId)->get();
	}
	Debugbar::info($fixingList);
	return View::make('fixing/index')->with([
		    'state' => $state,
		    'fixingList' => $fixingList,
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
//	Debugbar::info($customersIds);
	$customerList = array();
	foreach ($customersIds as $customerId) {
	    Debugbar::info("customerId - start", $customerId, "customerId - end");
	    $identityDocument = Customer::find($customerId->customer_id)->identityDocument;
	    $customerList[$customerId->customer_id] = $identityDocument->name . " " . $identityDocument->surname;
	}
	if (isset($customerId)) {
	    $customer = Customer::where('id', $customerId)->get();
	} else {
	    $customer = new Customer;
	}

	$fixing = new Fixing;
//	Debugbar::info($fixing);

	$data = array(
	    'showCustomerList' => true,
	    'customerList' => $customerList,
	    'fixing' => $fixing,
	    'customer' => $customer,
	);
	return View::make('fixing/create')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
	$this->validate($request, Fixing::$rules);
	$fixing = $request->all();
	$id = Auth::id();
	if ($fixing["customer_id"] > 0) {
	    $customer = Customer::find($fixing["customer_id"]);
	    $identityDocument = $customer->identityDocument()->get(['name', 'surname'])[0];
	    Debugbar::info($identityDocument);
	    $path = "";
	    if (Input::hasFile('path_photo')) {
		$fixings = Fixing::orderBy('id', 'desc')->get(["id"]);
		if (isset($fixings)) {
		    $fixingId = $fixings->take(1)->first()->id + 1;
		} else {
		    $fixingId = 1;
		}
		$i = 1;
		foreach ($request->path_photo as $photo) {
		    $ext = $photo->extension();
		    $name = str_replace(" ", "", $identityDocument->name);
		    $surname = str_replace(" ", "", $identityDocument->surname);
		    $path .= $photo->storeAs(Config::get('constants.folders.FIXINGS'), $fixingId . "-" . $name . "_" . $surname . "-" . date("d.m.Y") . "_n." . $i++ . "." . $ext, 'public') . "~";
		}
		$path = substr($path, 0, strlen($path) - 1);
	    }
//	    echo $path;
//	    return;
//	    $path = $request->file('path_photo')->store(Config::get('constants.folders.FIXINGS'));

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
	    $fixing = Fixing::create($fixingData);

	    if ($request->toPrint === 'true') {
		$data = array(
		    'showCustomerList' => false,
		    'fixing' => $fixing,
		    'identityDocument' => $identityDocument,
		    'jewel' => $jewel,
		);

		return $this->printTicket($fixing->id);
	    }
	}

	return redirect(route('fixing.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function show($fixingId) {
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
    }

    public function printTicket($fixingId) {
	$userId = Auth::id();
	$fixing = Fixing::where('id', $fixingId)->get(["id", "customer_id", "jewel_id", "deposit", "estimate"])->first();
	DebugBar::info($fixing);
	$identityDocument = Customer::find($fixing->customer_id)->identityDocument()->get(["name", "surname"])->first();
	$jewel = Jewel::find($fixing->jewel_id)->get(["typology"])->first();

	$data = array(
	    'fixing' => $fixing,
	    'identityDocument' => $identityDocument,
	    'jewel' => $jewel,
	);

	return View::make('fixing/print')->with('data', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function showList($customerId = NULL) {
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function edit(Fixing $fixing) {
//	    return View::make('fixing/create', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fixing $fixing) {
	
    }

    public function updateState(Request $request, $fixingId) {
	$fixing = Fixing::find($fixingId);
	$fixing->state = $request->state;
	$fixing->save();
	return redirect(route('home'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
	var_dump($id);
	Fixing::destroy($id);
	return redirect(route('fixing.index'));
    }

    public function destroyFixings(Request $request) {
	$ids = $request->input('ids');
	foreach ($ids as $id) {
	    print_r($id);
	    Fixing::destroy($id);
	}
	return redirect(route('fixing.index'));
    }

}
