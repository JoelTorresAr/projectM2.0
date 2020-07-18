<?php

use App\models\Offer;
use Illuminate\Database\Seeder;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Offer::create([
            'name'     => 'Embutidos 2x1',
            'discount' => 50,
            'offerable_id'   => rand(1, 10),
            'offerable_type' => App\Dealer::class, 
            'active'   => true,
        ]);
        Offer::create([
            'name'     => '15% de descuento en vinos',
            'discount' => 15,
            'offerable_id'   => rand(1, 10),
            'offerable_type' => App\Dealer::class, 
            'active'   => true,
        ]);
    }
}
