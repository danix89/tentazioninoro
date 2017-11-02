<?php

/**
 * Description of Gioiello
 *
 * @author Daniele Iannone <diannone3@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gioiello {
    private $id = "";
    private $tipologia = "";
    private $peso = "";
    private $metallo = "";
    private $foto = "";

    public function __construct($id, $tipologia, $peso, $metallo, $foto) {
        $id = escape_input($id);
        $this->id = $id;
        $tipologia = escape_input($tipologia);
        $this->tipologia = $tipologia;
        $peso = escape_input($peso);
        $this->peso = $peso;
        $metallo = escape_input($metallo);
        $this->metallo = $metallo;
        $foto = escape_input($foto);
        $this->foto = $foto;
    }

    public function getCliente() {
        return $this->id;
    }

    public function setCliente($cliente) {
        $cliente = escape_input($cliente);
        $this->cliente = $cliente;
    }

    public function getTipologia() {
        return $this->tipologia;
    }

    public function setTipologia($tipologia) {
        $tipologia = escape_input($tipologia);
        $this->tipologia = $tipologia;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function setPeso($peso) {
        $peso = escape_input($peso);
        $this->peso = $peso;
    }

    public function getMetallo() {
        return $this->metallo;
    }

    public function setMetallo($metallo) {
        $metallo = escape_input($metallo);
        $this->metallo = $metallo;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $foto = escape_input($foto);
        $this->foto = $foto;
    }
    
    public static function serializeGioiello($gioiello) {
        $s = serialize($gioiello);
        // echo $s;
        return $s;
    }

    public static function unserializeGioiello($serialized_gioiello) {
        // echo $serialized_gioiello;
        return unserialize($serialized_gioiello);
    }

}
