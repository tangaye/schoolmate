<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    //
    protected $fillable = ['relationship', 'user_id'];

	// relationship between student and guardian
    // a guardian may have many students
    public function student()
    {
    	return $this->hasMany(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
