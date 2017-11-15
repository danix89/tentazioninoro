<?php

namespace Tentazioninoro\Http\Controllers;

use Illuminate\Http\Request;
use Tentazioninoro\User;
use Tentazioninoro\Customer;
use Tentazioninoro\Http\Controllers\Controller;
use View;
use Redirect;
use DB;
use Debugbar;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
//	$users = User::get();
	$userList = User::orderBy('name', 'asc')->get();
	Debugbar::info($userList);
	return View::make('user/index')->with('userList', $userList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
	$user = new User();
	return View::make('user/form')->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
	$this->validate($request, User::$rules);
	User::create($request->all());
	return Redirect::to(route('user.index'));
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
	$user = User::findOrFail($id);
        return View::make('fixing/create', ['user' => $user]);
//	return View::make('user/form')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
	$this->validate($request, User::$rules);
	$user = User::findOrFail($id);
	$user->update($request->all());
	return Redirect::to(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
	User::destroy($id);
	return Redirect::to(route('user.index'));
    }

}
