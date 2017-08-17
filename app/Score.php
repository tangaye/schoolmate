<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;



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

    // this function fetches a particular term/ period table by accepting
    // the id of the term/period table
    public function termTables($id){
        return \DB::table('scores')
                ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
                ->join('terms', 'terms.id', '=', 'scores.term_id')
                ->join('grades', 'grades.id', '=', 'scores.grade_id')
                ->join('students', 'students.id', '=', 'scores.student_id')
                ->select(
                    'subjects.name as subject', 
                    'grades.name as grade', 
                    'students.surname', 
                    'students.first_name', 
                    'terms.name as term', 
                    'scores.id as score_id',
                    'scores.student_id', 
                    'scores.grade_id',
                    'scores.subject_id',
                    'scores.term_id',  
                    'score'
                )
                ->where('scores.term_id', $id)
                ->get();
    }

    // this function fetches the a term/period report report for a specific student
    // by passing both the student id and term id
    public function termReport($term, $student){

        $student = Student::findOrFail($student);
        $term = Term::findOrFail($term);
        $date = Score::date();

        $scores = \DB::table('scores')
                ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
                ->join('terms', 'terms.id', '=', 'scores.term_id')
                ->join('grades', 'grades.id', '=', 'scores.grade_id')
                ->join('students', 'students.id', '=', 'scores.student_id')
                ->select('subjects.name as subject', 'score')
                ->where('scores.student_id', $student->id)
                ->where('scores.term_id', $term->id)
                ->get();

        return \View::make('partials.term-report')->with(array(
            'student'=>$student, 
            'term'=>$term,
            'date'=>$date,
            'scores'=>$scores
        ));
    }

    // this function fetches the a term/period report report for a specific student
    // by passing both the student id and term id
    public function semesterReport($student, $semester){

        $student = Student::findOrFail($student);
        $semester = Semester::findOrFail($semester);
        $date = Score::date();

        $scores = \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->select('subjects.name as subject', 'terms.name as term', 'score')
            ->where('scores.student_id', $student->id)
            ->where('terms.semester_id', $semester->id)
            ->get();

        //dd($scores);

        $subjects = $scores->pluck('subject')->unique(); // ['Mathematics', 'Biology']
        $terms    = Term::where('semester_id', $semester->id)->pluck('name'); 

        $scoreTable = [];
        foreach ($subjects as $subject) {
            foreach ($terms as $term) {
                $scoreTable[$subject][$term] = '';
            }
        }

        foreach ($scores as $row) {
            $scoreTable[$row->subject][$row->term] = $row->score;
        }


        return \View::make('partials.semester-report')->with(array(
            'student'=>$student, 
            'terms'=>$terms,
            'date'=>$date,
            'semester'=>$semester->name,
            'scoreTable'=>$scoreTable
        ));
    }
}
