<?php

namespace Tentazioninoro;

use Illuminate\Database\Eloquent\Model;

class SaleAct extends Model {

    public function user() {
        return $this->belongsTo('Tentazioninoro\User')->withTimestamps();
    }

    public function customers() {
        return $this->hasMany('Tentazioninoro\Customer')->withTimestamps();
    }

}