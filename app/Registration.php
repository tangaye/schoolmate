<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
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

    // relationship between registration and grade/class
    public function grades()
    {
    	return $this->hasMany(Grade::class);
    }

    // relationship between student and registration
    public function students()
    {
    	return $this->belongsTo(Student::class);
    }

    // relationship between academic and registration
    public function academics()
    {
    	return $this->hasMany(Academic::class);
    }

    public static function types()
    {
        return [
            "Old Student", 
            "New Student"
        ];
    }
}
