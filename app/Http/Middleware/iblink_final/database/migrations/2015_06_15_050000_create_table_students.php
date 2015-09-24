<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStudents extends Migration {

    public function up() {
        Schema::create('students', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('group_id')->unsigned()->nullable();

            $table->string('lastname')->nullable(); // nume
            $table->string('firstname')->nullable(); // prenume
            $table->date('dob')->nullable(); // data de nastere (date of birth)

            $table->string('parents_initials')->nullable(); // initialele tatalui/mamei
            $table->string('gender')->nullable(); // m sau f
            $table->string('cnp')->nullable();

            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('nationality')->nullable();
            $table->string('language')->nullable();

            $table->integer('county_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();

            $table->integer('address_country_id')->unsigned()->nullable();
            $table->integer('address_county_id')->unsigned()->nullable();

            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();

            $table->string('secondary_emergency_name')->nullable();
            $table->string('secondary_emergency_phone')->nullable();

            $table->string('image')->nullable();

            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('county_id')
                  ->references('id')
                  ->on('cities')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('city_id')
                  ->references('id')
                  ->on('cities')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('group_id')
                  ->references('id')
                  ->on('groups')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('address_country_id')
                  ->references('id')
                  ->on('countries')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('address_county_id')
                  ->references('id')
                  ->on('cities')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('students');
    }

}
