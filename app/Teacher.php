<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class Teacher extends Authenticatable
{
	use Notifiable;

    protected $guard = 'teacher';

    protected $fillable = [
        'first_name',
        'surname',
        'gender',
        'date_of_birth',
        'qualification',
        'address',
        'phone',
        'user_name',
        'email',
        'password',
    ];

    // relationship between teacher and students
    // a teacher teaches many students
    public function students()
    {
    	return $this->hasMany(Student::class);
    }

    // relationship between teacher and grades
    // a teacher teaches many grades/classes
    public function grades()
    {
    	return $this->hasMany(Grade::class);
    }

    // relationship between teacher and subjects
    // a teacher teaches many subjects
    public function subjects()
    {
    	return $this->hasMany(Subject::class);
    }

    // this helps get a readable format for the date of birth field
    protected $dates = ['date_of_birth'];

    public function setDateOfBirthAttribute($value)
    {
       return $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    // gets the total number of teachers
    public static function teachers_count()
    {
        return Teacher::count();
    }

}
