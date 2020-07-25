<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //Master
       User::create([
        'name' => 'Joel Torres',
        'email' => 'djoel_torres@hotmail.com',
        'password' => '$2y$04$sJbJqpv7TH5RrgTPq0raburfQ6g1XOQtgd59Dgz.VCGlr8f5gUvm6', //secret
    ]);
    }
}
