<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Campus;
use Faker\Generator as Faker;

$factory->define(Campus::class, function (Faker $faker) {
    return [
        'campus_name' => $faker->sentence(4),
        'campus_address' => $faker->text(100),
    ];
});
