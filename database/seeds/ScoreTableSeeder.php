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

    	$student_one = Student::where('student_code', 0001)->first();
    	$student_two = Student::where('student_code', 0002)->first();
    	$student_three = Student::where('student_code', 0003)->first();


        if(DB::table('scores')->get()->count() == 0){
            $score_one = new Score();
            $score_one->student_id = $student_one->id;
            $score_one->grade_id = $student_one->grade_id;
            $score_one->subject_id = $maths->id;
            $score_one->term_id = $periodOne->id;
            $score_one->score = 90;
            $score_one->save();

            $score_two = new Score();
            $score_two->student_id = $student_one->id;
            $score_two->grade_id = $student_one->grade_id;
            $score_two->subject_id = $maths->id;
            $score_two->term_id = $periodFour->id;
            $score_two->score = 65;
            $score_two->save();

            $score_nine = new Score();
            $score_nine->student_id = $student_one->id;
            $score_nine->grade_id = $student_one->grade_id;
            $score_nine->subject_id = $biology->id;
            $score_nine->term_id = $periodThere->id;
            $score_nine->score = 80;
            $score_nine->save();

            $score_four = new Score();
            $score_four->student_id = $student_three->id;
            $score_four->grade_id = $student_three->grade_id;
            $score_four->subject_id = $geo->id;
            $score_four->term_id = $periodOne->id;
            $score_four->score = 77;
            $score_four->save();

            $score_five = new Score();
            $score_five->student_id = $student_three->id;
            $score_five->grade_id = $student_three->grade_id;
            $score_five->subject_id = $maths->id;
            $score_five->term_id = $periodFour->id;
            $score_five->score = 87;
            $score_five->save();

            $score_six = new Score();
            $score_six->student_id = $student_one->id;
            $score_six->grade_id = $student_one->grade_id;
            $score_six->subject_id = $biology->id;
            $score_six->term_id = $periodOne->id;
            $score_six->score = 100;
            $score_six->save();

            $score_seven = new Score();
            $score_seven->student_id = $student_two->id;
            $score_seven->grade_id = $student_two->grade_id;
            $score_seven->subject_id = $biology->id;
            $score_seven->term_id = $periodTwo->id;
            $score_seven->score = 69;
            $score_seven->save();

            $score_eight = new Score();
            $score_eight->student_id = $student_two->id;
            $score_eight->grade_id = $student_two->grade_id;
            $score_eight->subject_id = $biology->id;
            $score_eight->term_id = $periodOne->id;
            $score_eight->score = 75;
            $score_eight->save();

            $score_nine = new Score();
            $score_nine->student_id = $student_two->id;
            $score_nine->grade_id = $student_two->grade_id;
            $score_nine->subject_id = $physics->id;
            $score_nine->term_id = $periodOne->id;
            $score_nine->score = 62;
            $score_nine->save();


        } else { echo "\e[scores table is not empty, therefore not seeding "; }
    }
}
