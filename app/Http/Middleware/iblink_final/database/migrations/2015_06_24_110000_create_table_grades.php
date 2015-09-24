<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGrades extends Migration {

    public function up() {

        Schema::create('grades', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('student_id')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->date('date');
            $table->integer('grade')->nullable();
            $table->enum('grade_type', ['test', 'oral', 'exam'])->nullable();
            $table->boolean('absent');

            //$table->unique(['student_id', 'class_id', 'date']);

            $table->foreign('class_id')
                  ->references('id')
                  ->on('subject_teacher_group')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('student_id')
                  ->references('id')
                  ->on('students')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        DB::update('ALTER TABLE `grades` ADD UNIQUE `grade_idx`(`student_id`, `class_id`, `date`);');

    }

    public function down() {
        Schema::drop('grades');
    }

}
