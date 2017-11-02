<?php
/**
 * Description of Cliente
 *
 * @author Daniele Iannone <diannone3@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente {

    private $id = "";
    private $nome = "";
    private $cognome = "";
    private $cellulare = "";
    private $telefono = "";
    private $email = "";

    public function __construct($nome, $cognome, $cellulare, $telefono, $email) {
        $nome = escape_input($nome);
        $this->nome = $nome;
        $cognome = escape_input($cognome);
        $this->cognome = $cognome;
        $cellulare = escape_input($cellulare);
        $this->cellulare = $cellulare;
        $telefono = escape_input($telefono);
        $this->telefono = $telefono;
        $email = escape_input($email);
        $this->email = $email;
        $this->createId();
    }

    public function getId() {
        return $this->id;
    }

    private function createId() {
        $this->id = md5($this->cognome);
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $nome = escape_input($nome);
        $this->nome = $nome;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function setCognome($cognome) {
        $cognome = escape_input($cognome);
        $this->cognome = $cognome;
    }

    public function getCellulare() {
        return $this->cellulare;
    }

    public function setCellulare($cellulare) {
        $cellulare = escape_input($cellulare);
        $this->cellulare = $cellulare;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $telefono = escape_input($telefono);
        $this->telefono = $telefono;
    }

    public function getEmail() {
        return $this->telefono;
    }

    public function setEmail($email) {
        $email = escape_input($email);
        $this->email = $email;
    }
    
    public static function serializeUserSettings($user_settings) {
        $s = serialize($user_settings);
        // echo $s;
        return $s;
    }

    public static function unserializeUserSettings($serialized_user_settings) {
        // echo $serialized_user_settings;
        return unserialize($serialized_user_settings);
    }

}
