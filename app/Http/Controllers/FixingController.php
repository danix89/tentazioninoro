<?php

namespace Tentazioninoro\Http\Controllers;

use Auth;
use Config;
use DB;
use Debugbar;
use \Input as Input;
use Redirect;
use View;
use Illuminate\Http\Request;
use Tentazioninoro\Customer;
use Tentazioninoro\Fixing;
use Tentazioninoro\Jewel;

class FixingController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	$userId = Auth::id();
	$fixingList = Fixing::where('user_id', $userId)->get();
	Debugbar::info($fixingList);
	return View::make('fixing/index')->with('fixingList', $fixingList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
	$user = Auth::user();
	$fixingList = Fixing::where('user_id', $user->id)->orderBy('customer_id', 'asc')->get();
	Debugbar::info($fixingList);
	return View::make('fixing/create', ['user' => $user]);
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
	if (Input::hasFile('path_photo')) {
	    $uploadDirectory = "uploads";
	    $file = Input::file('path_photo');
	    $file->move($uploadDirectory, $file->getClientOriginalName());
            $path_to_photo = $uploadDirectory . "\\" . $file->getClientOriginalName();
	    $jewelData = array(
		"typology" => $fixing["typology"],
		"weight" => $fixing["weight"],
		"metal" => $fixing["metal"],
		"path_photo" => $path_to_photo,
	    );
	    $jewel = Jewel::create($jewelData);
            JewelController::save_photo_into_cloud($path_to_photo);

	    $fixingData = array(
		"user_id" => $id,
		"customer_id" => $fixing["customer_id"],
		"jewel_id" => $jewel->id,
		"description" => $fixing["description"],
		"deposit" => $fixing["deposit"],
		"estimate" => $fixing["estimate"],
		"notes" => $fixing["notes"],
		"state" => Config::get('constants.fixing.state.not_yet_started'),
	    );

    //        var_dump($jewel);
    //        echo "<br>";
    //        echo $jewel->id;
    //        echo "<br>";
	    Fixing::create($fixingData);
	}
	
	return Redirect::to(route('fixing.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function show() {
	$userId = Auth::id();
//	$fixingList = Fixing::where('user_id', $user->id)->orderBy('customer_id', 'asc')->get();
//	Debugbar::info($fixingList);
	$fixingList = Fixing::where('user_id', $userId)->get();
	Debugbar::info($userId);
	return View::make('fixing/index')->with('fixingList', $fixingList);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function showList($customerId = NULL) {
	$user = Auth::user();
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
//	return View::make('fixing/create', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fixing $fixing) {
	//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
//	var_dump($id);
	Fixing::destroy($id);
	return Redirect::to(route('fixing.index'));
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
