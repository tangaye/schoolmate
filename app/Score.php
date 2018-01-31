<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use App\Term;
use App\Subject;

class Score extends Model
{
    //
	protected $fillable = ['student_id', 'subject_id', 'grade_id', 'term_id', 'score', 'academic_id'];

     // define relationship and select only values that I want to use
    public function student()
    {
        return $this->belongsTo(Student::class)->select(['id', 'student_code', 'first_name', 'surname']);
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
}
