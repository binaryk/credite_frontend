<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKindergartensTable extends Migration {

    public function up() {
        Schema::create('kindergartens', function (Blueprint $table) {
            $table->increments('id');
        });
    }

    public function down() {
        Schema::drop('kindergartens');
    }
}
