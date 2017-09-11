<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Institution extends Model
{
    //

    protected $fillable = [
        'name',
    	'address',
    	'email',
    	'phone',
        'motto',
    	'date_established',
    	'logo'
    ];

    // this helps get a readable format for the date of birth field
    protected $dates = ['date_established'];

    public function setDateEstablishedAttribute($value)
    {
       return $this->attributes['date_established'] = Carbon::createFromFormat('d/m/Y', $value);
    }
}
