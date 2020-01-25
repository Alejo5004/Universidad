<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Program;

$factory->define(Program::class, function (Faker $faker) {
    return [
        'program_name' => $faker->sentence(4),
        'modality' => $faker->randomElement(['Presencial', 'Virtual']),
        'status' => $faker->randomElement(['Activo', 'Desactiva']),
        'fk_faculty' => rand(1, 20),
        'fk_campus' => rand(1, 5),
    ];
});
