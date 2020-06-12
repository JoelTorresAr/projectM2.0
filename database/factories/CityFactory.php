<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\City;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->city,
    ];
});
