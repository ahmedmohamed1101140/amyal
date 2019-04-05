<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'company_name' => 'souq',
            'phone' => '0111371111',
            'email' => 'souq@info.com',
            'address' => 'address',
            'pickup_address' => 'pickup Address',
            'cp_name' => 'Ahmed',
            'cp_phone' => '02221232123',
            'account_number' => 'SO1072',
            'status' => 'Active',
            'city_id' => 1,
            'office_id' => 1,
            'agent_id' => 2,
            'password' => bcrypt('123456'),
            'first_login' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);
//        factory(\App\User::class,5)->create();
    }
}
