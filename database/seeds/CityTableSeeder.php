<?php

use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('cities')->insert([
            'name' => 'cairo',
            'status' => 'display',
            'created_at' => \Carbon\Carbon::now()
        ]);
//        factory(\App\Models\Dashboard\City::class,10)->create();

    }
}
