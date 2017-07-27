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
}
