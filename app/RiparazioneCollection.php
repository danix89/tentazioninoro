<?php

/*
 * The MIT License
 *
 * Copyright 2017 Daniele Iannone <diannone3@gmail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

require_once(__DIR__ . '\php\beans\Riparazione.php');
require_once(__DIR__ . '\php\beans\RiparazioneCollectionExceptions.php');

class RiparazioneCollection {

    private $riparazioneCollection;

//        private $lastUsedId;

    public function __construct($username) {
	$this->riparazioneCollection = array();
//            $this->lastUsedId = -1;
    }

    public function getRiparazioneCollection() {
	return $this->riparazioneCollection;
    }

    public function removeAllRiparazioneCollection() {
	unset($this->riparazioneCollection);
	$this->riparazioneCollection = array();
    }

    public function addRiparazione($riparazione) {
//            echo "<br>" . $this->lastUsedId;
//            $newId = $this->lastUsedId + 1;
	$newId = $riparazione->getId();
	if (isset($this->riparazioneCollection[$newId])) { // This check always has to be false. If not, something went wrong.
	    // throw new KeyHasUseException('Il nome "' . $name . '" risulta gi� in uso.');
	    throw new KeyHasUseException('L\'id"' . $newId . '" risulta gi� in uso.');
	} else {
	    $riparazione->setId($newId);
	    $this->riparazioneCollection[$newId] = $riparazione;
//                $this->lastUsedId = $newId;
//                echo "->" . $this->lastUsedId;
	}
    }

    public function updateRiparazione($id, $riparazione) {
	if (isset($this->riparazioneCollection[$id])) {
//                echo "<br>";
//                echo "url immagine prima = " . $this->RiparazioneCollection[$id]->getImageUrl();

	    $riparazione->setId($id);
	    $this->riparazioneCollection[$id] = $riparazione;

//                echo "<br>";
//                echo "url immagine dopo = " . $this->RiparazioneCollection[$id]->getImageUrl();
	} else {
	    throw new KeyHasUseException('L\'id"' . $id . '" non � associato ad alcuna web app.');
	}
    }

    public function getRiparazione($id) {
	return $this->riparazioneCollection[$id];
    }

    public function removeRiparazione($riparazioneId) {
	if (isset($this->riparazioneCollection[$riparazioneId])) {
	    unset($this->riparazioneCollection[$riparazioneId]);
	} else {
	    throw new KeyInvalidException('Il nome "' . $riparazioneId . '" risulta non valido.');
	}
    }

    public function size() {
	return count($this->riparazioneCollection);
    }

    public function keyExists($riparazioneId) {
	return isset($this->riparazioneCollection[$riparazioneId]);
    }

    public static function serializeRiparazioneCollection($riparazioneCollection) {
	$s = serialize($riparazioneCollection);
	// echo $s;
	return $s;
    }

    public static function unserializeRiparazioneCollection($serialized_RiparazioneCollection) {
	// echo "<br>" . $serialized_RiparazioneCollection;
	return unserialize($serialized_RiparazioneCollection);
    }

}
