<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected $fillable = ['name', 'grade_id'];


    // a many to many relationship for grades/class and subjects
    public function grade()
    {
        return $this->belongsToMany(Grade::class);
    }

    public function score()
    {
        return $this->hasMany(Score::class);
    }


}
