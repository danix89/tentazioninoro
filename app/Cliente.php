<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {

    public function user() {
        return $this->belongsTo('Tentazioninoro\User')->withTimestamps();
    }

    public function attiDiVendita() {
        return $this->hasMany('Tentazioninoro\AttoDiVendita')->withTimestamps();
    }

    public function Riparazioni() {
        return $this->hasMany('Tentazioninoro\Riparazione')->withTimestamps();
    }
    
    
}
