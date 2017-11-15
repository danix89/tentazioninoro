<?php

namespace Tentazioninoro;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

    public static $rules = [
	'fiscal_code' => 'required|min:16|max:16',
    ];

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
