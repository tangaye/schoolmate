<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

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
        view()->composer(['students.create', 'user-students.create'], function ($view){
            $counties = \App\Student::counties();
            $religions = \App\Student::religions();
            $grades =  \App\Grade::all();
            $guardians = \App\Guardian::all();
            $view->with(compact('counties', 'religions', 'guardians', 'grades'));

        });

        view()->composer(['students.edit', 'user-students.edit'], function ($view){
            $types = \App\Student::types();
            $genders = \App\Common::genders();
            $counties = \App\Student::counties();
            $religions = \App\Student::religions();
            $grades =  \App\Grade::all();
            $guardians = \App\Guardian::all();
            $view->with(compact('types', 'counties', 'genders', 'religions', 'grades', 'guardians'));
        });

        view()->composer('layouts.sidebar', function ($view){
            
            $institution = \App\Institution::findOrFail(1);
            //dd($guardians);
            $view->with(compact('institution'));
        });

        view()->composer('layouts.header', function ($view){
            
            $academics = \App\Academic::where('status', 1)->get();
            //dd($academic->status);
            $view->with(compact('academics'));
        });

        
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
