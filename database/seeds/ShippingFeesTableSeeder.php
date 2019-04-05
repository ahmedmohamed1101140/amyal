<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingFeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('shipping_fees')->insert([
            'user_id' => 1,
            'city_id' => 1,
            'fees' => 100,
            'created_at' => \Carbon\Carbon::now()
        ]);
//        factory(\App\Models\Dashboard\ShippingFees::class,60)->create();
    }
}
