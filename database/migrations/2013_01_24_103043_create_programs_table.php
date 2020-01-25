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
            $table->bigIncrements('id');
            $table->string('program_name');
            $table->string('duration');
            $table->date('start-date');
            $table->string('modality');
            $table->string('schedule');
            $table->string('status');
            $table->timestamps();
            $table->unsignedBigInteger('faculty_id');
            $table->unsignedBigInteger('campus_id');
            $table->foreign('faculty_id')->references('id')->on('faculties');
            $table->foreign('campus_id')->references('id')->on('campuses');

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
