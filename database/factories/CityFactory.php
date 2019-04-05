<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Dashboard\City::class, function (Faker $faker) {
    return [
        //
        'name' =>$faker->unique()->city,
        'status' => 'hide',
    ];
});
