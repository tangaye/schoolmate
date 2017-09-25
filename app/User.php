<?php

namespace App;

use Carbon\Carbon;
use App\Role;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $guard = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gender',
        'address',
        'phone',
        'user_name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // a user has only one role or belongs to a single row
    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public static function genders()
    {
        return [
            "Male", 
            "Female"
        ];
    }


    public function hasAccess(array $permissions)
    {
        if ($this->role->hasAccess($permissions)) {
            return true;
        }
        return false;
    }

    // gets the total number of users
    public static function users_count()
    {
        return User::count();
    }
}
