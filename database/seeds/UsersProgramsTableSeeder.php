<?php

use Illuminate\Database\Seeder;
use App\UserProgram;

class UsersProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserProgram::class, 2)->create();
    }
}
