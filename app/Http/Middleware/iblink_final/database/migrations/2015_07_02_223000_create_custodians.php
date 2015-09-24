<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustodians extends Migration {

    public function up() {

        Schema::create('custodians', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone');
            $table->string('image');
        });

        Schema::create('custodian_students', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('custodian_id')->unsigned()->nullable();
            $table->integer('student_id')->unsigned()->nullable();

            $table->foreign('custodian_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->foreign('student_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    public function down() {
        Schema::drop('custodians');
        Schema::drop('custodian_students');
    }

}
