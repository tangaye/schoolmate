<?php

use Illuminate\Database\Seeder;
use App\Student;
use App\Grade;
use App\Enrollment;
use App\Academic;


class EnrollmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grade_six = Grade::where('name', '6th Grade')->first();
        $grade_seven = Grade::where('name', '7th Grade')->first();
        $grade_eight = Grade::where('name', '8th Grade')->first();
        $grade_nine = Grade::where('name', '9th Grade')->first();
        $grade_ten = Grade::where('name', '10th Grade')->first();
        $grade_twelve = Grade::where('name', '12th Grade')->first();
        $grade_eleven = Grade::where('name', '11th Grade')->first();

        $past_academic_three = Academic::where([
            ['year_start', 2014],
            ['year_end', 2015]
        ])->first();

        $past_academic_two = Academic::where([
            ['year_start', 2015],
            ['year_end', 2016]
        ])->first();

        $past_academic = Academic::where([
            ['year_start', 2016],
            ['year_end', 2017]
        ])->first();

        $current_academic = Academic::where('status', 1)->first();

        $student_one = Student::where('id', 1)->first();
        // had to select the student this way because of heroku.
        // Heroku's cleardb doesn't increment normally as mysql does
        $student_two = Student::where('phone', 'like', '%0770900900%')->first();
        $student_three = Student::where('phone', 'like', '%0770600600%')->first();

        if(DB::table('enrollments')->get()->count() == 0){

        	// first student enrollment
            $enrollment_one = new Enrollment();
            $enrollment_one->student_id = $student_one->id;
            $enrollment_one->last_grade = $grade_ten->id;
            $enrollment_one->current_grade = $grade_eleven->id;
            $enrollment_one->student_type = 'Old Student';
            $enrollment_one->enrollment_status = 'Enrolled';
            $enrollment_one->academic_id = $current_academic->id;
            $enrollment_one->save();

        	// second student enrollment
        	$enrollment_two = new Enrollment();
            $enrollment_two->student_id = $student_two->id;
            $enrollment_two->last_grade = $grade_ten->id;
            $enrollment_two->current_grade = $grade_eleven->id;
            $enrollment_two->student_type = 'Old Student';
            $enrollment_two->enrollment_status = 'Enrolled';
            $enrollment_two->academic_id = $current_academic->id;
            $enrollment_two->save();


        	// third student enrollment
        	$enrollment_three = new Enrollment();
            $enrollment_three->student_id = $student_three->id;
            $enrollment_three->last_grade = $grade_eleven->id;
            $enrollment_three->current_grade = $grade_twelve->id;
            $enrollment_three->student_type = 'Old Student';
            $enrollment_three->enrollment_status = 'Pending';
            $enrollment_three->academic_id = $current_academic->id;
            $enrollment_three->save();


            /*
            --------------------------------------------------------------
            **************PAST REGISTRATION 2016 - 2017********************
            --------------------------------------------------------------
            */

            // first student past enrollment
            $enrollment_four = new Enrollment();
            $enrollment_four->student_id = $student_one->id;
            $enrollment_four->last_grade = $grade_nine->id;
            $enrollment_four->current_grade = $grade_ten->id;
            $enrollment_four->student_type = 'Old Student';
            $enrollment_four->enrollment_status = 'Enrolled';
            $enrollment_four->academic_id = $past_academic->id;
            $enrollment_four->save();

            // second student enrollment
            $enrollment_two = new Enrollment();
            $enrollment_two->student_id = $student_two->id;
            $enrollment_two->last_grade = $grade_nine->id;
            $enrollment_two->current_grade = $grade_ten->id;
            $enrollment_two->student_type = 'Old Student';
            $enrollment_two->enrollment_status = 'Enrolled';
            $enrollment_two->academic_id = $past_academic->id;
            $enrollment_two->save();


        	// third student enrollment
        	$enrollment_six = new Enrollment();
            $enrollment_six->student_id = $student_three->id;
            $enrollment_six->last_grade = $grade_ten->id;
            $enrollment_six->current_grade = $grade_eleven->id;
            $enrollment_six->student_type = 'Old Student';
            $enrollment_six->enrollment_status = 'Enrolled';
            $enrollment_six->academic_id = $past_academic->id;
            $enrollment_six->save();

            /*
            --------------------------------------------------------------
            *********PAST REGISTRATION two 2015 - 2016********************
            --------------------------------------------------------------
            */

            // first student past enrollment
            $enrollment_four = new Enrollment();
            $enrollment_four->student_id = $student_one->id;
            $enrollment_four->last_grade = $grade_eight->id;
            $enrollment_four->current_grade = $grade_nine->id;
            $enrollment_four->student_type = 'Old Student';
            $enrollment_four->enrollment_status = 'Enrolled';
            $enrollment_four->academic_id = $past_academic_two->id;
            $enrollment_four->save();

            // second student enrollment
            $enrollment_two = new Enrollment();
            $enrollment_two->student_id = $student_two->id;
            $enrollment_two->last_grade = $grade_eight->id;
            $enrollment_two->current_grade = $grade_nine->id;
            $enrollment_two->student_type = 'New Student';
            $enrollment_two->enrollment_status = 'Enrolled';
            $enrollment_two->academic_id = $past_academic_two->id;
            $enrollment_two->save();

            $enrollment_six = new Enrollment();
            $enrollment_six->student_id = $student_three->id;
            $enrollment_six->last_grade = $grade_ten->id;
            $enrollment_six->current_grade = $grade_eleven->id;
            $enrollment_six->student_type = 'New Student';
            $enrollment_six->enrollment_status = 'Dropped';
            $enrollment_six->academic_id = $past_academic_two->id;
            $enrollment_six->save();


            /*
            --------------------------------------------------------------
            *********PAST REGISTRATION three 2014-2015********************
            --------------------------------------------------------------
            */
            // first student past enrollment
            $enrollment_four = new Enrollment();
            $enrollment_four->student_id = $student_one->id;
            $enrollment_four->last_grade = $grade_seven->id;
            $enrollment_four->current_grade = $grade_eight->id;
            $enrollment_four->student_type = 'New Student';
            $enrollment_four->enrollment_status = 'Enrolled';
            $enrollment_four->academic_id = $past_academic_three->id;
            $enrollment_four->save();



        } else { echo "\e[31students table is not empty, therefore not seeding "; }
    }
}
