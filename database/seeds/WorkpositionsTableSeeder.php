<?php

use App\models\Workposition;
use Illuminate\Database\Seeder;

class WorkpositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Workposition::class,5)->create();
    }
}
