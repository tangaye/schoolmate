<?php

use Illuminate\Database\Seeder;
use App\Subject;
use App\Student;
use App\Attendence;
use Carbon\Carbon;



class AttendenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $maths = Subject::where('name', 'Mathematics')->first();
    	$biology = Subject::where('name', 'Biology')->first();
    	$physics = Subject::where('name', 'Physics')->first();
    	$geo = Subject::where('name', 'Geography')->first();

    	$student1 = Student::where('id', 1)->first();
    	$student2 = Student::where('phone', 'like', '%0770900900%')->first();
    	$student3 = Student::where('phone', 'like', '%0770600600%')->first();

    	if(DB::table('attendences')->get()->count() == 0){

    		//attendence on 2017-10-25 for maths
            $attendence = new Attendence();
            $attendence->student_id = $student1->id;
            $attendence->grade_id = $student1->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-25')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student2->id;
            $attendence->grade_id = $student2->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-25')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student3->id;
            $attendence->grade_id = $student3->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-25')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Came to school late.";
            $attendence->save();

            //attendence on 2017-10-25 for biology
            $attendence = new Attendence();
            $attendence->student_id = $student1->id;
            $attendence->grade_id = $student1->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2017-10-25')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student2->id;
            $attendence->grade_id = $student2->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2017-10-25')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Was involve in a fight.";
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student3->id;
            $attendence->grade_id = $student3->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2017-10-25')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Refuse to partake in morning devotion.";
            $attendence->save();


            //attendence on 2017-10-26 for maths
            $attendence = new Attendence();
            $attendence->student_id = $student1->id;
            $attendence->grade_id = $student1->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-26')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Was very ill.";
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student2->id;
            $attendence->grade_id = $student2->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-26')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student3->id;
            $attendence->grade_id = $student3->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-26')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Refuse to pay school fees.";
            $attendence->save();

            //attendence on 2017-10-26 for biology
            $attendence = new Attendence();
            $attendence->student_id = $student1->id;
            $attendence->grade_id = $student1->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2017-10-26')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Found gambling during break.";
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student2->id;
            $attendence->grade_id = $student2->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2017-10-26')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student3->id;
            $attendence->grade_id = $student3->grade_id;
            $attendence->subject_id = $biology->id;
            $attendence->date = Carbon::parse('2017-10-26')->format('d/m/Y');
            $attendence->status = "Present";
            $attendence->save();

            //attendence on 2017-10-27 for maths
            $attendence = new Attendence();
            $attendence->student_id = $student1->id;
            $attendence->grade_id = $student1->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-27')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Refuse to pay school fees.";
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student2->id;
            $attendence->grade_id = $student2->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-27')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Refuse to pay school fees.";
            $attendence->save();

            $attendence = new Attendence();
            $attendence->student_id = $student3->id;
            $attendence->grade_id = $student3->grade_id;
            $attendence->subject_id = $maths->id;
            $attendence->date = Carbon::parse('2017-10-27')->format('d/m/Y');
            $attendence->status = "Absent";
            $attendence->remarks = "Refuse to pay school fees.";
            $attendence->save();

        } else { echo "\e[attendence table is not empty, therefore not seeding "; }
    }
}
