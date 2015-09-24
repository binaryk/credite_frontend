<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearsSemesters extends Migration {

    public function up() {

        Schema::create('years', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('semesters', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('year_id')->unsigned()->nullable();
            $table->string('name')->nullable();

            $table->date('start')->nullable();
            $table->date('end')->nullable();

            $table->foreign('year_id')
                  ->references('id')
                  ->on('years')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });

        Schema::table('institutions', function (Blueprint $table) {
            $table->integer('active_semester_id')->unsigned()->nullable();
            $table->foreign('active_semester_id')
                  ->references('id')
                  ->on('semesters')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->integer('year_id')->unsigned()->nullable();
            $table->foreign('year_id')
                  ->references('id')
                  ->on('years')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    public function down() {

        Schema::table('institutions', function (Blueprint $table) {
            $table->dropForeign('institutions_active_semester_id_foreign');
            $table->dropColumn('active_semester_id');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign('groups_year_id_foreign');
            $table->dropColumn('year_id');
        });

        Schema::drop('semesters');
        Schema::drop('years');
    }
}
