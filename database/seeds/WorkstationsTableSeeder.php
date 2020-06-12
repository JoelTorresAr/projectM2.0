<?php

use App\models\Workstation;
use Illuminate\Database\Seeder;

class WorkstationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Workstation::class,5)->create();
    }
}
