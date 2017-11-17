<?php

namespace Tentazioninoro;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

//    protected $table = 'name_of_the_users_table';
//    $timestamps = false;

    public static $rules = [
	'firstname' => 'required|min:3|max:40',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function customers() {
        return $this->hasMany('Tentazioninoro\Customer');
    }

    public function salesActs() {
        return $this->hasMany('Tentazioninoro\SaleAct');
    }

    public function fixings() {
        return $this->hasMany('Tentazioninoro\Fixing');
    }

}
