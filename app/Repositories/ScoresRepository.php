<?php

namespace App\Repositories;
use App\Score;
use App\Student;
use App\Term;
use App\Institution;
use App\Subject;
use App\Academic;
use App\Semester;
use App\Common;
use App\Grade;



/**
 * This class holds all the queries functions relating to students score
 */
class ScoresRepository
{
    
   /*
    * This function fetches students scores for specific subjects
    * and grades
    */
    public function findScores($grade, $subject, $term, $academic_year_id){

        return \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->select(
                'students.id as student_id',
                'students.student_code as code',
                'students.surname', 
                'students.first_name', 
                'grades.id as grade_id',
                'grades.name as grade',
                'subjects.id as subject_id',
                'subjects.name as subject',
                'terms.id as term_id',
                'terms.name as term',
                'scores.id as score_id',
                'score'
            )
            ->where([
                ['scores.grade_id', $grade],
                ['scores.subject_id', $subject],
                ['scores.term_id', $term],
                ['scores.academic_id', $academic_year_id]
            ])
            ->get();
    }


    /*
    * This function returns existing students score for a particular subject, grade, term
    * and academic year.
    * It returns null if no score exists
    *
    * This function is useful when creating or entering scores for students. If a student
    * already has score recorded for a subject you want to enter score for at the present
    * moment, this function returns the score that already exists. Otherwise it returns
    * null and allow you to create/enter the student score.
    */
    public static function has_score($grade, $subject, $term, $academic_year_id, $student_id){

        $score = Score::where([
            ['scores.grade_id', $grade],
            ['scores.subject_id', $subject],
            ['scores.term_id', $term],
            ['scores.academic_id', $academic_year_id],
            ['scores.student_id', $student_id]
        ])
        ->value('score');

        return $score;
    }

    /*
    * This function returns students who has score recorded for them in a 
    * particular academic year.
    */
    public function scores_academic_students($academic_id)
    {
        return \DB::table('scores')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->select(
                'students.id',
                'students.student_code as code',
                'students.surname', 
                'students.first_name', 
                'students.middle_name'
            )
            ->distinct()
            ->whereNotNull('scores.score')
            ->where('scores.academic_id', $academic_id)
            ->get();
    }


    /*
    * This function returns grades that scores are recorded for in an academic year.
    */
    public function scores_academic_grades($academic_id)
    {
        return \DB::table('scores')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->select(
                'grades.id',
                'grades.name'
            )
            ->distinct()
            ->whereNotNull('scores.score')
            ->where('scores.academic_id', $academic_id)
            ->get();
    }


    /*
    * This function returns students who has score recorded for them in a 
    * particular academic year and grade.
    * This function is mainly used in the guardian view. In returns students
    * who are enrolled in the grade the guardian is teaching and have scores
    * recorded for them.
    */
    public function scores_grade_academic_students($academic_id, $grade_id)
    {
        $score_students = \DB::table('scores')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->select(
                'students.id'
            )
            ->distinct()
            ->whereNotNull('scores.score')
            ->where([
                ['scores.academic_id', $academic_id],
                ['scores.grade_id', $grade_id]
            ])
            ->get();

        $students = Student::whereIn('id', $score_students->pluck('id'))->get();

        return $students;
    }

    // this function fetches the a term/period report for a specific student
    // in a particular academic year by passingthe student id, term id and academic year id
    public function termReport($term, $student, $academic_year){

        $student = Student::findOrFail($student);
        $term = Term::findOrFail($term);
        $date = Common::date();
        $academic = Academic::findOrFail($academic_year);

        $institution = Institution::where('id', 1)->first();

        $scores = \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->select(
                'subjects.name as subject', 
                'score'
            )
            ->where([
                ['scores.student_id', $student->id],
                ['scores.term_id', $term->id],
                ['scores.academic_id', $academic->id]
            ])
            ->get();
            
        //passing the student average for first period      
        $average = $scores->pluck('score')->avg();

        //round the student perodic averate
        $rounded_avg = round($average, 0, PHP_ROUND_HALF_UP);

        if (count($scores) > 0) {
            return \View::make('scores.partials.term-report')->with(array(
                'student' => $student, 
                'term' => $term,
                'date' => $date,
                'scores' => $scores,
                'average' => $rounded_avg,
                'institution' => $institution,
                'academic' => $academic
            ));
        } else {
            return response()->json(["none" => "No score recorded for <b>".$student->full_name."</b> in <b>".$term->name."</b> for academic year <u>".$academic->full_year."</u>"]);
        }

        
    }

    // this function fetches the a term/period report report for a specific student
    // by passing both the student id and term id
    public function semesterReport($student, $semester, $academic_year){

        $student = Student::findOrFail($student);
        $semester = Semester::findOrFail($semester);
        $date = Common::date();
        $academic = Academic::findOrFail($academic_year);
        $institution = Institution::where('id', 1)->first();

        $scores = \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->select('subjects.name as subject', 'subjects.id as subject_id', 'terms.name as term', 'score')
            ->where('scores.student_id', $student->id)
            ->where('terms.semester_id', $semester->id)
            ->where('scores.academic_id', $academic->id)
            ->get();

        $subjects = $scores->pluck('subject')->unique(); // ['Mathematics', 'Biology']
        $terms = Term::all()->where('semester_id', $semester->id)->pluck('name', 'id'); 


        $scoreTable = [];
        foreach ($subjects as $subject) {
            foreach ($terms as $term_id => $term_name) {
                $scoreTable[$subject][$term_name] = '';
            }
        }

        foreach ($scores as $row) {
            $scoreTable[$row->subject][$row->term] = $row->score;
        }

        if (count($scores) > 0) {
            return \View::make('scores.partials.semester-report')->with(array(
                'student'=>$student, 
                'terms'=>$terms,
                'date'=>$date,
                'semester'=>$semester,
                'scoreTable'=>$scoreTable,
                'institution' => $institution,
                'academic' => $academic
            ));
        } else {

            return response()->json(["none" => "No score recorded for <b>".$student->full_name."</b> in <b>".$semester->name."</b> for academic year <u>".$academic->full_year."</u>"]);
        }

    }

