<?php

use Illuminate\Database\Seeder;

class EmployeeRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /**
         * employee have full control on employee section
         */
        foreach (\App\Models\Dashboard\Permission::all() as $permission) {
            \App\Agent::first()->permissions()->sync($permission , false);
        }



    }
}
