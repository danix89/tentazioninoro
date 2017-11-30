<?php

namespace Tentazioninoro;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserCustomer extends Authenticatable {

    protected $table = 'users_customers';
    
    public function users() {
	return $this->belongsTo('Tentazioninoro\User');
    }

    public function customers() {
	return $this->belongsTo('Tentazioninoro\Customer');
    }

}
