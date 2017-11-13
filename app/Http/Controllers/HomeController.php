<?php

namespace Tentazioninoro\Http\Controllers;

class HomeController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Home Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders your application's "dashboard" for users that
      | are authenticated. Of course, you are free to change or remove the
      | controller as you wish. It is just here to get your app started!
      |
     */

    public function getHome() {
	return view('layouts.home')->with('books', $this->getAllBooks());
    }

    public function getBookDetail($id) {
	return view('bookdetail')->with('book', $this->getBook($id));
    }

    private function getAllBooks() {
	return array("Libro1", "Libro2", "Libro3");
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//	$this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index() {
	return view('layout.home');
    }

}
