<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Academic extends Model
{
    //
    protected $fillable = [
        'date_start',
    	'date_end',
    	'status'
    ];

    // this helps get a readable format for the date of birth field
    protected $casts = [
        'date_start' => 'date', 
        'date_end' => 'date'
    ];

    //protected $dateFormat = 'Y/m/d';

    public function setDateStartAttribute($value)
    {
        //dd($value);
        $this->attributes['date_start'] = Carbon::createFromFormat('Y/m/d', $value);
    }

    public function setDateEndAttribute($value)
    {
        $this->attributes['date_end'] = Carbon::createFromFormat('Y/m/d', $value);
    }



    public static function statuses()
    {
        return [
            "Active" => 1, 
            "Inactive" => 0
        ];
    }
}
