<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Dashboard\Department::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->unique()->word,

    ];
});
