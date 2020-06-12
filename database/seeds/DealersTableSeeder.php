<?php

use App\models\Dealer;
use Illuminate\Database\Seeder;

class DealersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Dealer::class,10)->create();
    }
}
