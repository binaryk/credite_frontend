<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersTableRoles extends Migration {

    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('userable_id')->unsigned();
            $table->string('userable_type');
        });
    }

    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('userable_id');
            $table->dropColumn('userable_type');
        });
    }

}
