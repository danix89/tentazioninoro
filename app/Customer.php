<?php

namespace Tentazioninoro;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

    public function user() {
        return $this->belongsTo('Tentazioninoro\User')->withTimestamps();
    }

    public function salesActs() {
        return $this->hasMany('Tentazioninoro\SaleAct')->withTimestamps();
    }

    public function fixings() {
        return $this->hasMany('Tentazioninoro\Fixing')->withTimestamps();
    }

}
