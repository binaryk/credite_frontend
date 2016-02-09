<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'front_languages', function(Blueprint $table){
		    $table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->integer('position')->nullable();
			$table->string('name', 50)->unique();
			$table->string('lang_code', 10)->unique();
			$table->string('icon', 255)->nullable();
			$table->unsignedInteger('user_id')->nullable();
			$table->foreign('user_id')->references('id')->on('front_users')->onDelete('set null');
			$table->unsignedInteger('user_id_edited')->nullable();
			$table->foreign('user_id_edited')->references('id')->on('front_users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
		}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('front_languages');
	}

}
