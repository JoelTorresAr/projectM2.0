<?php

use App\models\Igv;
use Illuminate\Database\Seeder;

class IgvsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Igv::create([
            'mount'     => 15.4,
        ]);
        Igv::create([
            'mount'     => 06.04,
        ]);
        Igv::create([
            'mount'     => 12.04,
        ]);
    }
}
