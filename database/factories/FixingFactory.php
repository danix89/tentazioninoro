<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Model::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomDigit,
        'customer_id' => str_random(16),
        'jewel_id' => $faker->randomDigit,
        'description' => $faker->sentences(),
        'deposit' => $faker->randomFloat(),
        'estimate' => $faker->randomFloat(),
        'notes' => $faker->sentences(),
        'state' => $faker->phoneNumber
    ];
});
