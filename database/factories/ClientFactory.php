<?php

use Faker\Generator as Faker;

$factory->define(\App\User::class, function (Faker $faker) {
    return [
        'company_name' => $faker->name,
        'phone' => $faker->unique()->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address,
        'pickup_address' => $faker->address,
        'cp_name' => $faker->name,
        'cp_phone' => $faker->unique()->phoneNumber,
        'account_number' =>$faker->unique()->ssn,
        'city_id' => function(){
            return \App\Models\Dashboard\City::all()->random();
        },
        'office_id' => function(){
            return \App\Models\Dashboard\Office::all()->random();
        },
        'agent_id' => function(){
            return \App\Agent::all()->random();
        },
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),

    ];
});
