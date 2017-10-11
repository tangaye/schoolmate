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
        $periodThere = Term::where('name', '3rd Period')->first();
        $periodFour = Term::where('name', '4th Period')->first();
        
    	$maths = Subject::where('name', 'Mathematics')->first();
    	$biology = Subject::where('name', 'Biology')->first();
    	$physics = Subject::where('name', 'Physics')->first();
    	$geo = Subject::where('name', 'Geography')->first();

    	$student_one = Student::where('id', 1)->first();
    	$student_two = Student::where('id', 2)->first();
    	$student_three = Student::where('id', 3)->first();


        if(DB::table('scores')->get()->count() == 0){
            $score = new Score();
            $score->student_id = $student_one->id;
            $score->grade_id = $student_one->grade_id;
            $score->subject_id = $maths->id;
            $score->term_id = $periodOne->id;
            $score->score = 90;
            $score->save();

            $score = new Score();
            $score->student_id = $student_one->id;
            $score->grade_id = $student_one->grade_id;
            $score->subject_id = $maths->id;
            $score->term_id = $periodFour->id;
            $score->score = 65;
            $score->save();

            $score = new Score();
            $score->student_id = $student_one->id;
            $score->grade_id = $student_one->grade_id;
            $score->subject_id = $biology->id;
            $score->term_id = $periodThere->id;
            $score->score = 80;
            $score->save();

            $score = new Score();
            $score->student_id = $student_three->id;
            $score->grade_id = $student_three->grade_id;
            $score->subject_id = $geo->id;
            $score->term_id = $periodOne->id;
            $score->score = 77;
            $score->save();

            $score = new Score();
            $score->student_id = $student_three->id;
            $score->grade_id = $student_three->grade_id;
            $score->subject_id = $maths->id;
            $score->term_id = $periodFour->id;
            $score->score = 87;
            $score->save();

            $score = new Score();
            $score->student_id = $student_one->id;
            $score->grade_id = $student_one->grade_id;
            $score->subject_id = $biology->id;
            $score->term_id = $periodOne->id;
            $score->score = 100;
            $score->save();

            $score = new Score();
            $score->student_id = $student_two->id;
            $score->grade_id = $student_two->grade_id;
            $score->subject_id = $biology->id;
            $score->term_id = $periodTwo->id;
            $score->score = 69;
            $score->save();

            $score = new Score();
            $score->student_id = $student_two->id;
            $score->grade_id = $student_two->grade_id;
            $score->subject_id = $biology->id;
            $score->term_id = $periodOne->id;
            $score->score = 75;
            $score->save();

            $score = new Score();
            $score->student_id = $student_two->id;
            $score->grade_id = $student_two->grade_id;
            $score->subject_id = $physics->id;
            $score->term_id = $periodOne->id;
            $score->score = 62;
            $score->save();


        } else { echo "\e[scores table is not empty, therefore not seeding "; }
    }
}
