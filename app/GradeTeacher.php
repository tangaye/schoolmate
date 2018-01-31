<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeTeacher extends Model
{
    //
    protected $fillable = ['grade_id', 'subject_id', 'teacher_id', 'academic_id'];

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
    	return $this->belongsTo(Subject::class);
    }

    public function grade()
    {
    	return $this->belongsTo(Grade::class);
    }
}


