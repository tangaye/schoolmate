<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Academic extends Model
{
    //
    protected $fillable = [
        'year_start',
    	'year_end',
    	'status'
    ];


    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }



    public static function statuses()
    {
        return [
            "Active" => 1, 
            "Inactive" => 0
        ];
    }

    protected $casts = [
        'status' => 'boolean'
    ];

    // returns the active or current academic year.
    public function current()
    {
        return $this->where('status', 1)->first();
    }

    public function getFullYearAttribute()
    {
        return "{$this->year_start}/{$this->year_end}";
    }
}
