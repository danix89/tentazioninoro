<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Tentazioninoro\Customer::class, function (Faker $faker) {
    return [
        'fiscal_code' => str_random(16),
        'phone_number_1' => $faker->phoneNumber,
        'phone_number_2' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'description' => $faker->sentence,
    ];
});
