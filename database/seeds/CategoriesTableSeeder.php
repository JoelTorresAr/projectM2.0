<?php

use App\models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name'     => 'Embutidos',
        ]);
        Category::create([
            'name'     => 'Lacteos',
        ]);
        Category::create([
            'name'     => 'Licores',
        ]);
        Category::create([
            'name'     => 'Carnes',
        ]);
    }
}
