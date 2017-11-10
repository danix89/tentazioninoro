<?php

namespace Tentazioninoro\Http\Controllers;

use Tentazioninoro\Http\Requests;
use Tentazioninoro\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttoDiVenditaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
	return response("index()");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
//	    $name = $request->input('name');
//	    $email = $request->input('email', 'mail@domain.com');
//	    $allParameters = $request->all();
//	    $value = $request->cookie('cookieName');
	return response('create()')
			->header('Content-Type', 'text/plain')
			->withCookie('myCookieName', 'myCookieValue');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
	return response("store()");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
	return response("show()")->download('file.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
	return response("edit()");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
	return response("update()");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
	return response("destroy()")->redirect(route('myRoute'));
    }

}
