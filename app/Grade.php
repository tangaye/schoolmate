<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
