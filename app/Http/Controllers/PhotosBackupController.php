<?php

namespace Tentazioninoro\Http\Controllers;

use Illuminate\Http\Request;
use View;

class PhotosBackupController extends Controller {

    public function __construct() {
	$this->middleware('auth');
//	$this->middleware('has-permissions:' . \Config::get('constants.permission.PHOTO_BACKUP') . ',');
    }

    public function exec($directoryName) {
	$message = exec("xcopy " . \Config::get('constants.folders.BASE') . $directoryName . " " . \Config::get('constants.folders.EXTERNAL_BACKUP') . date("Ymd") . " /D /H /S /C /I /Z");
	return View::make('backup/photos')->with([
		    'message' => $message,
	]);
    }

}
