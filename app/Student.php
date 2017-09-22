<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\Score;

class Student extends Model
{
    //

    protected $fillable = [
        'student_code',
    	'first_name',
    	'middle_name',
    	'surname',
    	'date_of_birth',
    	'gender',
    	'address',
    	'phone',
    	'county',
    	'country',
    	'religion',
    	'student_type',
    	'last_school',
    	'last_grade',
    	'grade_id',
        'photo',
        'guardian_id'
    ];


    public static function types()
    {
        return [
            "Old Student", 
            "New Student"
        ];
    }

    public static function religions()
    {
        return [
            "Choose not to mention" => "",
            "Of no religion" => "none",
            "Christian" => "Christian", 
            "Adventist" => "Adventist",
            "Muslim" => "Muslim",
            "Bahai Faith" => "Bahai Faith",
            "Jehovah Witness" => "Jehovah Witness"
        ];
    }

    public static function counties()
    {
        return [
            "Chose county" => "", 
            "Nimba" => "Nimba", 
            "Montserrado" => "Montserrado",
            "Grand Cape Mount" => "Grand Cape Mount", 
            "Gbarpolu" => "Gbarpolu", 
            "Sinoe" => "Sinoe",
            "Bomi" => "Bomi",
            "Grand Bassa" => "Grand Bassa",
            "Rivergee" => "Rivergee",
            "Rivercess" => "Rivercess",
            "Margibi" => "Margibi",
            "Maryland" => "Maryland",
            "Bong" => "Bong",
            "Lofa" =>"Lofa",
            "Grand Kru" => "Grand Kru"
        ];
    }



    // this helps get a readable format for the date of birth field
    protected $dates = ['date_of_birth'];

    public function setDateOfBirthAttribute($value)
    {
       return $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    // this returns the student current age,
    public function age() {
        return $this->date_of_birth->diffInYears(Carbon::now());
    }


    // relationship between student and grade/class
    // each student has a single grade
    public function grade()
    {
    	return $this->belongsTo(Grade::class);
    }

    // relationship between student and guardian
    // a student belongs to a single guardian
    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }
    

    public function score()
    {
        return $this->hasMany(Score::class);
    }

    
}
