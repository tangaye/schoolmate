<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer(['admin.students.create', 'user.students.create'], function ($view){
            $counties = \App\Student::counties();
            $religions = \App\Student::religions();
            $guardians = \App\Guardian::all();
            $view->with(compact('counties', 'religions', 'guardians'));

        });

        view()->composer(['admin.students.edit', 'user.students.edit'], function ($view){
            $genders = \App\Common::genders();
            $counties = \App\Student::counties();
            $religions = \App\Student::religions();
            $guardians = \App\Guardian::all();
            $view->with(compact('types', 'counties', 'genders', 'religions', 'guardians'));
        });

        view()->composer('layouts.sidebar', function ($view){
            
            $institution = \App\Institution::findOrFail(1);
            //dd($guardians);
            $view->with(compact('institution'));
        });

        view()->composer('layouts.header', function ($view){
            
            $academics = new \App\Academic;
            $current_academic = $academics->current();
            $view->with(compact('current_academic'));
        });

        view()->composer(['layouts.partials.stats-bar','admin.institution.edit'], function ($view){
            
            $students_total = \App\Repositories\StudentsRepository::students_count();
            $guardians_total = \App\Guardian::guardians_count();
            $teachers_total = \App\Repositories\TeachersRepository::teachers_count();
            $users_total = \App\User::users_count();
            $view->with(compact('students_total', 'guardians_total', 'teachers_total', 'users_total'));
        });


        // customize the field name lenth to allow about 191 characters
        // mainly for heroku cleardb
        Schema::defaultStringLength(191);

        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
