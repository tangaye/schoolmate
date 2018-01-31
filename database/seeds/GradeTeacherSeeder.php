<?php

use Illuminate\Database\Seeder;
use App\Teacher;
use App\Subject;
use App\Grade;
use App\GradeTeacher;
use App\Academic;

class GradeTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $past_academic = Academic::where([
            ['year_start', 2016],
            ['year_end', 2017]
        ])->first();

        $current_academic = Academic::where('status', 1)->first();

        $teacher = Teacher::where('email', 'teacher@example.com')->first();
        $teacher2 = Teacher::where('email', 'teacher2@example.com')->first();

        $grade_nine = Grade::where('name', '9th Grade')->first();
        $grade_ten = Grade::where('name', '10th Grade')->first();
        $grade_eleven = Grade::where('name', '11th Grade')->first();
        $grade_twelve = Grade::where('name', '12th Grade')->first();
    	$maths = Subject::where('name', 'Mathematics')->first();
    	$biology = Subject::where('name', 'Biology')->first();
    	$physics = Subject::where('name', 'Physics')->first();
    	$geo = Subject::where('name', 'Geography')->first();


        if(DB::table('grade_teachers')->get()->count() == 0){

            //CURRENT ACADEMIC TEACHER ASSIGNMENT
            $grade_teacher1 = new GradeTeacher();
            $grade_teacher1->grade_id = $grade_twelve->id;
            $grade_teacher1->subject_id = $maths->id;
            $grade_teacher1->teacher_id = $teacher->id;
            $grade_teacher1->academic_id = $current_academic->id;
            $grade_teacher1->save();

            $grade_teacher2 = new GradeTeacher();
            $grade_teacher2->grade_id = $grade_twelve->id;
            $grade_teacher2->subject_id = $geo->id;
            $grade_teacher2->teacher_id = $teacher->id;
            $grade_teacher2->academic_id = $current_academic->id;
            $grade_teacher2->save();

            $grade_teacher3 = new GradeTeacher();
            $grade_teacher3->grade_id = $grade_eleven->id;
            $grade_teacher3->subject_id = $physics->id;
            $grade_teacher3->teacher_id = $teacher->id;
            $grade_teacher3->academic_id = $current_academic->id;
            $grade_teacher3->save();

            $grade_teacher4 = new GradeTeacher();
            $grade_teacher4->grade_id = $grade_eleven->id;
            $grade_teacher4->subject_id = $biology->id;
            $grade_teacher4->teacher_id = $teacher->id;
            $grade_teacher4->academic_id = $current_academic->id;
            $grade_teacher4->save();

            $grade_teacher5 = new GradeTeacher();
            $grade_teacher5->grade_id = $grade_twelve->id;
            $grade_teacher5->subject_id = $physics->id;
            $grade_teacher5->teacher_id = $teacher2->id;
            $grade_teacher5->academic_id = $current_academic->id;
            $grade_teacher5->save();

            //PAST ACADEMIC TEACHER ASSIGNMENT
            $grade_teacher5 = new GradeTeacher();
            $grade_teacher5->grade_id = $grade_nine->id;
            $grade_teacher5->subject_id = $maths->id;
            $grade_teacher5->teacher_id = $teacher->id;
            $grade_teacher5->academic_id = $past_academic->id;
            $grade_teacher5->save();

            $grade_teacher6 = new GradeTeacher();
            $grade_teacher6->grade_id = $grade_nine->id;
            $grade_teacher6->subject_id = $geo->id;
            $grade_teacher6->teacher_id = $teacher->id;
            $grade_teacher6->academic_id = $past_academic->id;
            $grade_teacher6->save();

            $grade_teacher7 = new GradeTeacher();
            $grade_teacher7->grade_id = $grade_ten->id;
            $grade_teacher7->subject_id = $physics->id;
            $grade_teacher7->teacher_id = $teacher->id;
            $grade_teacher7->academic_id = $past_academic->id;
            $grade_teacher7->save();

            $grade_teacher8 = new GradeTeacher();
            $grade_teacher8->grade_id = $grade_ten->id;
            $grade_teacher8->subject_id = $biology->id;
            $grade_teacher8->teacher_id = $teacher->id;
            $grade_teacher8->academic_id = $past_academic->id;
            $grade_teacher8->save();

            $grade_teacher9 = new GradeTeacher();
            $grade_teacher9->grade_id = $grade_ten->id;
            $grade_teacher9->subject_id = $maths->id;
            $grade_teacher9->teacher_id = $teacher2->id;
            $grade_teacher9->academic_id = $past_academic->id;
            $grade_teacher9->save();

        } else { echo "\e[grade_teachers table is not empty, therefore not seeding "; }
    }
}
