<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(User::class, 19)->create();

        User::create([
            'name' =>   'Carlos',
            'lastname' =>   'Cortez',
            'student_code' =>   hash('sha256', rand().time().'Carlos'),
            'city_residence' =>  'Bogotá',
            'hometown' =>   'Bogotá',
            'nationality' =>   'Colombia',
            'email' =>  'admin@admin.com',
            'password' =>  Hash::make(123456789),
            'slug' =>    hash('sha256', rand().time().'Carlos'),
            'fk_role' =>  1,
        ]);

    }
}
