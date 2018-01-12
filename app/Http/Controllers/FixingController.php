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
use Tentazioninoro\IdentityDocument;
use Tentazioninoro\User;

class FixingController extends Controller {

    public function __construct() {
	$this->middleware('auth');
	$this->middleware('has-permissions:' . \Config::get('constants.permission.FIXINGS') . ',');
	app('debugbar')->enable();
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

    private function buildCustomerList() {
	$userId = Auth::id();
	$users_customers = User::find($userId)->customers()->get(); //->groupBy('customer_id');
//	Debugbar::info($customersIds);
	$customerList = array();
	foreach ($users_customers as $user_customer) {
//	    Debugbar::info('$user_customer - start', $user_customer, '$user_customer - end');
	    $customer = Customer::find($user_customer->customer_id);
//	    Debugbar::info('$customer - start', $customer, '$customer - end');
	    $identityDocument = $customer->identityDocument;
	    if (!empty($customer->aka)) {
		$aka = " (" . $customer->aka . ")";
	    } else {
		$aka = "";
	    }
	    $date = explode("-", $identityDocument->birth_date);
	    if (count($date) === 3) {
		$year = $date[0];
		$month = $date[1];
		$day = $date[2];
		$birthDate = " - " . $day . "/" . $month . "/" . $year;
	    } else {
		$birthDate = "";
	    }
	    $customerList[$user_customer->customer_id] = $identityDocument->name . " " . $identityDocument->surname . $aka . $birthDate;
	}

	return $customerList;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
	$customerList = $this->buildCustomerList();
	$customer = new Customer;
	$fixing = new Fixing;
//        Debugbar::info($fixing);

	$lastFixing = Fixing::orderBy('id', 'desc')->take(1)->first();
	if (!isset($lastFixing)) {
	    $fixingId = 1;
	} else {
	    $fixingId = ++$lastFixing->id;
	}
	Debugbar::info($lastFixing);

	$data = array(
	    'canBeUpdated' => false,
	    'customerList' => $customerList,
	    'customer' => $customer,
	    'fixing' => $fixing,
	    'fixingId' => $fixingId,
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
	if ($request->customer_id > 0) {
	    $customer = Customer::find($request->customer_id);
	    $identityDocument = $customer->identityDocument()->get(['name', 'surname'])[0];
//	    Debugbar::info($identityDocument);

	    $photoPaths = $this->saveJewelPhotos($identityDocument);

	    $jewelData = $this->buildJewelData($request, $photoPaths);
	    $jewel = Jewel::create($jewelData);

	    $fixingData = $this->buildFixingData($request, $jewel->id);
	    $fixing = Fixing::create($fixingData);
	    $fixingId = $fixing->id;
	    if ($request->toPrint === 'true') {
		$data = array(
		    'showCustomerList' => false,
		    'fixing' => $fixing,
		    'identityDocument' => $identityDocument,
		    'jewel' => $jewel,
		);

		return $this->printTicket($fixingId);
	    } else {
		return redirect(route('showFixing', $fixingId));
	    }
	}

	return redirect(route('fixing.index'));
    }

    private function deletePhotos($jewel) {
	$photoPaths = explode("~", $jewel->path_photo);
	\Storage::delete($photoPaths);
	$jewel->path_photo = "";
    }

    private function saveJewelPhotos($identityDocument, $fixingId = -1) {
	$path = "";
	if (Input::hasFile('path_photo')) {
	    if ($fixingId === -1) {
		$fixings = Fixing::orderBy('id', 'desc')->get(["id"]);
//		Debugbar::info($fixings);
		if ($fixings->count() > 0) {
		    $fixing = $fixings->take(1)->first();
//                    Debugbar::info($fixing);
		    $fixingId = $fixing->id + 1;
		} else {
		    $fixingId = 1;
		}
	    }

	    $i = 1;
	    foreach (Input::file('path_photo') as $photo) {
		$ext = $photo->extension();
		$name = str_replace(" ", "", $identityDocument->name);
		$surname = str_replace(" ", "", $identityDocument->surname);
		$path .= $photo->storeAs(Config::get('constants.folders.FIXINGS'), $fixingId . "-" . $name . "_" . $surname . "-" . date("d.m.Y") . "_n." . $i++ . "." . $ext, 'public') . "~";
	    }
	    $path = substr($path, 0, strlen($path) - 1);
	}
//	    echo $path;
//	    $path = $request->file('path_photo')->store(Config::get('constants.folders.FIXINGS'));
	return $path;
    }

    private function buildJewelData($request, $photoPaths) {
	$customer = Customer::find($request->customer_id);
	$identityDocument = $customer->identityDocument()->get(['name', 'surname'])[0];
	Debugbar::info($identityDocument);

	$jewelData = array(
	    "typology" => $request->typology,
	    "weight" => $request->weight,
	    "metal" => $request->metal,
	    "path_photo" => $photoPaths,
	);

	return $jewelData;
    }

    private function buildFixingData($request, $jewelId) {
	$id = Auth::id();
	
	if(isset($request->state)) {
	    $state = $request->state;
	} else {
	    $state = Config::get('constants.fixing.state.NOT_YET_STARTED');
	}
	
	$fixingData = array(
	    "user_id" => $id,
	    "customer_id" => $request->customer_id,
	    "jewel_id" => $jewelId,
	    "state" => $state,
	    "description" => $request->description,
	    "deposit" => $request->deposit,
	    "estimate" => $request->estimate,
	    "notes" => $request->notes,
	);

	return $fixingData;
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
	$fixing = Fixing::where('id', $fixingId)->get()->first();
	$jewel = Jewel::where('id', $fixing->jewel_id)->get()->first();
//            $customer = Customer::where('id', $fixing->customer_id)->get()->first();
	$identityDocument = Customer::find($fixing->customer_id)->identityDocument;

	$customerList = $this->buildCustomerList();

	$data = array(
	    'canBeUpdated' => true,
	    'customerList' => $customerList,
	    'fixing' => $fixing,
	    'customer' => $customer,
	    'identityDocument' => $identityDocument,
	    'jewel' => $jewel,
	);

	return View::make('fixing/create')->with('data', $data);
    }

    public function printTicket($fixingId) {
//	$userId = Auth::id();
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
    public function update(Request $request, $fixingId) {
	$fixing = Fixing::where("id", $fixingId)->first();
	$jewel = Jewel::where("id", $fixing->jewel_id)->first();
	
	$toDelete = $request->deletePhotos === "true"? true : false;
//	var_dump($toDelete);
//	return;
	if ($toDelete) {
	    $this->deletePhotos($jewel);
	    $customer = Customer::find($request->customer_id);
	    $identityDocument = $customer->identityDocument()->get(['name', 'surname'])[0];
//	    Debugbar::info($identityDocument);

	    $photoPaths = $this->saveJewelPhotos($identityDocument, $fixingId);
	} else {
	    $photoPaths = $jewel->path_photo;
	}

	$jewelData = $this->buildJewelData($request, $photoPaths);
	$jewel->update($jewelData);

	$fixingData = $this->buildFixingData($request, $jewel->id);
	$fixing->update($fixingData);
	
	return redirect(route('showFixing', $fixingId));
    }

//    public function updateState(Request $request, $fixingId) {
//        $fixing = Fixing::find($fixingId);
//        $fixing->state = $request->state;
//        $fixing->save();
//        return redirect(route('home'));
//    }

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
