<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionsTable extends Migration {

    public function up() {
        Schema::create('institutions', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->integer('institutionable_id')->unsigned();
            $table->string('institutionable_type');

            $table->string('name');
            $table->string('sirues');
            $table->string('cycle');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('image');
            $table->text('description');

            $table->integer('city_id')->unsigned();

            $table->foreign('city_id')
                  ->references('id')
                  ->on('cities')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('institutions');
    }

}
