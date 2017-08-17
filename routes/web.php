<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// user registration

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/errors/unauthorized', 'ErrorsController@unauthorized');

Route::group(['middleware' => ['auth', 'admin', 'preventBackHistory']], function() {
    // your routes

    //subject
	Route::get('/subjects', 'SubjectsController@index');
	Route::post('/subjects', 'SubjectsController@store');
	Route::delete('/subjects/delete/{id}', 'SubjectsController@destroy');
	Route::get('/subjects/edit/{id}', 'SubjectsController@edit');
	Route::put('/subjects/update/{id}', 'SubjectsController@update');

	//division
	Route::get('/divisions', 'DivisionsController@index');
	Route::post('/divisions', 'DivisionsController@store');
	Route::put('/divisions/update/{id}', 'DivisionsController@update');
	Route::delete('/divisions/delete/{id}', 'DivisionsController@destroy');

	//grade/class
	Route::get('/grades', 'GradesController@index');
	Route::post('/grades', 'GradesController@store');
	Route::get('/grades/edit/{id}', 'GradesController@edit');
	Route::put('/grades/update/{id}', 'GradesController@update');
	Route::delete('/grades/delete/{id}', 'GradesController@destroy');

	//student
	Route::get('/students', 'StudentsController@index');
	Route::get('/students/create', 'StudentsController@create');
	Route::post('/students', 'StudentsController@store');
	Route::get('/students/edit/{id}', 'StudentsController@edit');
	Route::put('/students/update/{id}', 'StudentsController@update');
	Route::delete('/students/delete/{id}', 'StudentsController@destroy');

	//semester
	Route::get('/semesters', 'SemestersController@index');
	Route::post('/semesters', 'SemestersController@store');
	Route::put('/semesters/update/{id}', 'SemestersController@update');
	Route::delete('/semesters/delete/{id}', 'SemestersController@destroy');

	//term
	Route::get('/terms', 'TermsController@index');
	Route::post('/terms', 'TermsController@store');
	Route::get('/terms/edit/{id}', 'TermsController@edit');
	Route::put('/terms/update/{id}', 'TermsController@update');
	Route::delete('/terms/delete/{id}', 'TermsController@destroy');

	//scores
	Route::get('/scores', 'ScoresController@index');
	Route::get('/scores/terms', 'ScoresController@scoreTerm'); // display score table for each term/period
	Route::put('/scores/terms/update/{id}', 'ScoresController@update'); // update term score
	Route::delete('/scores/terms/delete/{id}', 'ScoresController@destroy'); // update term score

	Route::get('/scores/master', 'ScoresController@master'); // show form to generate master grade sheet
	Route::get('/scores/master/create', 'ScoresController@create'); // show form to enter student score
	Route::post('/scores', 'ScoresController@store');

	Route::get('/scores/report/terms', 'ScoresController@term'); // display form to search for student report

	Route::post('/scores/report/terms', 'ScoresController@findTerm'); // send data and return student term report
	
	Route::get('/scores/report/semesters', 'ScoresController@semester'); // display form to search for student report
	Route::post('/scores/report/semesters', 'ScoresController@findSemester'); // send data and return student semester report

	//guardian
	Route::get('/guardians', 'GuardiansController@index');
	Route::get('/guardians/edit/{id}', 'GuardiansController@edit');
	Route::put('/guardians/update/{id}', 'GuardiansController@update');

	//users
	Route::get('/users', 'UsersController@index');
	Route::get('/users/edit/{id}', 'UsersController@edit');
	Route::put('/users/update/{id}', 'UsersController@update');
	Route::delete('/users/delete/{id}', 'UsersController@destroy');

});



Route::group(['middleware' => ['auth', 'guardian', 'preventBackHistory']], function() {
    // your routes

    //subject
	Route::get('/guardian/students/term', 'GuardiansController@termForm');
	Route::post('/guardian/students/term', 'GuardiansController@termResults');

	Route::get('/guardian/students/semester', 'GuardiansController@semesterForm');
	Route::post('/guardian/students/semester', 'GuardiansController@semesterResults');
	
});
