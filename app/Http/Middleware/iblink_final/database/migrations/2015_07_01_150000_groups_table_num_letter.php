<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupsTableNumLetter extends Migration {

    public function up() {
        Schema::table('groups', function (Blueprint $table) {
            $table->integer('num');
            $table->string('letter');
        });
    }

    public function down() {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('num');
            $table->dropColumn('letter');
        });
    }

}
