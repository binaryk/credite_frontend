<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTeachers extends Migration {

    public function up() {
        Schema::create('teachers', function (Blueprint $table) {

            $table->increments('id');

            $table->string('account_type')->nullable(); // tip cont
            $table->string('position')->nullable(); // functia didactica
            $table->string('studies')->nullable(); // tip studii

            $table->string('lead')->nullable(); // functia de conducere
            $table->string('spec')->nullable(); // specializare

            $table->string('address')->nullable(); // data term. studii

            $table->date('graduated_on')->nullable(); // data term. studii
            $table->string('degree')->nullable(); // grad didactic

            $table->string('last_development_type')->nullable(); // tip ultima perfectionare
            $table->string('foreign_langs')->nullable(); // limbi straine

            $table->string('employment_type')->nullable(); // mod de incadrare
            $table->string('employment_act_no')->nullable(); // nr act incadrare
            $table->date('employment_date')->nullable(); // data incadrare

            $table->string('maiden_name')->nullable(); // nume de familie la nastere
            $table->string('lastname')->nullable(); // nume
            $table->string('firstname')->nullable(); // prenume

            $table->string('cnp')->nullable();
            $table->date('dob')->nullable(); // data de nastere (date of birth)

            $table->integer('country_id')->unsigned()->nullable();
            $table->string('nationality')->nullable();

            $table->string('phone')->nullable();
            $table->string('image')->nullable();

            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('teachers');
    }

}
