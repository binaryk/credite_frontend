<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdministrators extends Migration {

    public function up() {
        Schema::create('administrators', function (Blueprint $table) {
            $table->increments('id');
        });
    }

    public function down() {
        Schema::drop('administrators');
    }

}
