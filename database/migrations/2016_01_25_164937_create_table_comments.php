<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('front_comments', function(Blueprint $t){
           $t->bigIncrements('id');
           $t->string('author');
           $t->string('email');
           $t->text('title');
           $t->text('message');
           $t->integer('order');
           $t->tinyInteger('valid');
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
        Schema::drop('front_comments');
    }
}
