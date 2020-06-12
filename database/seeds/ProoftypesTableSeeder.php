<?php

use App\models\Prooftype;
use Illuminate\Database\Seeder;

class ProoftypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Prooftype::create([
            'name' => 'Boleta'
        ]);
        Prooftype::create([
            'name' => 'Factura'
        ]);
    }
}
