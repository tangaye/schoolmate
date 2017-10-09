<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeTeacher extends Model
{
    //
    protected $fillable = ['grade_id', 'subject_id', 'teacher_id'];

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

    public static function gradeTeachers(){
        return \DB::table('grade_teachers')
                ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
                ->join('subjects', 'subjects.id', '=', 'grade_teachers.subject_id')
                ->join('grades', 'grades.id', '=', 'grade_teachers.grade_id')
                ->select(
                    'subjects.name as subject', 
                    'grades.name as grade', 
                    'teachers.surname', 
                    'teachers.first_name', 
                    'grade_teachers.id as id'
                )
                ->get();
    }

    
}


