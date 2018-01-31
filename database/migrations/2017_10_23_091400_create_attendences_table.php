<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('grade_id');
            $table->date('date');
            $table->string('status');
            $table->string('remarks')->nullable();
            $table->unsignedInteger('academic_id');
            $table->timestamps();

            $table->unique(array('student_id', 'subject_id', 'date', 'academic_id'));

            $table->foreign('student_id')
              ->references('id')
              ->on('students')
              ->onDelete('restrict')
              ->onUpdate('cascade');

            $table->foreign('grade_id')
              ->references('id')
              ->on('grades')
              ->onDelete('restrict')
              ->onUpdate('cascade');

            $table->foreign('subject_id')
              ->references('id')
              ->on('subjects')
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
        Schema::dropIfExists('attendences');
    }
}
