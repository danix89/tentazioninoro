<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Tentazioninoro\Fixing::class, function (Faker $faker) {
    return [
//        'user_id' => $faker->randomDigit,
//        'customer_id' => str_random(16),
        'jewel_id' => $faker->randomDigit,
        'description' => $faker->sentence,
        'deposit' => $faker->randomFloat(2, 0, 1264),
        'estimate' => $faker->randomFloat(2, 0, 1264),
        'notes' => $faker->sentence,
        'state' => $faker->phoneNumber
    ];
});
