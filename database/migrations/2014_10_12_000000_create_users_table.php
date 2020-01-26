<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('lastname')->nullable();
            $table->string('student_code');
            $table->string('city_residence')->nullable();
            $table->string('hometown')->nullable();
            $table->string('nationality')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('slug')->unique();
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('fk_role')->nullable();
            $table->unsignedBigInteger('fk_program1')->nullable();
            $table->unsignedBigInteger('fk_program2')->nullable();

            $table->foreign('fk_role')->references('id_role')->on('roles')->onDelete('set null');
            $table->foreign('fk_program1')->references('id_program')->on('programs')->onDelete('set null');
            $table->foreign('fk_program2')->references('id_program')->on('programs')->onDelete('set null');
            
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
        Schema::dropIfExists('users');
    }
}
