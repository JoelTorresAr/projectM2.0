<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Workstation;
use Faker\Generator as Faker;

$factory->define(Workstation::class, function (Faker $faker) {
    return [
            'name' => $faker->jobTitle
    ];
});
