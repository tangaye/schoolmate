<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerStudentsPolicies();
        $this->registerGuardiansPolicies();

        //
    }

    public function registerStudentsPolicies()
    {
        Gate::define('create-student', function($user) {
            return $user->hasAccess(['create-student']); 
        });

        Gate::define('view-student', function($user) {
            return $user->hasAccess(['view-student']); 
        });

        Gate::define('delete-student', function($user) {
            return $user->hasAccess(['delete-student']); 
        });

        Gate::define('update-student', function($user) {
            return $user->hasAccess(['update-student']); 
        });
    }

    public function registerGuardiansPolicies()
    {
        Gate::define('create-guardian', function($user) {
            return $user->hasAccess(['create-guardian']); 
        });

        Gate::define('view-guardian', function($user) {
            return $user->hasAccess(['view-guardian']); 
        });

        Gate::define('delete-guardian', function($user) {
            return $user->hasAccess(['delete-guardian']); 
        });

        Gate::define('update-guardian', function($user) {
            return $user->hasAccess(['update-guardian']); 
        });
    }
}
