<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->bigIncrements('id_program');
            $table->string('program_name');
            $table->string('modality');
            $table->string('status');
            $table->timestamps();
            $table->unsignedBigInteger('fk_faculty');
            $table->unsignedBigInteger('fk_campus');
            $table->foreign('fk_faculty')->references('id_faculty')->on('faculties');
            $table->foreign('fk_campus')->references('id')->on('campuses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
