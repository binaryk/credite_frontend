<?php

use App\Models\Student;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroupStudents extends Migration {

    public function up() {

        Schema::create('group_student', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('group_id')->unsigned();
            $table->integer('student_id')->unsigned()->nullable();

            $table->foreign('group_id')
                  ->references('id')
                  ->on('groups')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('student_id')
                  ->references('id')
                  ->on('students')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });

        foreach (Student::all() as $student) {
            DB::table('group_student')->insert([
                'student_id' => $student->id,
                'group_id'   => $student->group_id
            ]);
        }

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign('students_group_id_foreign');
            $table->dropColumn('group_id');
        });
    }

    public function down() {

        Schema::drop('group_student');

        Schema::table('students', function (Blueprint $table) {
            $table->integer('group_id')->unsigned()->nullable();
            $table->foreign('group_id')
                  ->references('id')
                  ->on('groups')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

    }
}
