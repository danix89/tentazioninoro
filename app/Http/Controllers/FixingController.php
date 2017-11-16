<?php

namespace Tentazioninoro\Http\Controllers;

use Tentazioninoro\Fixing;
use Tentazioninoro\Customer;
use View;
use Redirect;
use DB;
use Illuminate\Http\Request;
use Debugbar;

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
	//
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
    public function showList($userId) {
//	$fixingList = Fixing::where('user_id', $user->id)->orderBy('customer_id', 'asc')->get();
//	Debugbar::info($fixingList);
	$fixingList = Fixing::where('user_id', $userId)->get();
	Debugbar::info($userId);
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
