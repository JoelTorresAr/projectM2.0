<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subsidiary_id')->constrained();
            $table->foreignId('workposition_id')->constrained();
            $table->foreignId('district_id')->constrained();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('address');
            $table->string('address2')->nullable();
            $table->string('name');
            $table->string('lastname');
            $table->string('phone');
            $table->string('email');
            $table->date('birthday');
            $table->enum('status',['activo','inactivo'])->default('activo');
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('staff');
        Schema::enableForeignKeyConstraints();
    }
}
