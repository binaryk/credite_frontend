<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration {

    public function up() {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
        });
    }

    public function down() {
        Schema::drop('schools');
    }
}
