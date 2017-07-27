<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_code', 20)->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('surname');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('county')->nullable();
            $table->string('country');
            $table->string('religion')->nullable();
            $table->string('student_type');
            $table->string('last_school')->nullable();
            $table->integer('last_grade')->unsigned()->nullable();
            $table->integer('grade_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('grade_id')
              ->references('id')
              ->on('grades')
              ->onDelete('restrict')
              ->onUpdate('cascade');

            $table->foreign('last_grade')
              ->references('id')
              ->on('grades')
              ->onDelete('restrict')
              ->onUpdate('cascade');

            $table->index('student_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
