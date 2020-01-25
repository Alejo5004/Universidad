<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->id_role = 1;
        $role->role_name = "Administrador";
        $role->save();

        $role = new Role();
        $role->id_role = 2;
        $role->role_name = "Estudiante";
        $role->save();

    }
}
