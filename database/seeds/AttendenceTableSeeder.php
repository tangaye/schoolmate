<?php

use Illuminate\Database\Seeder;
use App\Subject;
use App\Student;
use App\Attendence;
use Carbon\Carbon;
use App\Academic;




class AttendenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $maths = Subject::where('name', 'Mathematics')->first();
    	$biology = Subject::where('name', 'Biology')->first();
    	$physics = Subject::where('name', 'Physics')->first();
    	$geo = Subject::where('name', 'Geography')->first();


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



        if(DB::table('attendences')->get()->count() == 0){

            /*
            ---------------------------------------------------------------
            ***************************************************************
            *******************CURRENT ACADEMIC SCORES*********************
            ***************************************************************
            ---------------------------------------------------------------
            */

            //attendence on 2017-10-25 for maths
            $attendence = new Attendence();
            $attendence->student_id = $student_one_current->id;
            $attendence->grade_id = $student_one_current->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-25')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->academic_id = $current_academic->id;
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student_two_current->id;
            $attendence->grade_id = $student_two_current->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-25')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->academic_id = $current_academic->id;
            $attendence->save();

            
            //attendence on 2017-10-25 for biology
            $attendence = new Attendence();
            $attendence->student_id = $student_one_current->id;
            $attendence->grade_id = $student_one_current->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2017-10-25')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->academic_id = $current_academic->id;
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student_two_current->id;
            $attendence->grade_id = $student_two_current->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2017-10-25')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Was involve in a fight.";
            $attendence->academic_id = $current_academic->id;
            $attendence->save();

            


            //attendence on 2017-10-26 for maths
            $attendence = new Attendence();
            $attendence->student_id = $student_one_current->id;
            $attendence->grade_id = $student_one_current->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-26')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Was very ill.";
            $attendence->academic_id = $current_academic->id;
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student_two_current->id;
            $attendence->grade_id = $student_two_current->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-26')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->academic_id = $current_academic->id;
            $attendence->save();

           
            //attendence on 2017-10-26 for biology
            $attendence = new Attendence();
            $attendence->student_id = $student_one_current->id;
            $attendence->grade_id = $student_one_current->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2017-10-26')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Found gambling during break.";
            $attendence->academic_id = $current_academic->id;
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student_two_current->id;
            $attendence->grade_id = $student_two_current->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2017-10-26')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->academic_id = $current_academic->id;
            $attendence->save();

           
            //attendence on 2017-10-27 for maths
            $attendence = new Attendence();
            $attendence->student_id = $student_one_current->id;
            $attendence->grade_id = $student_one_current->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-27')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Refuse to pay school fees.";
            $attendence->academic_id = $current_academic->id;
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student_two_current->id;
            $attendence->grade_id = $student_two_current->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-27')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Refuse to pay school fees.";
            $attendence->academic_id = $current_academic->id;
            $attendence->save();

           
            /*
            ---------------------------------------------------------------
            ***************************************************************
            ********************PAST ACADEMIC SCORES***********************
            ***************************************************************
            ---------------------------------------------------------------
            */

            $attendence = new Attendence();
            $attendence->student_id = $student_one_past->id;
            $attendence->grade_id = $student_one_past->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2016-09-09')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->academic_id = $past_academic->id;
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student_three_past->id;
            $attendence->grade_id = $student_three_past->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2016-09-09')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->academic_id = $past_academic->id;
            $attendence->save();


            //attendence on 2017-10-25 for biology
            $attendence = new Attendence();
            $attendence->student_id = $student_one_past->id;
            $attendence->grade_id = $student_one_past->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2016-10-25')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->academic_id = $past_academic->id;
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student_three_past->id;
            $attendence->grade_id = $student_three_past->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2016-10-25')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Was involve in a fight.";
            $attendence->academic_id = $past_academic->id;
            $attendence->save();

            
            $attendence = new Attendence();
            $attendence->student_id = $student_one_past->id;
            $attendence->grade_id = $student_one_past->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2016-10-26')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Was very ill.";
            $attendence->academic_id = $past_academic->id;
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student_three_past->id;
            $attendence->grade_id = $student_three_past->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2016-10-26')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->academic_id = $past_academic->id;
            $attendence->save();

            
            //attendence on 2017-10-26 for biology
            $attendence = new Attendence();
            $attendence->student_id = $student_one_past->id;
            $attendence->grade_id = $student_one_past->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2016-10-27')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Found gambling during break.";
            $attendence->academic_id = $past_academic->id;
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student_three_past->id;
            $attendence->grade_id = $student_three_past->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2016-10-29')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->academic_id = $past_academic->id;
            $attendence->save();

           

            //attendence on 2017-10-27 for maths
            $attendence = new Attendence();
            $attendence->student_id = $student_one_past->id;
            $attendence->grade_id = $student_one_past->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-06-01')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Refuse to pay school fees.";
            $attendence->academic_id = $past_academic->id;
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student_three_past->id;
            $attendence->grade_id = $student_three_past->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-06-01')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Refuse to pay school fees.";
            $attendence->academic_id = $past_academic->id;
            $attendence->save();

            



        } else { echo "\e[attendence table is not empty, therefore not seeding "; }
    	
    }
}
