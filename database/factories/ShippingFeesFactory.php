<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Dashboard\ShippingFees::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return \App\User::all()->random();
        },
        'city_id' => function(){
            return \App\Models\Dashboard\City::all()->random();
        },
        'fees' => $faker->numberBetween($min = 20, $max = 200),
    ];
});
