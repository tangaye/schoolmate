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
        view()->composer('students.create', function ($view){
            $counties = \App\Student::counties();
            $religions = \App\Student::religions();
            $view->with(compact('counties', 'religions'));

        });

        view()->composer('students.edit', function ($view){
            $types = \App\Student::types();
            $genders = \App\Student::genders();
            $counties = \App\Student::counties();
            $religions = \App\Student::religions();
            $view->with(compact('types', 'counties', 'genders', 'religions'));
        });

        view()->composer('guardian-dashboard', function ($view){
            
            $guardians = \App\Guardian::with('student')->where('guardians.id', Auth::user()->data->id)->get();

            //dd($guardians);
            $view->with(compact('guardians'));
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
