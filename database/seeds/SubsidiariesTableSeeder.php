<?php

use App\models\Subsidiary;
use Illuminate\Database\Seeder;

class SubsidiariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Subsidiary::class,5)->create();
    }
}
