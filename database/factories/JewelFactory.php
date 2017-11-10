<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Model::class, function (Faker $faker) {
    $typologies = array('Orologio', 'Bracciale', 'Collana', 'Orecchini', 'Anello');
    $metals = array('Oro', 'Oro bianco', 'Argento');
    
    return [
        'typology' => $typologies[rand(0, 4)],
        'weight' => $faker->randomFloat(2, 0.1, 0.5),
        'metal' => $metals[rand(0, 2)],
        'path_photo' => url()
    ];
});
