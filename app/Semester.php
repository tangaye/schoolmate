<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Term;

class Semester extends Model
{
    //
	protected $fillable = ['name'];

	// a semester has many terms
	// e.x 1st period, 2nd period and 3rd are all
	// within 1st semester
    public function term()
    {
    	return $this->hasMany(Term::class);
    }
}
