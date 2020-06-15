<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('shelf_id')->constrained();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->integer('articlable_id')->unsigned();
            $table->string('articlable_type');
            $table->string('name');
            $table->decimal('purchaseprice',18,2);
            $table->decimal('saleprice',18,2);
            $table->text('description');
            $table->string('file',128)->nullable();
            $table->timestamps();

            $table->foreign('provider_id')->references('id')->on('providers')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('articles');
        Schema::enableForeignKeyConstraints();
    }
}
