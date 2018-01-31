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

    //This returns true if a logged in user can perform any operation
    //on a guardian
    public function canAccessGuardians()
    {
        if ($this->can('create-guardian') || $this->can('update-guardian') || $this->can('delete-guardian') || $this->can('view-guardian')) {
            return true;
        } else {
            return false;
        }
    }

    //This returns true if a logged in user can perform any operation
    //on a student
    public function canAccessStudents()
    {
        if ($this->can('create-student') || $this->can('update-student') || $this->can('delete-student') || $this->can('view-student')) {
            return true;
        } else {
            return false;
        }
    }


    //This returns true if a logged in user can perform any operation
    //on students scores
    public function canAccessScores()
    {
        if ($this->can('view-scores')) {
            return true;
        } else {
            return false;
        }
    }
}
