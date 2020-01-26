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
            $table->unsignedBigInteger('fk_faculty')->nullable();
            $table->unsignedBigInteger('fk_campus')->nullable();
            $table->foreign('fk_faculty')->references('id_faculty')->on('faculties')->onDelete('set null');
            $table->foreign('fk_campus')->references('id')->on('campuses')->onDelete('set null');
            
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
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
