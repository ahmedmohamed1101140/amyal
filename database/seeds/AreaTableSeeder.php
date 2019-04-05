<?php

use Illuminate\Database\Seeder;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('areas')->insert([
            'name' => 'maadi',
            'city_id' => '1',
            'created_at' => \Carbon\Carbon::now()
        ]);
//        factory(\App\Models\Dashboard\Area::class,20)->create();

    }
}
