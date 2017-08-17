<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'surname',
        'date_of_birth',
        'gender',
        'education',
        'address',
        'phone',
        'country',
        'user_name',
        'email',
        'type',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setDateOfBirthAttribute($value)
    {
       return $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    // this helps get a readable format for the date of birth field
    protected $dates = ['date_of_birth'];

    public function data()
    {
        return $this->hasOne($this->type);
    }

    /**
     * Check if this user belongs to a role
     *
     * @return bool
     */
    public function hasType($type)
    {
        return $this->type == $type;
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

    public static function roles()
    {
        return [
            'admin',
            'registrar',
            'secretary'
        ];
    }

    public static function genders()
    {
        return [
            "Male", 
            "Female"
        ];
    }

    public static function educations()
    {
        return [
            "Bsc", 
            "High School Diploma"
        ];
    }
}
