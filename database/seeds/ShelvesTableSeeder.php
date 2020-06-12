<?php

use App\models\Shelf;
use Illuminate\Database\Seeder;

class ShelvesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Shelf::class,50)->create();
    }
}
