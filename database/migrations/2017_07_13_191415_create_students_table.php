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
            $table->string('last_school')->nullable();
            $table->string('last_school_address')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('principal_number')->nullable();
            $table->string('father_name');
            $table->string('father_address');
            $table->string('father_number');
            $table->string('mother_name');
            $table->string('mother_address');
            $table->string('mother_number');
            $table->string('photo')->nullable();
            $table->integer('guardian_id')->unsigned()->nullable();
            $table->date('admission_date');
            $table->timestamps();


            // when a guardian is deleted this relation should be set to null
            $table->foreign('guardian_id')
              ->references('id')
              ->on('guardians')
              ->onDelete('set null')
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
