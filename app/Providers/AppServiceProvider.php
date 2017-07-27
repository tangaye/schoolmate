<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
