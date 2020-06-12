<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Workposition;
use Faker\Generator as Faker;

$factory->define(Workposition::class, function (Faker $faker) {
    return [
             'workstation_id' => rand(1,5),
             'name'        => $faker->jobTitle
    ];
});
