<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Tentazioninoro\SaleAct::class, function (Faker $faker) {
    $termsOfPayment = array('C.C.', 'Contanti');
    
    return [
//        'user_id' => $faker->randomDigit,
//        'customer_id' => str_random(16),
        'weight' => $faker->randomFloat(2, 0, 1264),
        'price' => $faker->randomFloat(2, 0, 1264),
        'au_quotation' => $faker->randomDigit,
        'arg_quotation' => $faker->randomDigit,
        'agreed_price' => $faker->randomFloat(2, 0, 1264),
        'terms_of_payment' => $termsOfPayment[rand(0, 1)],
        'path_photo' => $faker->url,
    ];
});
