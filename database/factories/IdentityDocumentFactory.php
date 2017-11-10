<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Model::class, function (Faker $faker) {
    $names = array('Maddalena', 'Daniele', 'Claudia', 'Michele', 'Adele', 'Aldo');
    $surnames = array('De Maio', 'Iannone', 'Penna', 'Russo');

    return [
	'release_date' => $faker->date('d-m-y', $max),
	'customer_id' => str_random(16),
	'name' => $names[rand(0, 5)],
	'surname' => $surnames[rand(0, 3)],
	'birth_residence' => 'Montoro',
	'birth_province' => 'AV',
	'birth_date' => $faker->date('d-m-y', $max),
	'residence' => 'Montoro',
	'street' => 'Via Europa',
	'street_number' => '11',
    ];
});
