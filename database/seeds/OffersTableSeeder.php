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
            'active'   => true,
        ]);
        Offer::create([
            'name'     => '15% de descuento en vinos',
            'discount' => 15,
            'active'   => true,
        ]);
    }
}
