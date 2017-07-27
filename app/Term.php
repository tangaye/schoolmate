<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    //
    protected $fillable = ['name', 'semester_id'];

    // term belongs to a single semester
    // e.x 1st period is only within 1st semester
    public function semester()
    {
    	return $this->belongsTo(Semester::class);
    }

    public function score()
    {
        return $this->hasMany(Score::class);
    }
}
