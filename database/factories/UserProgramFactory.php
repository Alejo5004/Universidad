<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\UserProgram;

$factory->define(UserProgram::class, function (Faker $faker) {
    return [
        'fk_program' => rand(1, 20),
        'fk_user' => 5,
    ];
});
