<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSuperAdministrators extends Migration {

    public function up() {
        Schema::create('super_administrators', function (Blueprint $table) {
            $table->increments('id');
        });
    }

    public function down() {
        Schema::drop('super_administrators');
    }

}
