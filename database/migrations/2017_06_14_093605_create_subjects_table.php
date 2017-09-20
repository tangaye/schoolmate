<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        /**
        * a subject is taught within a single class/grade (12th grade)
        * or within multiple classes (11th grade, 12th grade, 4th grade)
        **/
        Schema::create('grade_subject', function (Blueprint $table) {
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('grade_id');
            $table->primary(['subject_id', 'grade_id']);

            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('grade_id')
                ->references('id')
                ->on('grades')
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
        Schema::dropIfExists('grade_subject');
        Schema::dropIfExists('subjects');
    }
}
