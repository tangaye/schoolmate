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

    // relationship between grade and enrollment
    public function enrollments()
    {
    	return $this->hasMany(Enrollment::class);
    }

    public function score()
    {
        return $this->hasMany(Score::class);
    }

    // a many to many relationship for grades/class and subjects
    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    
}
