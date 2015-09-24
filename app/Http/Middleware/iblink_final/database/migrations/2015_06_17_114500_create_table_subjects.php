<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubjects extends Migration {

    public function up() {
        Schema::create('subjects', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->string('name')->nullable();

            $table->enum('type', ['mandatory', 'facultative', 'optional'])->default('mandatory');
            $table->enum('grading_system', ['grades', 'qualificatives'])->default('grades');

            $table->integer('institution_id')->unsigned();

            $table->foreign('institution_id')
                  ->references('id')
                  ->on('institutions')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('subjects');
    }

}
