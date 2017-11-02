<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttoDiVendita extends Model {

    public function user() {
        return $this->belongsTo('Tentazioninoro\User')->withTimestamps();
    }

    public function clienti() {
        return $this->hasMany('Tentazioninoro\Cliente')->withTimestamps();
    }

}
