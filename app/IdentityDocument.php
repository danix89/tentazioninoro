<?php

namespace Tentazioninoro;

use Illuminate\Database\Eloquent\Model;

class IdentityDocument extends Model {

    protected $guarded = ['id'];
    
    
    protected $fillable = [
        'customer_id', 'type', 'release_date', 'name', 'surname', 'birth_residence', 'birth_province', 'birth_date', 'residence', 'street', 'street_number',
    ];

    public function customer() {
        return $this->belongsTo('Tentazioninoro\Customer');
    }

}
