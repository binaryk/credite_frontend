<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function(Blueprint $t){
            $t->increments('id');
            $t->integer('user_id');
            $t->text('email', 20);
            $t->text('name', 20);
            $t->text('phone', 20);
            $t->text('flight_nr', 20);
            $t->text('coming_from', 20);
            $t->text('resident_phone', 20);
            $t->text('from', 20);
            $t->text('from_nr', 20);
            $t->text('to', 20);
            $t->text('to_nr', 20);
            $t->text('to_street', 20);
            $t->date('up_date');
            $t->text('nr_passegers', 20);
            $t->text('nr_luggages', 20);
            $t->text('nr_hand_luggages', 20);
            $t->text('details', 50);
            $t->boolean('meet_and_greet')->default(false);
            $t->boolean('return_50')->default(false);
            $t->boolean('pay_cash')->default(false);
            $t->softdeletes();
            $t->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
