<?php

namespace Tentazioninoro\Http\Controllers;

use Tentazioninoro\Fixing;
use Illuminate\Http\Request;

class FixingController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId) {
//	$fixingList = User::where('user_id', $userId)->orderBy('customer_id', 'asc')->get();
//	Debugbar::info($fixingList);
//	return View::make('fixing/create')->with('fixingList', $fixingList);
	return View::make('fixing/create');
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
	//
    }

    /**
     * Display the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function show(Fixing $fixing) {
	//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Tentazioninoro\Fixing  $fixing
     * @return \Illuminate\Http\Response
     */
    public function edit(Fixing $fixing) {
	//
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
