<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'district_id' => rand(1,10),
        'address'     => $faker->streetAddress,
        'address2'    => $faker->secondaryAddress
    ];
});
