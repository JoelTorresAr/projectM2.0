<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Provider;
use Faker\Generator as Faker;

$factory->define(Provider::class, function (Faker $faker) {
    return [
            'name'        => $faker->unique()->citySuffix,
            'district_id' => rand(1,15),           
            'address'     => $faker->streetAddress,
            'address2'    => $faker->secondaryAddress,
            'ruc'         => rand(10000000000,99999999999),
            'phone1'      => $faker->phoneNumber,
            'phone2'      => $faker->phoneNumber,
    ];
});
