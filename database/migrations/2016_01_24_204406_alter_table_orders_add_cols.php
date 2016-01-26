<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableOrdersAddCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function(Blueprint $t){
           $t->datetime('up_date_time')->after('up_date');
        });
        Schema::table('orders', function(Blueprint $t){
           $t->dropColumn('up_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function(Blueprint $t){
            $t->dropColumn('up_date_time');
        });
    }
}
