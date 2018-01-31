<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Repositories\TeachersRepository;


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

    // this helps get a readable format for the date of birth field
    protected $dates = ['date_of_birth'];

    public function setDateOfBirthAttribute($value)
    {
       return $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function gradesTeacher()
    {
        return $this->hasMany(GradeTeacher::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->surname}";

    }

    public function sponsor_grade()
    {
        return $this->hasMany(GradeSponsor::class);
    }

    public function grade_sponsoring()
    {
        $teacherRepo = new TeachersRepository();
        return $teacherRepo->sponsoring($this->id);
    }


}
