<?php

namespace Tentazioninoro\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Debugbar;
use View;

class PhotosBackupController extends Controller {

    public function __construct() {
	$this->middleware('auth');
//	$this->middleware('has-permissions:' . Config::get('constants.permission.PHOTO_BACKUP') . ',');
    }

    public function exec($directoryName) {
	$backupPathPhoto = Config::get('constants.folders.EXTERNAL_BACKUP') . date("Y.m.d") . "\\" . $directoryName;
	if(Config::get('constants.folders.FIXINGS')) {
	    $jewels = \Tentazioninoro\Jewel::get(["backup_path_photo"]);
	    foreach ($jewels as $jewel) {
		$jewel->backup_path_photo = $backupPathPhoto;
		$jewel->save();
	    }
	} else if(Config::get('constants.folders.SALES_ACTS')) {
	    $jewels = \Tentazioninoro\SaleAct::get(["backup_path_photo"]);
	    foreach ($jewels as $jewel) {
		$jewel->backup_path_photo = $backupPathPhoto;
	    }
	    $jewels->save();
	}
	$cmd = "xcopy " . \Storage::disk()->getDriver()->getAdapter()->getPathPrefix() . $directoryName . " " . $backupPathPhoto . " /Y /H /S /C /I /Z";
	Debugbar::info($cmd);
	$message = exec($cmd);
	return View::make('backup/photos')->with([
		    'message' => $message,
	]);
    }

    public function delete($directoryName) {
	$cmd = "DEL " . \Storage::disk()->getDriver()->getAdapter()->getPathPrefix() . $directoryName . "\\* /Q";
	Debugbar::info($cmd);	
	$message = exec($cmd);
	if(empty($message)) {
	    $message = "Tutte le foto sono state rimosse correttamente.";
	}
	
	return View::make('backup/photos')->with([
		    'message' => $message,
	]);
    }

}
