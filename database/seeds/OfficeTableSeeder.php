<?php

use Illuminate\Database\Seeder;

class OfficeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('offices')->insert([
            'name' => 'office 1',
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('offices')->insert([
            'name' => 'office 2',
            'created_at' => \Carbon\Carbon::now()
        ]);
//        factory(\App\Models\Dashboard\Office::class,10)->create();
    }
}
