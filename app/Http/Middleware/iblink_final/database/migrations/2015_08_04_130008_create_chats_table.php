<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chats', function(Blueprint $t)
		{
			$t->increments('id');
			$t->softdeletes();
			$t->timestamps();
			$t->integer('send_by');
			$t->integer('send_to');
			$t->tinyinteger('read');
			$t->tinyinteger('seen');
			$t->text('message');
			$t->datetime('send_at_time');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chats');
	}

}
