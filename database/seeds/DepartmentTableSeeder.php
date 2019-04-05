<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('departments')->insert([
            'name' => 'department 1',
            'created_at' => \Carbon\Carbon::now()
        ]);
//        factory(\App\Models\Dashboard\Department::class,10)->create();

    }
}
