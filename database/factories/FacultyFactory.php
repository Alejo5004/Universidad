<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Faculty;
use Faker\Generator as Faker;

$factory->define(Faculty::class, function (Faker $faker) {
    return [
        'faculty_name' => $faker->sentence(4),
        'faculty_description' => $faker->text(150),
    ];
});
