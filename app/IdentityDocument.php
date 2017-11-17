<?php

namespace Tentazioninoro;

use Illuminate\Database\Eloquent\Model;

class IdentityDocument extends Model {
    public function customer() {
        return $this->belongsTo('Tentazioninoro\Customer');
    }
}
