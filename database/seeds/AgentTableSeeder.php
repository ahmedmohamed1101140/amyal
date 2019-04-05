<?php

use Illuminate\Database\Seeder;

class AgentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('agents')->insert([
            'name' => 'Amyal Admin',
            'email' => 'admin@amyalexpress.com',
            'username' => 'admin_user_name',
            'phone' => '01111111111',
            'ssn' => '11111111111',
            'address' => 'Cairo - Maadi',
            'age' => \Carbon\Carbon::now(),
            'join_date' => \Carbon\Carbon::now(),
            'shift_from' => '10:30 PM',
            'shift_to' => '10:30 AM',
            'office_id' => 1,
            'department_id' => 1,
            'city_id' => 1,
            'position' => 'ADMIN',
            'password' => bcrypt('123456'),
            'type' => 'Employee',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('agents')->insert([
            'name' => 'Amyal Sales',
            'email' => 'sales@amyalexpress.com',
            'username' => 'sales_user_name',
            'phone' => '01000000000',
            'ssn' => '222222222222',
            'address' => 'Cairo - Maadi',
            'age' => \Carbon\Carbon::now(),
            'join_date' => \Carbon\Carbon::now(),
            'shift_from' => '10:30 PM',
            'shift_to' => '10:30 AM',
            'office_id' => 1,
            'department_id' => 1,
            'city_id' => 1,
            'password' => bcrypt('123456'),
            'type' => 'Sales Person',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('agents')->insert([
            'name' => 'Amyal Delivery Agent',
            'email' => 'delivery@amyalexpress.com',
            'username' => 'delivery_user_name',
            'phone' => '01005000000',
            'ssn' => '222222232222',
            'address' => 'Cairo - Maadi',
            'age' => \Carbon\Carbon::now(),
            'join_date' => \Carbon\Carbon::now(),
            'shift_from' => '10:30 PM',
            'shift_to' => '10:30 AM',
            'office_id' => 1,
            'department_id' => 1,
            'city_id' => 1,
            'password' => bcrypt('123456'),
            'type' => 'Delivery Agent',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('agents')->insert([
            'name' => 'Amyal Pickup',
            'email' => 'pickup@amyalexpress.com',
            'username' => 'pickup_user_name',
            'phone' => '01112222222',
            'ssn' => '2222222221111',
            'address' => 'Cairo - Maadi',
            'age' => \Carbon\Carbon::now(),
            'join_date' => \Carbon\Carbon::now(),
            'shift_from' => '10:30 PM',
            'shift_to' => '10:30 AM',
            'office_id' => 1,
            'department_id' => 1,
            'city_id' => 1,
            'password' => bcrypt('123456'),
            'type' => 'Pickup Agent',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

//        factory(\App\Agent::class,5)->create();

    }
}
