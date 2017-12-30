<?php

namespace Tentazioninoro\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
//        $id = Auth::id();
//        return view('home');
	$user = Auth::user();
	if($user->permissions === \Config::get('constants.permission.FIXINGS')) {
	    return redirect(route('showList'));
	} else if($user->permissions === \Config::get('constants.permission.SALES_ACTS')) {
	    return redirect(route('showSaleActList'));
	}
    }
    
    public function showAccessNotAllowedPage() {
	return view('/access-not-allowed');
    }
}
