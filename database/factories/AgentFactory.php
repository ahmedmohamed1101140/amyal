<?php

use Faker\Generator as Faker;

$factory->define(App\Agent::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->unique()->userName,
        'phone' => $faker->unique()->phoneNumber,
        'ssn' =>$faker->unique()->ssn,
        'address' => $faker->address,
        'age' => $faker->dateTime($max = 'now', $timezone = null),
        'join_date' => $faker->dateTime($max = 'now', $timezone = null),
        'shift_from' => '9',
        'shift_to' => '5',
        'image'=> $faker->imageUrl(640, 840, 'cats', true, 'Faker', true),
        'city_id' => function(){
            return \App\Models\Dashboard\City::all()->random();
        },
        'office_id' => function(){
            return \App\Models\Dashboard\Office::all()->random();
        },
        'department_id' => function(){
            return \App\Models\Dashboard\Department::all()->random();
        },
        'position' => 'Admin',
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});
