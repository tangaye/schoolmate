<?php

use Illuminate\Database\Seeder;
use App\Teacher;
use App\Subject;
use App\Grade;
use App\GradeTeacher;





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
        $teacher = Teacher::where('email', 'teacher@example.com')->first();
        $grade_twelve = Grade::where('name', '12th Grade')->first();
        $grade_eleven = Grade::where('name', '11th Grade')->first();
    	$maths = Subject::where('name', 'Mathematics')->first();
    	$biology = Subject::where('name', 'Biology')->first();
    	$physics = Subject::where('name', 'Physics')->first();
    	$geo = Subject::where('name', 'Geography')->first();


        if(DB::table('grade_teachers')->get()->count() == 0){
            $grade_teacher1 = new GradeTeacher();
            $grade_teacher1->grade_id = $grade_twelve->id;
            $grade_teacher1->subject_id = $maths->id;
            $grade_teacher1->teacher_id = $teacher->id;
            $grade_teacher1->save();

            $grade_teacher2 = new GradeTeacher();
            $grade_teacher2->grade_id = $grade_twelve->id;
            $grade_teacher2->subject_id = $geo->id;
            $grade_teacher2->teacher_id = $teacher->id;
            $grade_teacher2->save();

            $grade_teacher3 = new GradeTeacher();
            $grade_teacher3->grade_id = $grade_eleven->id;
            $grade_teacher3->subject_id = $physics->id;
            $grade_teacher3->teacher_id = $teacher->id;
            $grade_teacher3->save();

            $grade_teacher4 = new GradeTeacher();
            $grade_teacher4->grade_id = $grade_eleven->id;
            $grade_teacher4->subject_id = $biology->id;
            $grade_teacher4->teacher_id = $teacher->id;
            $grade_teacher4->save();

        } else { echo "\e[grade_teachers table is not empty, therefore not seeding "; }
    }
}
