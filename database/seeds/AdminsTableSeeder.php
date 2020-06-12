<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Bitfumes\Multiauth\Model\Admin;


class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Master
        Admin::create([
            'name' => 'Joel Torres',
            'email' => 'djoel_torres@hotmail.com',
            'password' => '$2y$04$sJbJqpv7TH5RrgTPq0raburfQ6g1XOQtgd59Dgz.VCGlr8f5gUvm6',
            'description' => 'Persona con total control del sistema',
            'remember_token' => Str::random(10),
            'active'         => true,
        ]);

        Admin::create([
            'name' => 'Luis Sanchéz',
            'email' => 'luis_sanchez@hotmail.com',
            'password' => '$2y$04$sJbJqpv7TH5RrgTPq0raburfQ6g1XOQtgd59Dgz.VCGlr8f5gUvm6',
            'description' => 'Persona con total control del sistema',
            'remember_token' => Str::random(10),
            'active'         => true,
        ]);        
        Admin::create([
            'name' => 'Jose Alonzo',
            'email' => 'jose_alonzo@hotmail.com',
            'password' => '$2y$04$sJbJqpv7TH5RrgTPq0raburfQ6g1XOQtgd59Dgz.VCGlr8f5gUvm6',
            'description' => 'Persona con total control del sistema',
            'remember_token' => Str::random(10),
            'active'         => true,
        ]);        

        //Prueba
        factory(Admin::class,15)->create();
    }
}
