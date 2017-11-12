<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Tentazioninoro\Customer::class, function (Faker $faker) {
    return [
        'fiscal_code' => str_random(16),
        'mobile_phone' => $faker->phoneNumber,
        'phone_number' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'description' => $faker->sentence,
    ];
});
