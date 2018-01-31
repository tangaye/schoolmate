<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_sponsors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('academic_id');
            $table->timestamps();

            $table->unique(array('teacher_id', 'grade_id', 'academic_id'));

            $table->foreign('teacher_id')
              ->references('id')
              ->on('teachers')
              ->onDelete('restrict')
              ->onUpdate('cascade');

            $table->foreign('grade_id')
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
        Schema::dropIfExists('grade_sponsors');
    }
}
