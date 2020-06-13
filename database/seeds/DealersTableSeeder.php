<?php

use App\Dealer as AppDealer;
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
        //Dealer
        AppDealer::create([
            'name' => 'Dealer Torres',
            'email' => 'dealer@hotmail.com',
            'password' => '$2y$04$sJbJqpv7TH5RrgTPq0raburfQ6g1XOQtgd59Dgz.VCGlr8f5gUvm6',
            'remember_token' => Str::random(10),
            'active'         => true,
        ]);

        factory(AppDealer::class,10)->create();
    }
}
