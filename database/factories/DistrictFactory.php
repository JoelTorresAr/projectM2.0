<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\District;
use Faker\Generator as Faker;

$factory->define(District::class, function (Faker $faker) {
    return [
        'city_id'  =>  rand(1,5),
        'name'     => $faker->unique()->state        
    ];
});
