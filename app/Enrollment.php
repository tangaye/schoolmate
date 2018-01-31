<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Academic;
use Carbon\Carbon;


class Enrollment extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 
        'last_grade',
        'current_grade',
        'student_type',
        'enrollment_status',
        'academic_id'
    ];

    // relationship between enrollment and a student last grade
    public function past_grade()
    {
    	return $this->belongsTo(Grade::class, 'last_grade');
    }

    // relationship between enrollment and a student current grade
    public function present_grade()
    {
        return $this->belongsTo(Grade::class, 'current_grade');
    }

    // relationship between student and enrollment
    public function students()
    {
    	return $this->belongsTo(Student::class);
    }

    // relationship between academic and enrollment
    public function academic()
    {
    	return $this->belongsTo(Academic::class);
    }

   
}
