<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Dealer;
use Faker\Generator as Faker;

$factory->define(Dealer::class, function (Faker $faker) {
    $startdate = $faker->date($format = 'Y-m-d', $max = 'now');
    return [
        'name'       => $faker->citySuffix,
        'admin_id'   =>  rand(1,10),
        'status'     => 'ENABLE',
        'startdate'  => $startdate,
        'enddate'    => $faker->date($format = 'Y-m-d', $max = $startdate),
    ];
});
