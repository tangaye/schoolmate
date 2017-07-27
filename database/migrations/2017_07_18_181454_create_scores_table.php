<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned()->nullable();
            $table->integer('subject_id')->unsigned()->nullable();
            $table->integer('grade_id')->unsigned()->nullable();
            $table->integer('term_id')->unsigned()->nullable();
            $table->double('score')->unsigned()->nullable();
            $table->timestamps();

            $table->unique(array('student_id', 'subject_id', 'term_id'));

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

            $table->foreign('term_id')
              ->references('id')
              ->on('terms')
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
        Schema::dropIfExists('scores');
    }
}
