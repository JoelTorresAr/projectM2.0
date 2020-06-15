<?php

use App\models\Article;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $article = factory(Article::class,400)
                   ->create();
                   /*->each(function($article){
                    $article->offers()->attach(rand(1,2));
                   });*/
    }
}
