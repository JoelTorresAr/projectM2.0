<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShelvesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shelves', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('subsidiary_id')->constrained();
            $table->enum('rentalstatus',['ENABLE','DISABLE'])->default('DISABLE');
            $table->unsignedBigInteger('dealer_id')->nullable();
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
        Schema::dropIfExists('shelves');
        Schema::enableForeignKeyConstraints();
    }
}
