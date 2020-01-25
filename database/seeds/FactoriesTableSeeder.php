<?php

use Illuminate\Database\Seeder;
use App\Faculty;

class FactoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Faculty::class, 20)->create();
    }
}
