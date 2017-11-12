<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Tentazioninoro\SaleAct::class, function (Faker $faker) {
    return [
//        'user_id' => $faker->randomDigit,
//        'customer_id' => str_random(16),
        'path_photo' => $faker->url,
    ];
});
