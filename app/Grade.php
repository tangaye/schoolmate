<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grade extends Model
{
    //
    protected $fillable = ['name', 'division_id'];

    // relationship between grade and division
    // a class / grade belongs to a single division
    // e.x 12th is only within the senior high division
    public function division()
    {
    	return $this->belongsTo(Division::class);
    }

    // relationship between grade and student
    // a grade may have many students
    public function student()
    {
    	return $this->hasMany(Student::class);
    }

    public function score()
    {
        return $this->hasMany(\Score::class);
    }

    public static function grades_student_count()
    {
        return DB::table('grades')
            ->join('students', 'grades.id', '=', 'students.grade_id')
            ->select('grades.name as name', DB::raw('COUNT(students.id) as students'))
            ->groupBy('grades.name')
            ->orderBy(DB::raw('COUNT(students.id)'), 'desc')
            ->get();
    }
}
