<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Site\ClientRequest::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->unique()->phoneNumber,
        'city_id' => $faker->numberBetween(1,2)
    ];
});
