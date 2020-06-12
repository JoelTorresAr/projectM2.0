<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Subsidiary;
use Faker\Generator as Faker;

$factory->define(Subsidiary::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->citySuffix
    ];
});
