<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    //
	protected $fillable = ['name'];

    // a many to many relationship for division and subjects
    public function subject()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function grade()
    {
        return $this->hasMany(Grade::class);
    }
}
