<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guardian extends Authenticatable
{
    use Notifiable;

    protected $guard = 'guardian';
    //
    protected $fillable = [
        'first_name',
        'surname',
        'gender',
        'address',
        'phone',
        'email',
        'relationship', 
        'password',
    ];

	// relationship between student and guardian
    // a guardian may have many students
    public function student()
    {
    	return $this->hasMany(Student::class);
    }

    public static function relationships()
    {
        return [
            'Father',
            'Mother',
            'Uncle',
            'Brother',
            'Sister',
            'Grand Father',
            'Grand Mother'
        ];
    }

    public static function genders()
    {
        return [
            "Male", 
            "Female"
        ];
    }

}
