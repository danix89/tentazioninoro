<?php

namespace Tentazioninoro\Http\Controllers;

use Auth;
use Config;
use DB;
use Debugbar;
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
        $fixingList = Fixing::where('user_id', 1)->get();
        Debugbar::info($fixingList);
        return View::make('fixing/index')->with('userId', $userId)->with('fixingList', $fixingList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user) {
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
        
        $jewelData = array(
            "typology" => $fixing["typology"],
            "wheight" => $fixing["wheight"],
            "metal" => $fixing["metal"],
            "path_photo" => $fixing["path_photo"],
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
            "state" => Config::get('constants.fixing.state.not_yet_started'),
        );
//        var_dump($jewel);
//        echo "<br>";
//        echo $jewel->id;
//        echo "<br>";
        Fixing::create($fixingData);
        return Redirect::to(route('fixing.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function show($userId) {
//	$fixingList = Fixing::where('user_id', $user->id)->orderBy('customer_id', 'asc')->get();
//	Debugbar::info($fixingList);
        $fixingList = Fixing::where('user_id', $userId)->get();
        Debugbar::info($userId);
        return View::make('fixing/index')->with('userId', $userId)->with('fixingList', $fixingList);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function showList($userId, $customerId = NULL) {

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
        return View::make('fixing/index')->with('userId', $userId)->with('fixingList', $fixingList);
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
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fixing $fixing) {
        //
    }

}
