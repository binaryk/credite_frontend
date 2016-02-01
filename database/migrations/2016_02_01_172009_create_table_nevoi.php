<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNevoi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_nevoi',function(Blueprint $t){
            $t->bigIncrements('id');
            $t->integer('user_id');
            $t->string('name');
            $t->string('email');
            $t->string('phone');
            $t->string('details');
            $t->timestamps();
            $t->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('front_nevoi');
    }
}
