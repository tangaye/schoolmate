<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('last_grade');
            $table->unsignedInteger('current_grade');
            $table->string('student_type');
            $table->string('enrollment_status');
            $table->integer('academic_id')->unsigned()->nullable();
            $table->timestamps();

            $table->unique(array('student_id', 'academic_id'));

            $table->foreign('student_id')
              ->references('id')
              ->on('students')
              ->onDelete('restrict')
              ->onUpdate('cascade');

            $table->foreign('current_grade')
              ->references('id')
              ->on('grades')
              ->onDelete('restrict')
              ->onUpdate('cascade');

            $table->foreign('last_grade')
              ->references('id')
              ->on('grades')
              ->onDelete('restrict')
              ->onUpdate('cascade');

            $table->foreign('academic_id')
              ->references('id')
              ->on('academics')
              ->onDelete('restrict')
              ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
}
