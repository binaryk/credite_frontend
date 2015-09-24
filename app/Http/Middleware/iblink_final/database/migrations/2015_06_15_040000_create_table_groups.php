<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroups extends Migration {

    public function up() {
        Schema::create('groups', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->string('name')->nullable(); // ex XI C
            $table->integer('master_id')->unsigned()->nullable(); // diriginte
            $table->integer('institution_id')->unsigned(); // scoala

            $table->foreign('master_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->foreign('institution_id')
                  ->references('id')
                  ->on('institutions')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('groups');
    }

}
