<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterTableSubjectsAddCol extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('subjects', function (Blueprint $table) {
			$table->integer('teacher_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('subjects', function (Blueprint $table) {
			$table->dropcolum('teacher_id');
		});
	}

}
