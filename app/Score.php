<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Carbon\Carbon;
use App\Term;
use App\Subject;





class Score extends Model
{
    //
	protected $fillable = ['student_id', 'subject_id', 'grade_id', 'term_id', 'score'];

	// this get the current date
    public static function date() {
        return Carbon::now();
    }

     // define relationship and select only values that I want to use
    public function student()
    {
        return $this->belongsTo(Student::class)->select(['id', 'first_name', 'surname']);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class)->select(['id', 'name']);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class)->select(['id', 'name']);
    }
    
    public function term()
    {
        return $this->belongsTo(Term::class)->select(['id', 'name']);
    }


    /*
    * This function fetches students scores for specific subjects
    * and grades
    */
    public function findScores($grade, $subject, $term){
        return \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
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
            ->where('scores.grade_id', $grade)
            ->where('scores.subject_id', $subject)
            ->where('scores.term_id', $term)
            ->get();
    }

    // this function fetches the a term/period report report for a specific student
    // by passing both the student id and term id
    public function termReport($term, $student){

        try {
            $student = Student::findOrFail($student);
        } catch (ModelNotFoundException $e) {
            return response()->json(array('none' => 'No student found!'));
        }

        $term = Term::findOrFail($term);
        $date = Score::date();

        $institution = Institution::where('id', 1)->first();

        $scores = \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->select('subjects.name as subject', 'score')
            ->where('scores.student_id', $student->id)
            ->where('scores.term_id', $term->id)
            ->get();
            
        //passing the student average for first period      
        $average = $scores->pluck('score')->avg();

        return \View::make('scores.partials.term-report')->with(array(
            'student'=>$student, 
            'term' => $term,
            'date' => $date,
            'scores' => $scores,
            'average' => $average,
            'institution' => $institution
        ));
    }

    

    // this function fetches the a term/period report report for a specific student
    // by passing both the student id and term id
    public function semesterReport($student, $semester){

        try {
            $student = Student::findOrFail($student);
        } catch (ModelNotFoundException $e) {
            return response()->json(array('none' => 'No student found!'));
        }

        $semester = Semester::findOrFail($semester);
        $date = Score::date();
        $institution = Institution::where('id', 1)->first();

        $scores = \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->select('subjects.name as subject', 'subjects.id as subject_id', 'terms.name as term', 'score')
            ->where('scores.student_id', $student->id)
            ->where('terms.semester_id', $semester->id)
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


        return \View::make('scores.partials.semester-report')->with(array(
            'student'=>$student, 
            'terms'=>$terms,
            'date'=>$date,
            'semester'=>$semester,
            'scoreTable'=>$scoreTable,
            'institution' => $institution
        ));
    }

    public function annualReport($student)
    {

        try {
            $student = Student::findOrFail($student);
        } catch (ModelNotFoundException $e) {
            return response()->json(array('none' => 'No student found!'));
        }
        

        $date = Score::date();
        $institution = Institution::where('id', 1)->first();

        $scores = \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->select('subjects.name as subject', 'subjects.id as subject_id', 'terms.name as term', 'score')
            ->where('scores.student_id', $student->id)
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

        return \View::make('scores.partials.annual-report')->with(array(
            'student'=>$student, 
            'terms'=>$terms,
            'date'=>$date,
            'scoreTable'=>$scoreTable,
            'institution' => $institution
        ));
        
    }

    // this function returns a student cummulated semester avb
    // It does that by first getting all the periodic averages and then
    // calculate the student semester average from there
    public static function semesterAvg($student, $semester)
    {

        // getting only the terms within the selected semester
        $terms_average = Term::all()->where('semester_id', $semester);

        //Our array, which will contains all the terms averages
        $termAverages = array();

        foreach ($terms_average as $term) {

            //add all the term averages to our array
            array_push($termAverages, Score::periodicAvg($term->id, $student));
        }

        // after pushing all the terms average to the array
        // it is possible that some null values are send. In order to calculate the average
        // we have to filter out all the null and pass elements of the array that are not null
        $filter_terms_average = array_filter($termAverages);

        // I had to applied some logic on the count of the array. If not an 
        // division by zero error is caught and the program doesn't know what to do. To avoid that
        // I return null if the count of the filter array is zero or less
        if (count($filter_terms_average) > 0) {
            //Calculate the average. based on the values in our $termAverages array
            $semester_avg = array_sum($filter_terms_average) / count($filter_terms_average);

            //return the semester average
            return $semester_avg;
        } else {
            return null;
        }
        
    }

    public static function annualAvg($student)
    {
        $terms_average = Term::all();
        $termAverages = array();

        foreach ($terms_average as $term) {

            //add all the term averages to our array
            array_push($termAverages, Score::periodicAvg($term->id, $student));
        }

        $filter_terms_average = array_filter($termAverages);

        if (count($filter_terms_average) > 0) {
            //Calculate the average. based on the values in our $termAverages array
            $annual_avg = array_sum($filter_terms_average) / count($filter_terms_average);

            //return the semester average
            return $annual_avg;
        } else {
            return null;
        }
    }

    // this function list all the periodic averages in the semester grade/score sheet
    public static function periodicAvg($term, $student)
    {
        return  \DB::table('scores')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->where('scores.student_id', $student)
            ->where('scores.term_id', $term)
            ->avg('score');
    }

    // this function takes a subject name, finds its id and then query out
    // the subject average for the selected semester
    public static function subjectAvg($subject, $student, $semester)
    {

        $subject_id = Subject::where('name', $subject)->pluck('id');
        //dd($subject);

        return \DB::table('scores')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->where('subjects.id', $subject_id)
            ->where('scores.student_id', $student)
            ->where('terms.semester_id', $semester)
            ->avg('score');
    }

    public static function subjectAnnualAvg($subject, $student)
    {
        $subject_id = Subject::where('name', $subject)->pluck('id');
        //dd($subject);

        return \DB::table('scores')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->where('subjects.id', $subject_id)
            ->where('scores.student_id', $student)
            ->avg('score');
    }

}
