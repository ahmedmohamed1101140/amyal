<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Dashboard\Area::class, function (Faker $faker) {
    return [
        //
        'name' =>$faker->unique()->city,
        'city_id' => function(){
            return \App\Models\Dashboard\City::all()->random();
        }

    ];
});
