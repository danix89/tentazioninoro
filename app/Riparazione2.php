<?php

/**
 * Description of Riparazione
 *
 * @author Daniele Iannone <diannone3@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Riparazione {

    const IN_RIPARAZIONE = "In riparazione";
    const RIPARATO = "Riparato";

    private $id = "";
    private $cliente = "";
    private $gioiello = "";
    private $peso = "";
    private $metallo = "";
    private $foto = "";
    private $descrizione = "";
    private $acconto = "";
    private $preventivo = "";
    private $appunti = "";
    private $stato = "";

    public function __construct($id, $cliente, $gioiello, $descrizione, $acconto, $preventivo, $appunti, $stato = IN_RIPARAZIONE) {
	$id = escape_input($id);
	$this->id = $id;
	$cliente = escape_input($cliente);
	$this->cliente = $cliente;
	$gioiello = escape_input($gioiello);
	$this->gioiello = $gioiello;
	$descrizione = escape_input($descrizione);
	$this->descrizione = $descrizione;
	$acconto = escape_input($acconto);
	$this->acconto = $acconto;
	$preventivo = escape_input($preventivo);
	$this->preventivo = $preventivo;
	$appunti = escape_input($appunti);
	$this->appunti = $appunti;
	$stato = escape_input($stato);
	$this->stato = IN_RIPARAZIONE;
    }

    public function getId() {
	return $this->id;
    }

    public function setId($id) {
	$id = escape_input($id);
	$this->id = $id;
    }

    public function getCliente() {
	return $this->id;
    }

    public function setCliente($cliente) {
	$cliente = escape_input($cliente);
	$this->cliente = $cliente;
    }

    public function getGioiello() {
	return $this->gioiello;
    }

    public function setGioiello($gioiello) {
	$gioiello = escape_input($gioiello);
	$this->gioiello = $gioiello;
    }

    public function getDescrizione() {
	return $this->peso;
    }

    public function setDescrizione($descrizione) {
	$descrizione = escape_input($descrizione);
	$this->descrizione = $descrizione;
    }

    public function getAcconto() {
	return $this->acconto;
    }

    public function setAcconto($acconto) {
	$acconto = escape_input($acconto);
	$this->acconto = $acconto;
    }

    public function getPreventivo() {
	return $this->preventivo;
    }

    public function setPreventivo($preventivo) {
	$preventivo = escape_input($preventivo);
	$this->preventivo = $preventivo;
    }

    public function getAppunti() {
	return $this->appunti;
    }

    public function setAppunti($appunti) {
	$appunti = escape_input($appunti);
	$this->appunti = $appunti;
    }

    public function getStato() {
	return $this->stato;
    }

    public function setStato($stato) {
	$stato = escape_input($stato);
	$this->stato = $stato;
    }

    public static function serializeRiparazione($riparazione) {
	$s = serialize($riparazione);
	// echo $s;
	return $s;
    }

    public static function unserializeRiparazione($serialized_riparazione) {
	// echo $serialized_riparazione;
	return unserialize($serialized_riparazione);
    }

}
