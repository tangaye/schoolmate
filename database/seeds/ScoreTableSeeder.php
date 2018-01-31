<?php

use Illuminate\Database\Seeder;

use App\Term;
use App\Subject;
use App\Student;
use App\Score;
use App\Academic;


class ScoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	$periodOne = Term::where('name', '1st Period')->first();
        $periodTwo = Term::where('name', '2nd Period')->first();
        $periodThere = Term::where('name', '3rd Period')->first();
        $periodFour = Term::where('name', '4th Period')->first();
        
    	$maths = Subject::where('name', 'Mathematics')->first();
    	$biology = Subject::where('name', 'Biology')->first();
    	$physics = Subject::where('name', 'Physics')->first();
    	$geo = Subject::where('name', 'Geography')->first();
        $science = Subject::where('name', 'Science')->first();
        $english = Subject::where('name', 'English')->first();

        $past_academic_20142015 = Academic::where([
            ['year_start', 2014],
            ['year_end', 2015]
        ])->first();

        $past_academic_20152016 = Academic::where([
            ['year_start', 2015],
            ['year_end', 2016]
        ])->first();

        $past_academic = Academic::where([
            ['year_start', 2016],
            ['year_end', 2017]
        ])->first();
        
        $current_academic = Academic::where('status', 1)->first();

        // get enrolled student one for current academic year
        $student1 = Student::where('id', 1)->first();
        $student_one_current = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->select(
                'enrollments.student_id as id',
                'enrollments.current_grade as grade_id'
            )
            ->where('enrollments.student_id', $student1->id)
            ->where('enrollments.enrollment_status', 'Enrolled')
            ->where('enrollments.academic_id', $current_academic->id)
            ->first();

        // get enrolled student one for past academic year
        $student_one_past = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->select(
                'enrollments.student_id as id',
                'enrollments.current_grade as grade_id'
            )
            ->where('enrollments.student_id', $student1->id)
            ->where('enrollments.enrollment_status', 'Enrolled')
            ->where('enrollments.academic_id', $past_academic->id)
            ->first();

        $student_one_20152016 = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->select(
                'enrollments.student_id as id',
                'enrollments.current_grade as grade_id'
            )
            ->where('enrollments.student_id', $student1->id)
            ->where('enrollments.enrollment_status', 'Enrolled')
            ->where('enrollments.academic_id', $past_academic_20152016->id)
            ->first();

        $student_one_20142015 = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->select(
                'enrollments.student_id as id',
                'enrollments.current_grade as grade_id'
            )
            ->where('enrollments.student_id', $student1->id)
            ->where('enrollments.enrollment_status', 'Enrolled')
            ->where('enrollments.academic_id', $past_academic_20142015->id)
            ->first();

        // get enrolled student two for current academic year
        // had to select the student this way because of heroku.
        // Heroku's cleardb doesn't increment normally as mysql does
        $student2 = Student::where('phone', 'like', '%0770900900%')->first();
        $student_two_current = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->select(
                'enrollments.student_id as id',
                'enrollments.current_grade as grade_id'
            )
            ->where('enrollments.student_id', $student2->id)
            ->where('enrollments.enrollment_status', 'Enrolled')
            ->where('enrollments.academic_id', $current_academic->id)
            ->first();
        $student_two_past = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->select(
                'enrollments.student_id as id',
                'enrollments.current_grade as grade_id'
            )
            ->where('enrollments.student_id', $student2->id)
            ->where('enrollments.enrollment_status', 'Enrolled')
            ->where('enrollments.academic_id', $past_academic->id)
            ->first();
        $student_two_20152016 = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->select(
                'enrollments.student_id as id',
                'enrollments.current_grade as grade_id'
            )
            ->where('enrollments.student_id', $student2->id)
            ->where('enrollments.enrollment_status', 'Enrolled')
            ->where('enrollments.academic_id', $past_academic_20152016->id)
            ->first();

        // get enrolled student three for past academic year because in the current academic year student three is not enrolled
        $student3 = Student::where('phone', 'like', '%0770600600%')->first();
        $student_three_past = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->select(
                'enrollments.student_id as id',
                'enrollments.current_grade as grade_id'
            )
            ->where('enrollments.student_id', $student3->id)
            ->where('enrollments.enrollment_status', 'Enrolled')
            ->where('enrollments.academic_id', $past_academic->id)
            ->first();


        

        if(DB::table('scores')->get()->count() == 0){


            /*
            --------------------------------------------------------------
            **********CURRENT ACADEMIC SCORES 2017-2018*******************
            --------------------------------------------------------------
            */

            // student one scores
            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_current->id;
            $st_one_scores->grade_id = $student_one_current->grade_id;
            $st_one_scores->subject_id = $maths->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 90;
            $st_one_scores->academic_id = $current_academic->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_current->id;
            $st_one_scores->grade_id = $student_one_current->grade_id;
            $st_one_scores->subject_id = $maths->id;
            $st_one_scores->term_id = $periodFour->id;
            $st_one_scores->score = 65;
            $st_one_scores->academic_id = $current_academic->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_current->id;
            $st_one_scores->grade_id = $student_one_current->grade_id;
            $st_one_scores->subject_id = $biology->id;
            $st_one_scores->term_id = $periodThere->id;
            $st_one_scores->score = 80;
            $st_one_scores->academic_id = $current_academic->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_current->id;
            $st_one_scores->grade_id = $student_one_current->grade_id;
            $st_one_scores->subject_id = $geo->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 77;
            $st_one_scores->academic_id = $current_academic->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_current->id;
            $st_one_scores->grade_id = $student_one_current->grade_id;
            $st_one_scores->subject_id = $physics->id;
            $st_one_scores->term_id = $periodFour->id;
            $st_one_scores->score = 87;
            $st_one_scores->academic_id = $current_academic->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_current->id;
            $st_one_scores->grade_id = $student_one_current->grade_id;
            $st_one_scores->subject_id = $biology->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 100;
            $st_one_scores->academic_id = $current_academic->id;
            $st_one_scores->save();

            //student two scores
            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_current->id;
            $st_two_scores->grade_id = $student_two_current->grade_id;
            $st_two_scores->subject_id = $maths->id;
            $st_two_scores->term_id = $periodOne->id;
            $st_two_scores->score = 99;
            $st_two_scores->academic_id = $current_academic->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_current->id;
            $st_two_scores->grade_id = $student_two_current->grade_id;
            $st_two_scores->subject_id = $maths->id;
            $st_two_scores->term_id = $periodFour->id;
            $st_two_scores->score = 65;
            $st_two_scores->academic_id = $current_academic->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_current->id;
            $st_two_scores->grade_id = $student_two_current->grade_id;
            $st_two_scores->subject_id = $biology->id;
            $st_two_scores->term_id = $periodThere->id;
            $st_two_scores->score = 60;
            $st_two_scores->academic_id = $current_academic->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_current->id;
            $st_two_scores->grade_id = $student_two_current->grade_id;
            $st_two_scores->subject_id = $geo->id;
            $st_two_scores->term_id = $periodOne->id;
            $st_two_scores->score = 57;
            $st_two_scores->academic_id = $current_academic->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_current->id;
            $st_two_scores->grade_id = $student_two_current->grade_id;
            $st_two_scores->subject_id = $physics->id;
            $st_two_scores->term_id = $periodFour->id;
            $st_two_scores->score = 87;
            $st_two_scores->academic_id = $current_academic->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_current->id;
            $st_two_scores->grade_id = $student_two_current->grade_id;
            $st_two_scores->subject_id = $biology->id;
            $st_two_scores->term_id = $periodOne->id;
            $st_two_scores->score = 70;
            $st_two_scores->academic_id = $current_academic->id;
            $st_two_scores->save();
            

            /*
            ---------------------------------------------------------------
            ***************************************************************
            **********PAST ACADEMIC SCORES 2016-2017***********************
            ***************************************************************
            ---------------------------------------------------------------
            */

            // student one scores
            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_past->id;
            $st_one_scores->grade_id = $student_one_past->grade_id;
            $st_one_scores->subject_id = $maths->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 88;
            $st_one_scores->academic_id = $past_academic->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_past->id;
            $st_one_scores->grade_id = $student_one_past->grade_id;
            $st_one_scores->subject_id = $maths->id;
            $st_one_scores->term_id = $periodFour->id;
            $st_one_scores->score = 77;
            $st_one_scores->academic_id = $past_academic->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_past->id;
            $st_one_scores->grade_id = $student_one_past->grade_id;
            $st_one_scores->subject_id = $biology->id;
            $st_one_scores->term_id = $periodThere->id;
            $st_one_scores->score = 80;
            $st_one_scores->academic_id = $past_academic->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_past->id;
            $st_one_scores->grade_id = $student_one_past->grade_id;
            $st_one_scores->subject_id = $geo->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 97;
            $st_one_scores->academic_id = $past_academic->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_past->id;
            $st_one_scores->grade_id = $student_one_past->grade_id;
            $st_one_scores->subject_id = $physics->id;
            $st_one_scores->term_id = $periodFour->id;
            $st_one_scores->score = 67;
            $st_one_scores->academic_id = $past_academic->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_past->id;
            $st_one_scores->grade_id = $student_one_past->grade_id;
            $st_one_scores->subject_id = $biology->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 60;
            $st_one_scores->academic_id = $past_academic->id;
            $st_one_scores->save();

            //student two scores
            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_past->id;
            $st_two_scores->grade_id = $student_two_past->grade_id;
            $st_two_scores->subject_id = $maths->id;
            $st_two_scores->term_id = $periodOne->id;
            $st_two_scores->score = 99;
            $st_two_scores->academic_id = $past_academic->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_past->id;
            $st_two_scores->grade_id = $student_two_past->grade_id;
            $st_two_scores->subject_id = $maths->id;
            $st_two_scores->term_id = $periodFour->id;
            $st_two_scores->score = 65;
            $st_two_scores->academic_id = $past_academic->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_past->id;
            $st_two_scores->grade_id = $student_two_past->grade_id;
            $st_two_scores->subject_id = $biology->id;
            $st_two_scores->term_id = $periodThere->id;
            $st_two_scores->score = 60;
            $st_two_scores->academic_id = $past_academic->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_past->id;
            $st_two_scores->grade_id = $student_two_past->grade_id;
            $st_two_scores->subject_id = $geo->id;
            $st_two_scores->term_id = $periodOne->id;
            $st_two_scores->score = 57;
            $st_two_scores->academic_id = $past_academic->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_past->id;
            $st_two_scores->grade_id = $student_two_past->grade_id;
            $st_two_scores->subject_id = $physics->id;
            $st_two_scores->term_id = $periodFour->id;
            $st_two_scores->score = 87;
            $st_two_scores->academic_id = $past_academic->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_past->id;
            $st_two_scores->grade_id = $student_two_past->grade_id;
            $st_two_scores->subject_id = $biology->id;
            $st_two_scores->term_id = $periodOne->id;
            $st_two_scores->score = 70;
            $st_two_scores->academic_id = $past_academic->id;
            $st_two_scores->save();
            

            // student three scores
            $st_three_scores = new Score();
            $st_three_scores->student_id = $student_three_past->id;
            $st_three_scores->grade_id = $student_three_past->grade_id;
            $st_three_scores->subject_id = $maths->id;
            $st_three_scores->term_id = $periodOne->id;
            $st_three_scores->score = 72;
            $st_three_scores->academic_id = $past_academic->id;
            $st_three_scores->save();

            $st_three_scores = new Score();
            $st_three_scores->student_id = $student_three_past->id;
            $st_three_scores->grade_id = $student_three_past->grade_id;
            $st_three_scores->subject_id = $maths->id;
            $st_three_scores->term_id = $periodFour->id;
            $st_three_scores->score = 65;
            $st_three_scores->academic_id = $past_academic->id;
            $st_three_scores->save();

            $st_three_scores = new Score();
            $st_three_scores->student_id = $student_three_past->id;
            $st_three_scores->grade_id = $student_three_past->grade_id;
            $st_three_scores->subject_id = $biology->id;
            $st_three_scores->term_id = $periodThere->id;
            $st_three_scores->score = 70;
            $st_three_scores->academic_id = $past_academic->id;
            $st_three_scores->save();

            $st_three_scores = new Score();
            $st_three_scores->student_id = $student_three_past->id;
            $st_three_scores->grade_id = $student_three_past->grade_id;
            $st_three_scores->subject_id = $geo->id;
            $st_three_scores->term_id = $periodOne->id;
            $st_three_scores->score = 77;
            $st_three_scores->academic_id = $past_academic->id;
            $st_three_scores->save();

            $st_three_scores = new Score();
            $st_three_scores->student_id = $student_three_past->id;
            $st_three_scores->grade_id = $student_three_past->grade_id;
            $st_three_scores->subject_id = $physics->id;
            $st_three_scores->term_id = $periodFour->id;
            $st_three_scores->score = 80;
            $st_three_scores->academic_id = $past_academic->id;
            $st_three_scores->save();

            $st_three_scores = new Score();
            $st_three_scores->student_id = $student_three_past->id;
            $st_three_scores->grade_id = $student_three_past->grade_id;
            $st_three_scores->subject_id = $biology->id;
            $st_three_scores->term_id = $periodOne->id;
            $st_three_scores->score = 70;
            $st_three_scores->academic_id = $past_academic->id;
            $st_three_scores->save();

            /*
            ---------------------------------------------------------------
            ***************************************************************
            ****************PAST ACADEMIC SCORES 2015-2016*****************
            ***************************************************************
            ---------------------------------------------------------------
            */

            // student one scores
            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20152016->id;
            $st_one_scores->grade_id = $student_one_20152016->grade_id;
            $st_one_scores->subject_id = $maths->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 88;
            $st_one_scores->academic_id = $past_academic_20152016->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20152016->id;
            $st_one_scores->grade_id = $student_one_20152016->grade_id;
            $st_one_scores->subject_id = $maths->id;
            $st_one_scores->term_id = $periodFour->id;
            $st_one_scores->score = 67;
            $st_one_scores->academic_id = $past_academic_20152016->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20152016->id;
            $st_one_scores->grade_id = $student_one_20152016->grade_id;
            $st_one_scores->subject_id = $science->id;
            $st_one_scores->term_id = $periodThere->id;
            $st_one_scores->score = 70;
            $st_one_scores->academic_id = $past_academic_20152016->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20152016->id;
            $st_one_scores->grade_id = $student_one_20152016->grade_id;
            $st_one_scores->subject_id = $geo->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 77;
            $st_one_scores->academic_id = $past_academic_20152016->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20152016->id;
            $st_one_scores->grade_id = $student_one_20152016->grade_id;
            $st_one_scores->subject_id = $english->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 100;
            $st_one_scores->academic_id = $past_academic_20152016->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20152016->id;
            $st_one_scores->grade_id = $student_one_20152016->grade_id;
            $st_one_scores->subject_id = $english->id;
            $st_one_scores->term_id = $periodTwo->id;
            $st_one_scores->score = 69;
            $st_one_scores->academic_id = $past_academic_20152016->id;
            $st_one_scores->save();


            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20152016->id;
            $st_one_scores->grade_id = $student_one_20152016->grade_id;
            $st_one_scores->subject_id = $science->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 99;
            $st_one_scores->academic_id = $past_academic_20152016->id;
            $st_one_scores->save();


            // student two scores
            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_20152016->id;
            $st_two_scores->grade_id = $student_two_20152016->grade_id;
            $st_two_scores->subject_id = $maths->id;
            $st_two_scores->term_id = $periodOne->id;
            $st_two_scores->score = 100;
            $st_two_scores->academic_id = $past_academic_20152016->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_20152016->id;
            $st_two_scores->grade_id = $student_two_20152016->grade_id;
            $st_two_scores->subject_id = $maths->id;
            $st_two_scores->term_id = $periodFour->id;
            $st_two_scores->score = 65;
            $st_two_scores->academic_id = $past_academic_20152016->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_20152016->id;
            $st_two_scores->grade_id = $student_two_20152016->grade_id;
            $st_two_scores->subject_id = $biology->id;
            $st_two_scores->term_id = $periodThere->id;
            $st_two_scores->score = 80;
            $st_two_scores->academic_id = $past_academic_20152016->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_20152016->id;
            $st_two_scores->grade_id = $student_two_20152016->grade_id;
            $st_two_scores->subject_id = $geo->id;
            $st_two_scores->term_id = $periodOne->id;
            $st_two_scores->score = 97;
            $st_two_scores->academic_id = $past_academic_20152016->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_20152016->id;
            $st_two_scores->grade_id = $student_two_20152016->grade_id;
            $st_two_scores->subject_id = $physics->id;
            $st_two_scores->term_id = $periodFour->id;
            $st_two_scores->score = 70;
            $st_two_scores->academic_id = $past_academic_20152016->id;
            $st_two_scores->save();

            $st_two_scores = new Score();
            $st_two_scores->student_id = $student_two_20152016->id;
            $st_two_scores->grade_id = $student_two_20152016->grade_id;
            $st_two_scores->subject_id = $biology->id;
            $st_two_scores->term_id = $periodOne->id;
            $st_two_scores->score = 60;
            $st_two_scores->academic_id = $past_academic_20152016->id;
            $st_two_scores->save();

            /*
            ---------------------------------------------------------------
            ***************************************************************
            ****************PAST ACADEMIC SCORES 2014-2015*****************
            ***************************************************************
            ---------------------------------------------------------------
            */

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20142015->id;
            $st_one_scores->grade_id = $student_one_20142015->grade_id;
            $st_one_scores->subject_id = $maths->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 88;
            $st_one_scores->academic_id = $past_academic_20142015->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20142015->id;
            $st_one_scores->grade_id = $student_one_20142015->grade_id;
            $st_one_scores->subject_id = $english->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 100;
            $st_one_scores->academic_id = $past_academic_20142015->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20142015->id;
            $st_one_scores->grade_id = $student_one_20142015->grade_id;
            $st_one_scores->subject_id = $maths->id;
            $st_one_scores->term_id = $periodFour->id;
            $st_one_scores->score = 77;
            $st_one_scores->academic_id = $past_academic_20142015->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20142015->id;
            $st_one_scores->grade_id = $student_one_20142015->grade_id;
            $st_one_scores->subject_id = $science->id;
            $st_one_scores->term_id = $periodThere->id;
            $st_one_scores->score = 80;
            $st_one_scores->academic_id = $past_academic_20142015->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20142015->id;
            $st_one_scores->grade_id = $student_one_20142015->grade_id;
            $st_one_scores->subject_id = $geo->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 97;
            $st_one_scores->academic_id = $past_academic_20142015->id;
            $st_one_scores->save();


            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20142015->id;
            $st_one_scores->grade_id = $student_one_20142015->grade_id;
            $st_one_scores->subject_id = $english->id;
            $st_one_scores->term_id = $periodFour->id;
            $st_one_scores->score = 67;
            $st_one_scores->academic_id = $past_academic_20142015->id;
            $st_one_scores->save();

            $st_one_scores = new Score();
            $st_one_scores->student_id = $student_one_20142015->id;
            $st_one_scores->grade_id = $student_one_20142015->grade_id;
            $st_one_scores->subject_id = $science->id;
            $st_one_scores->term_id = $periodOne->id;
            $st_one_scores->score = 74;
            $st_one_scores->academic_id = $past_academic_20142015->id;
            $st_one_scores->save();



        } else { echo "\e[scores table is not empty, therefore not seeding "; }
    }
}
