<?php

use Illuminate\Database\Seeder;
use App\Academic;
use App\Teacher;
use App\Grade;
use App\GradeSponsor;

class GradeSponsorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
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

        $teacher1 = Teacher::where('email', 'teacher@example.com')->first();
        $teacher2 = Teacher::where('email', 'teacher2@example.com')->first();

        $grade_eight = Grade::where('name', '8th Grade')->first();
        $grade_nine = Grade::where('name', '9th Grade')->first();
        $grade_ten = Grade::where('name', '10th Grade')->first();
        $grade_eleven = Grade::where('name', '11th Grade')->first();
        $grade_twelve = Grade::where('name', '12th Grade')->first();


        if(DB::table('grade_sponsors')->get()->count() == 0){

            //CURRENT ACADEMIC TEACHER SPONSOR GRADE ASSIGNMENT
            $sponsor1 = new GradeSponsor();
            $sponsor1->teacher_id = $teacher1->id;
            $sponsor1->grade_id = $grade_eleven->id;
            $sponsor1->academic_id = $current_academic->id;
            $sponsor1->save();

            $sponsor2 = new GradeSponsor();
            $sponsor2->teacher_id = $teacher2->id;
            $sponsor2->grade_id = $grade_twelve->id;
            $sponsor2->academic_id = $current_academic->id;
            $sponsor2->save();

            //PAST ACADEMIC TEACHER SPONSOR GRADE ASSIGNMENT
            $sponsor1 = new GradeSponsor();
            $sponsor1->teacher_id = $teacher1->id;
            $sponsor1->grade_id = $grade_eleven->id;
            $sponsor1->academic_id = $past_academic->id;
            $sponsor1->save();

            $sponsor2 = new GradeSponsor();
            $sponsor2->teacher_id = $teacher2->id;
            $sponsor2->grade_id = $grade_ten->id;
            $sponsor2->academic_id = $past_academic->id;
            $sponsor2->save();

            //2015/2016 TEACHER SPONSOR GRADE ASSIGNMENT
            $sponsor1 = new GradeSponsor();
            $sponsor1->teacher_id = $teacher1->id;
            $sponsor1->grade_id = $grade_nine->id;
            $sponsor1->academic_id = $past_academic_20152016->id;
            $sponsor1->save();

            //2014/2015 TEACHER SPONSOR GRADE ASSIGNMENT
            $sponsor1 = new GradeSponsor();
            $sponsor1->teacher_id = $teacher1->id;
            $sponsor1->grade_id = $grade_eight->id;
            $sponsor1->academic_id = $past_academic_20142015->id;
            $sponsor1->save();
            
        } else { echo "\e[grade_sponsors table is not empty, therefore not seeding "; }    
    }
}