    public function annualReport($student, $academic_year)
    {

        $student = Student::findOrFail($student);
        $date = Common::date();
        $academic = Academic::findOrFail($academic_year);
        $institution = Institution::where('id', 1)->first();

        $scores = \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->select('subjects.name as subject', 'subjects.id as subject_id', 'terms.name as term', 'score')
            ->where('scores.student_id', $student->id)
            ->where('scores.academic_id', $academic->id)
            ->get();

        $subjects = $scores->pluck('subject')->unique(); // ['Mathematics', 'Biology']
        $terms = Term::all()->pluck('name', 'id'); 

        $scoreTable = [];
        foreach ($subjects as $subject) {
            foreach ($terms as $term_id => $term_name) {
                $scoreTable[$subject][$term_name] = '';
            }
        }

        foreach ($scores as $row) {
            $scoreTable[$row->subject][$row->term] = $row->score;
        }

        if (count($scores) > 0) {
            return \View::make('scores.partials.annual-report')->with(array(
                'student'=>$student, 
                'terms'=>$terms,
                'date'=>$date,
                'scoreTable'=>$scoreTable,
                'institution' => $institution,
                'academic' => $academic
            ));
        } else {

            return response()->json(["none" => "No score recorded for <b>".$student->full_name."</b> for the year <b>".$academic->full_year."</b>"]);
        }

        
    }

    // this function returns a student cummulated semester average
    // It does that by first getting all the subjects averages for a given semester and then
    // calculate the student semester average from there
    public static function semester_avg($student, $semester, $academic_year)
    {
        $academic = Academic::findOrFail($academic_year);
        $semester = Semester::findOrFail($semester);
        $subjects = Subject::all();
        $subjectAverages = array();

        foreach ($subjects as $subject) {

            //add all the subjects averages to our array
            array_push($subjectAverages, ScoresRepository::subject_semester_avg($subject->name, $student, $semester->id, $academic->id));
        }

        // after pushing all the subjects average to the array
        // it is possible that some null values are send. In order to calculate the average
        // we have to filter out all the null and pass elements of the array that are not null
        $filter_subjects_average = array_filter($subjectAverages);

        // I had to applied some logic on the count of the array. If not an 
        // division by zero error is caught and the program doesn't know what to do. To avoid that
        // I return null if the count of the filter array is zero or less
        if (count($filter_subjects_average) > 0) {
            //Calculate the average. based on the values in our $subjectAverages array
            $semester_avg = array_sum($filter_subjects_average) / count($filter_subjects_average);

            //return the semester average
            return round($semester_avg, 0, PHP_ROUND_HALF_UP);
        } else {
            return null;
        }
        
    }

    public static function annual_avg($student, $academic_year)
    {
        $academic = Academic::findOrFail($academic_year);
        $subjects = Subject::all();
        $subjectAverages = array();

        foreach ($subjects as $subject) {

            //add all the subjects averages to our array
            array_push($subjectAverages, ScoresRepository::subject_annual_avg($subject->name, $student, $academic->id));
        }

        // do away with null values
        $filter_subjects_average = array_filter($subjectAverages);

        if (count($filter_subjects_average) > 0) {
            //Calculate the average. based on the values in our $subjectAverages array
            $annual_avg = array_sum($filter_subjects_average) / count($filter_subjects_average);

            //return rounded the annual average
            return round($annual_avg, 0, PHP_ROUND_HALF_UP);
        } else {
            return null;
        }
    }

    // this function list all the periodic averages in the semester grade/score sheet
    public static function periodic_avg($term, $student, $academic_year)
    {
        $academic = Academic::findOrFail($academic_year);

        $period_avg = \DB::table('scores')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->where('scores.student_id', $student)
            ->where('scores.term_id', $term)
            ->where('scores.academic_id', $academic->id)
            ->avg('score');

        return round($period_avg, 0, PHP_ROUND_HALF_UP);
    }

    // this function takes a subject name, finds its id and then query out
    // the subject average for the selected semester
    public static function subject_semester_avg($subject, $student, $semester, $academic_year)
    {

        $subject_id = Subject::where('name', $subject)->pluck('id');

        $subject_sem_avg = \DB::table('scores')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->where('subjects.id', $subject_id)
            ->where('scores.student_id', $student)
            ->where('terms.semester_id', $semester)
            ->where('scores.academic_id', $academic_year)
            ->avg('score');
        return round($subject_sem_avg, 0, PHP_ROUND_HALF_UP);
    }

    // this function finds a subject annual average 
    public static function subject_annual_avg($subject, $student, $academic_year)
    {
        $subject_id = Subject::where('name', $subject)->pluck('id');

        $subject_avg = \DB::table('scores')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->where('subjects.id', $subject_id)
            ->where('scores.student_id', $student)
            ->where('scores.academic_id', $academic_year)
            ->avg('score');

        // returned rounded subject average
        return round($subject_avg, 0, PHP_ROUND_HALF_UP);
    }
}
