<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_program', function (Blueprint $table) {
            $table->bigIncrements('id_user_program');
            $table->unsignedBigInteger('fk_program');
            $table->unsignedBigInteger('fk_user');

            $table->foreign('fk_program')->references('id_program')->on('programs');
            $table->foreign('fk_user')->references('id')->on('users');
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
        Schema::dropIfExists('user_program');
    }
}
