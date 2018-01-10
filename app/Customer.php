<?php

namespace Tentazioninoro;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

    public static $rules = [
        'fiscal_code' => 'min:16|max:16',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    protected $fillable = [
        'fiscal_code', 'name', 'surname', 'aka', 'phone_number', 'mobile_phone', 'email', 'description',
    ];

    public function identityDocument() {
        return $this->hasOne('Tentazioninoro\IdentityDocument');
    }

    public function users() {
        return $this->hasMany('Tentazioninoro\UserCustomer');
    }

    public function salesActs() {
        return $this->hasMany('Tentazioninoro\SaleAct');
    }

    public function fixings() {
        return $this->hasMany('Tentazioninoro\Fixing');
    }

}
