<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Site\Order::class, function (Faker $faker) {
    return [
        'description' => $faker->name,
        'notes' => $faker->name,
        'cod' => $faker->numberBetween($min = 100, $max = 20000),
        'security_number' => $faker->randomNumber($nbDigits = 8),
        'receiver_name' => $faker->name,
        'address' => $faker->address,
        'mark_place' => $faker->address,
        'mobile' => $faker->randomNumber($nbDigits = 8),
        'tracking_number' => $faker->randomNumber($nbDigits = 8).\Carbon\Carbon::now()->timestamp,
        'user_id' => function(){
            return \App\User::all()->random();
        },
        'city_id' => function(){
            return \App\Models\Dashboard\City::all()->random();
        },
        'office_id' => function(){
            return \App\Models\Dashboard\Office::all()->random();
        },
        'area_id' => function(){
            return \App\Models\Dashboard\Area::all()->random();
        }

    ];
});
