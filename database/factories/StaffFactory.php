<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Staff;
use Faker\Generator as Faker;

$factory->define(Staff::class, function (Faker $faker) {
    $lastName = $faker->lastName . " " .$faker->lastName;
    return [
            'admin_id'        => $faker->unique()->numberBetween(1,15),
            'subsidiary_id'   => rand(1,5),
            'workposition_id' => rand(1,5),
            'district_id'     => rand(1,15),            
            'address'         => $faker->streetAddress,
            'address2'        => $faker->secondaryAddress,
            'name'            => $faker->firstName,
            'lastname'        => $lastName,
            'phone'           => $faker->phoneNumber,
            'email'           => $faker->email,
            'birthday'        => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});
