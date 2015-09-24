<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCountiesCities extends Migration {

    public function up() {

        Schema::create('counties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 2)->index();
            $table->string('name');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('county_id')->unsigned();
            $table->string('name');
            $table->foreign('county_id')
                  ->references('id')
                  ->on('counties')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

    }

    public function down() {
        Schema::drop('cities');
        Schema::drop('counties');
    }

}
