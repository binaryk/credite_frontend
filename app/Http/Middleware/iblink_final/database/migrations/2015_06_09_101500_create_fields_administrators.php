<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsAdministrators extends Migration {

    public function up() {
        Schema::table('administrators', function (Blueprint $table) {
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('cnp');
            $table->string('image')->nullable();
        });
    }

    public function down() {
        Schema::table('administrators', function (Blueprint $table) {
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('cnp');
            $table->dropColumn('image');
        });
    }

}
