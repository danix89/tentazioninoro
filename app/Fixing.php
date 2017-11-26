<?php

namespace Tentazioninoro;

use Illuminate\Database\Eloquent\Model;

class Fixing extends Model {

    public static $rules = [
//        'firstname' => 'required|min:3|max:40',
    ];
    
    protected $guarded = ['id'];
    protected $fillable = ['user_id' ,'customer_id', 'jewel_id', 'description', 'deposit', 'estimate', 'notes', 'state', 'created_at', 'updated_at'];

    
    
    public function user() {
        return $this->belongsTo('Tentazioninoro\User');
    }

    public function customers() {
        return $this->hasMany('Tentazioninoro\Customer');
    }

}
