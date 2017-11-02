<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Riparazione extends Model {

    public function user() {
        return $this->belongsTo('Tentazioninoro\User')->withTimestamps();
    }
    
}
