<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('salable_id')->unsigned();
            $table->string('salable_type');
            $table->string('dni')->nullable();
            $table->foreignId('igv_id')->constrained();
            $table->foreignId('prooftype_id')->constrained();
            $table->enum('paytype',['CASH','CARD'])->default('CASH');
            $table->decimal('totalpay',18,2);
            $table->timestamps();
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
        Schema::dropIfExists('sales');
        Schema::enableForeignKeyConstraints();
    }
}
