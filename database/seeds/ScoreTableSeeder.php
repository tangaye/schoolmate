<?php

use Illuminate\Database\Seeder;

use App\Term;
use App\Subject;
use App\Student;
use App\Score;


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
        //
        $periodOne = Term::where('name', '1st Period')->first();
        $periodTwo = Term::where('name', '2nd Period')->first();
        $periodthree = Term::where('name', '3rd Period')->first();
        $periodFour = Term::where('name', '4th Period')->first();
        
        $maths = Subject::where('name', 'Mathematics')->first();
        $biology = Subject::where('name', 'Biology')->first();
        $physics = Subject::where('name', 'Physics')->first();
        $geo = Subject::where('name', 'Geography')->first();

        $student_one = DB::table('students')
            ->select('id', 'grade_id')
            ->where('student_code', 0001)
            ->first();

        $student_two = DB::table('students')
            ->select('id', 'grade_id')
            ->where('student_code', 0002)
            ->first();

        $student_three = DB::table('students')
            ->select('id', 'grade_id')
            ->where('student_code', 0003)
            ->first();


        if(DB::table('scores')->get()->count() == 0){

            DB::table('scores')->insert([

                [
                    'student_id' => $student_one->id,
                    'grade_id' => $student_one->grade_id, 
                    'subject_id' => $maths->id, 
                    'term_id' => $periodOne->id,
                    'score' => 90
                     
                ],

                [
                    'student_id' => $student_one->id,
                    'grade_id' => $student_one->grade_id, 
                    'subject_id' => $maths->id, 
                    'term_id' => $periodFour->id,
                    'score' => 65
                     
                ],

                [
                    'student_id' => $student_one->id,
                    'grade_id' => $student_one->grade_id, 
                    'subject_id' => $biology->id, 
                    'term_id' => $periodthree->id,
                    'score' => 80
                     
                ],

                [
                    'student_id' => $student_three->id,
                    'grade_id' => $student_three->grade_id, 
                    'subject_id' => $geo->id, 
                    'term_id' => $periodOne->id,
                    'score' => 77
                     
                ],

                [
                    'student_id' => $student_three->id,
                    'grade_id' => $student_three->grade_id, 
                    'subject_id' => $maths->id, 
                    'term_id' => $periodFour->id,
                    'score' => 87
                     
                ],

                [
                    'student_id' => $student_one->id,
                    'grade_id' => $student_one->grade_id, 
                    'subject_id' => $biology->id, 
                    'term_id' => $periodOne->id,
                    'score' => 100
                     
                ],

                [
                    'student_id' => $student_two->id,
                    'grade_id' => $student_two->grade_id, 
                    'subject_id' => $biology->id, 
                    'term_id' => $periodTwo->id,
                    'score' => 69
                     
                ],

                [
                    'student_id' => $student_two->id,
                    'grade_id' => $student_two->grade_id, 
                    'subject_id' => $biology->id, 
                    'term_id' => $periodOne->id,
                    'score' => 75
                     
                ],

                [
                    'student_id' => $student_two->id,
                    'grade_id' => $student_two->grade_id, 
                    'subject_id' => $physics->id, 
                    'term_id' => $periodOne->id,
                    'score' => 62
                     
                ]
                

            ]);

        } else { echo "\e[scores table is not empty, therefore not seeding "; }
    }
}
