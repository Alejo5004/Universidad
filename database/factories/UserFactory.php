<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $name =$faker->word(5);
    return [
        'name' => $name,
        'lastname' => $faker->sentence(2),
        'student_code' => $faker->word(10),
        'city_residence' => $faker->sentence(2),
        'hometown' => $faker->sentence(1),
        'nationality' => $faker->sentence(1),
        'slug' => hash('sha256', rand().time().$name),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'fk_role'=> 2,
        'fk_program1'=> rand(1,10),
        'fk_program2'=> rand(11,20),
    ];
});
