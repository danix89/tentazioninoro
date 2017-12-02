<?php

namespace Tentazioninoro;

use Illuminate\Database\Eloquent\Model;

class SaleAct extends Model {

    protected $table = 'sales_acts';

    protected $fillable = [
        'user_id', 'customer_id', 'path_photo',
    ];
    
    public function user() {
	return $this->belongsTo('Tentazioninoro\User');
    }

    public function customers() {
	return $this->hasMany('Tentazioninoro\Customer');
    }

}
