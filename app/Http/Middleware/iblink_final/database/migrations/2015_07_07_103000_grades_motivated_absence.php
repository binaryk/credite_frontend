<?php

use App\Models\Student;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GradesMotivatedAbsence extends Migration {

    public function up() {
        Schema::table('grades', function (Blueprint $table) {
            $table->tinyInteger('motivated')->nullable();
        });
    }

    public function down() {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('motivated');
        });
    }
}
