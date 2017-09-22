<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;


class Role extends Model
{
    //
    protected $fillable = ['name', 'description', 'permissions'];

    protected $casts = [
    	'permissions' => 'array',
    ];

    // a role has only one user
    public function user()
    {
    	return $this->hasOne(User::class);
    }

    public function hasAccess(array $permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    private function hasPermission(string $permission)
    {
        return $this->permissions[$permission] ?? false;
    }

    public static function permissions()
    {
        return [
            "create-student" => "true",
            "show-student" => "true",
            "delete-student" => "true",
            "update-student" => "true",
            "show-guardian" => "true",
            "create-guardian" => "true", 
            "delete-guardian" => "true",
            "update-guardian" => "true",
        ];
    }
}
