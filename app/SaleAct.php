<?php

namespace Tentazioninoro;

use Illuminate\Database\Eloquent\Model;

class SaleAct extends Model {

    protected $table = 'sales_acts';

    protected $fillable = [
        'id_number', 'user_id', 'customer_id', 'objects', 'weight', 'price', 'au_quotation', 'arg_quotation', 'agreed_price', 'string_agreed_price', 'terms_of_payment', 'path_photo', 
    ];

    public function user() {
	return $this->belongsTo('Tentazioninoro\User');
    }

    public function customer() {
	return $this->belongsTo('Tentazioninoro\Customer');
    }

}
