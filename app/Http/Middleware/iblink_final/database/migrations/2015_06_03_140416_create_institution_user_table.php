<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionUserTable extends Migration {

    public function up() {
        Schema::create('institution_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('institution_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('institution_id')
                  ->references('id')
                  ->on('institutions')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('institution_user');
    }
}
