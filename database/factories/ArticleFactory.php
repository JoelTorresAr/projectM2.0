<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    $purchaseprice = $faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 300);
    $articlabe = [App\Dealer::class,App\Admin::class];
    return [
        'category_id'    => rand(1, 4),
        'shelf_id'       => rand(1, 50),
        'provider_id'    => rand(1, 5),
        'offer_id'       => rand(1, 2),
        'articlable_id'   => rand(1, 10),
        'articlable_type' => $faker->randomElement($articlabe), 
        'name'           => $faker->word(),
        'purchaseprice'  => $purchaseprice,
        'saleprice'      => $faker->randomFloat(2, $purchaseprice, $purchaseprice + 5),
        'description'    => $faker->text($maxNbChars = 100),
    ];
});
