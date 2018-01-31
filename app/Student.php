<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

use App\Score;
use App\Repositories\StudentsRepository;

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
    	'last_school',
        'last_school_address',
        'principal_name',
        'principal_number',
        'father_name',
        'father_address',
        'father_number',
        'mother_name',
        'mother_address',
        'mother_number',
        'photo',
        'guardian_id',
        'admission_date'
    ];



    public static function religions()
    {
        return [
            "Choose not to mention" => "",
            "Of no religion" => "none",
            "Christian" => "Christian",
            "Muslim" => "Muslim",
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
    protected $dates = ['date_of_birth', 'admission_date'];

    public function setDateOfBirthAttribute($value)
    {
       return $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setAdmissionDateAttribute($value)
    {
       return $this->attributes['admission_date'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    // this returns the student current age,
    public function age() {
        return $this->date_of_birth->diffInYears(Carbon::now());
    }


    // relationship between student and guardian
    // a student belongs to a single guardian
    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }
    

    // relationship between student and scores
    // a student has many scores
    public function score()
    {
        return $this->hasMany(Score::class);
    }

    // relationship between student and enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }


    // student attendence relation
    // a student has many attendence records
    public function attendence()
    {
        return $this->hasMany(Attendence::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->surname}";

    }

    public function getAttendencePeriodAttribute()  
    {
        $studentRepo = new StudentsRepository();
        return $studentRepo->period_of_attendence($this->id);
    }
    

}
