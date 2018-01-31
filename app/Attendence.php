<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendence extends Model
{
    //
     protected $fillable = [
        'student_id',
    	'subject_id',
    	'grade_id',
    	'date',
    	'status',
        'remarks',
        'academic_id'
    ];

    // relation between attendence and student.
    // each attendence record has a student
    public function student()
    {
        return $this->belongsTo(Student::class)->select(['id', 'student_code', 'first_name', 'middle_name', 'surname']);
    }

    // relation between attendence and subject.
    // each attendence record has a subject
    public function subject()
    {
        return $this->belongsTo(Subject::class)->select(['id', 'name']);
    }

    // relation between attendence and grade
    // each attendence record has a grade
    public function grade()
    {
        return $this->belongsTo(Grade::class)->select(['id','name']);
    }

    // this helps get a readable format for the date field
    protected $casts = [
        'date' => 'date', 
    ];

    public function setDateAttribute($value)
    {
        //dd($value);
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    

    
}
