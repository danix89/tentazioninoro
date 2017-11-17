<?php

namespace Tentazioninoro;

use Illuminate\Database\Eloquent\Model;

class Fixing extends Model {

    public function user() {
        return $this->belongsTo('Tentazioninoro\User');
    }

    public function customers() {
        return $this->hasMany('Tentazioninoro\Customer');
    }

}
