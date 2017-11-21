<?php

namespace Tentazioninoro;

use Illuminate\Database\Eloquent\Model;

class Jewel extends Model {

    public static $rules = [
//        'firstname' => 'required|min:3|max:40',
    ];
    
    protected $fillable = ['typology', 'wheight', 'metal', 'path_photo', 'created_at', 'updated_at'];

    public function fixing() {
        return $this->belongsTo('Tentazioninoro\Fixing');
    }

}
