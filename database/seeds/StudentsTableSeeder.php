<?php

use Illuminate\Database\Seeder;
use App\Student;
use App\Guardian;
use Carbon\Carbon;





class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $guardian = Guardian::where('user_name', 'johnflomokue')->first();

        if(DB::table('students')->get()->count() == 0){

        	// first student
            $student_one = new Student();
            $student_one->first_name = 'Blama';
            $student_one->middle_name = 'Kollie';
            $student_one->surname = 'Doe';
            $student_one->date_of_birth = Carbon::parse('1997-02-04')->format('d/m/Y');
            $student_one->gender = 'Male';
            $student_one->address = 'Kpelle Town';
            $student_one->phone = '0770800800';
            $student_one->county = 'Bong';
            $student_one->country = 'Liberia';
            $student_one->religion = 'Christian';
            $student_one->last_school = 'Prime School System';
            $student_one->last_school_address = 'Elwa Junction';
            $student_one->principal_name = 'Morris Kollie';
            $student_one->principal_number = '0886532565';
            $student_one->father_name = "Eugene Nagbe";
            $student_one->father_address = "Kpelle Town";
            $student_one->father_number = "0886800800";
            $student_one->mother_name = "Mary Nagbe";
            $student_one->mother_address = "Kpelle Town";
            $student_one->mother_number = "0886900800";
            $student_one->guardian_id = $guardian->id;
            $student_one->admission_date = Carbon::parse('2016-08-08')->format('d/m/Y');
            $student_one->save();

            // get the student_one id and generate a unique code for the student_one
	        $student_one->student_code = str_pad($student_one->id, 4, '0', STR_PAD_LEFT);
	        // and then save again
        	$student_one->save();

        	// second student
        	$student_two = new Student();
            $student_two->first_name = 'Konah';
            $student_two->middle_name = 'Kema';
            $student_two->surname = 'Doe';
            $student_two->date_of_birth =  Carbon::parse('1998-02-04')->format('d/m/Y');
            $student_two->gender = 'Female';
            $student_two->address = 'Bassa Town';
            $student_two->phone = '0770900900';
            $student_two->county = 'Grand Bassa';
            $student_two->country = 'Liberia';
            $student_two->religion = 'Christian';
            $student_two->last_school = 'Paynesville Community School';
            $student_two->last_school_address = 'Elwa Junction';
            $student_two->principal_name = 'Nancy Roberts';
            $student_two->principal_number = '0776532565';
            $student_two->father_name = "Oratio Doe";
            $student_two->father_address = "Bass Town";
            $student_two->father_number = "088100800";
            $student_two->mother_name = "Esther Doe";
            $student_two->mother_address = "Bassa Town";
            $student_two->mother_number = "0886700800";
            $student_two->guardian_id = $guardian->id;
            $student_two->admission_date = Carbon::parse('2017-08-08')->format('d/m/Y');
            $student_two->save();

            // get the student_two id and generate a unique code for the student_two
	        $student_two->student_code = str_pad($student_two->id, 4, '0', STR_PAD_LEFT);
	        // and then save again
        	$student_two->save();


        	// third student
        	$student_three = new Student();
            $student_three->first_name = 'Sundaygar';
            $student_three->middle_name = 'James';
            $student_three->surname = 'Gbehzongar';
            $student_three->date_of_birth = Carbon::parse('1998-02-04')->format('d/m/Y');
            $student_three->gender = 'Male';
            $student_three->address = 'Bassa Town';
            $student_three->phone = '0770600600';
            $student_three->county = 'Grand Bassa';
            $student_three->country = 'Liberia';
            $student_three->religion = 'Christian';
            $student_three->last_school = 'Paynesville Community School';
            $student_three->last_school_address = 'Elwa Junction';
            $student_three->principal_name = 'Nancy Roberts';
            $student_three->principal_number = '0776532565';
            $student_three->father_name = "Matthew Gbehzongar";
            $student_three->father_address = "Bass Town";
            $student_three->father_number = "088300800";
            $student_three->mother_name = "Patience Kollie";
            $student_three->mother_address = "Kpelle Town";
            $student_three->mother_number = "0886400800";
            $student_three->guardian_id = $guardian->id;
            $student_three->admission_date = Carbon::parse('2016-08-08')->format('d/m/Y');
            $student_three->save();

            // get the student_three id and generate a unique code for the student_three
	        $student_three->student_code = str_pad($student_three->id, 4, '0', STR_PAD_LEFT);
	        // and then save again
        	$student_three->save();

        } else { echo "\e[31students table is not empty, therefore not seeding "; }
    }
}
