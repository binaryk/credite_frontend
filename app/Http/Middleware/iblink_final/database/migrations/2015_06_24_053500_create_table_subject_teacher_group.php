<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubjectTeacherGroup extends Migration {

    public function up() {

        Schema::create('subject_teacher_group', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->integer('subject_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();

            $table->foreign('subject_id')
                  ->references('id')
                  ->on('subjects')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('group_id')
                  ->references('id')
                  ->on('groups')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    public function down() {
        Schema::drop('subject_teacher_group');
    }

}
