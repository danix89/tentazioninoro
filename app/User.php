<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

//    protected $table = 'name_of_the_users_table';
//    $timestamps = false;
    
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

    public function clienti() {
        return $this->hasMany('Tentazioninoro\Cliente')->withTimestamps();
    }

    public function attiDiVendita() {
        return $this->hasMany('Tentazioninoro\AttoDiVendita')->withTimestamps();
    }

    public function riparazioni() {
        return $this->hasMany('Tentazioninoro\Riparazione')->withTimestamps();
    }

}
