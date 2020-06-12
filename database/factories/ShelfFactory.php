<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Shelf;
use Faker\Generator as Faker;

$factory->define(Shelf::class, function (Faker $faker) {
    // Available alpha caracters
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    // generate a pin based on 2 * 7 digits + a random character
    $pin = $characters[rand(0, strlen($characters) - 1)]
           .mt_rand(1, 30);
    return [
        'name'          => $pin,
        'subsidiary_id' => rand(1,5),
        'rentalstatus'  => 'DISABLE',
    ];
});
