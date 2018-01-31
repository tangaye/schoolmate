<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeSponsor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id', 'grade_id', 'academic_id'
    ];

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }

    public function grade()
    {
    	return $this->belongsTo(Grade::class);
    }

    public function academic()
    {
    	return $this->belongsTo(Academic::class);
    }
}
