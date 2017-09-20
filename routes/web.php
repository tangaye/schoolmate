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
Route::get('/home', 'HomeController@index')->name('user.dashboard');

Route::get('/admin', 'AdminController@index')->name('admin.dashboard');
Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');


Route::get('/guardian', 'GuardianController@index')->name('guardian.dashboard');
Route::get('/guardian/login', 'Auth\GuardianLoginController@showLoginForm')->name('guardian.login');
Route::post('/guardian/login', 'Auth\GuardianLoginController@login')->name('guardian.login.submit');


// the routes below have gates and polices assigned to them as to what a user
// can do with a given student resource
Route::group(['prefix' => 'users/students',  'middleware' => 'auth:web'], function()
{
    Route::get('/', 'StudentsController@index');

    Route::get('create', 'StudentsController@create')
    	->middleware('can:create-student');

    Route::post('/', 'StudentsController@store')
    	->middleware('can:create-student');

    Route::get('edit/{id}', 'StudentsController@edit')
    	->middleware('can:edit-student');

    Route::put('update/{id}', 'StudentsController@update')
    	->middleware('can:edit-student');

    Route::delete('delete/{id}', 'StudentsController@destroy')
    	->middleware('can:delete-student');
});

Route::group(['prefix' => 'users/scores', 'middleware' => 'auth:web'], function () {
	Route::get('/', 'ScoresController@index');
	Route::get('terms', 'ScoresController@scoreTerm');
});

// the routes below have gates and polices assigned to them as to what a user
// can do with a given guardian resource
Route::group(['prefix' => 'users/guardians',  'middleware' => 'auth:web'], function()
{
    Route::get('/', 'Admin\GuardiansController@index');

    Route::get('create', 'Admin\GuardiansController@create')
    	->middleware('can:create-guardian');

    Route::post('/', 'Admin\GuardiansController@store')
    	->middleware('can:create-guardian');

    Route::get('edit/{id}', 'Admin\GuardiansController@edit')
    	->middleware('can:edit-guardian');

    Route::put('update/{id}', 'Admin\GuardiansController@update')
    	->middleware('can:edit-guardian');
});

Route::group(['middleware' => ['auth:admin', 'preventBackHistory']], function() {
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

	//school information
	Route::get('/institution', 'InstitutionController@index');
	Route::post('/institution', 'InstitutionController@store');
	Route::put('/institution/update/{id}', 'InstitutionController@update');

	//school academic information
	Route::get('/academics', 'AcademicsController@index');
	Route::get('/academics/edit/{id}', 'AcademicsController@edit');
	Route::post('/academics', 'AcademicsController@store');
	Route::put('/academics/update/{id}', 'AcademicsController@update');
	Route::delete('/academics/delete/{id}', 'AcademicsController@destroy');


	Route::get('/academics/start/{date}', 'AcademicsController@findStartYear');
	Route::get('/academics/end/{date}', 'AcademicsController@findEndYear');

	Route::get('/academics/edit-start/{id}/{date}', 'AcademicsController@findEditStartYear');
	Route::get('/academics/edit-end/{id}/{date}', 'AcademicsController@findEditEndYear');

	//guardian
	Route::get('/admin/guardians', 'Admin\GuardiansController@index')->name('guardians.home');
	Route::get('/admin/guardians/edit/{id}', 'Admin\GuardiansController@edit');
	Route::get('/admin/guardians/create', 'Admin\GuardiansController@create')->name('guardians.form');
	Route::post('/admin/guardians', 'Admin\GuardiansController@store')->name('guardians.create');
	Route::put('/admin/guardians/update/{id}', 'Admin\GuardiansController@update');
	Route::delete('/admin/guardians/delete/{id}', 'Admin\GuardiansController@destroy');

	//users
	Route::get('/admin/users', 'Admin\UsersController@index')->name('users.home');
	Route::get('/admin/users/create', 'Admin\UsersController@create')->name('users.form');
	Route::post('/admin/users', 'Admin\UsersController@store')->name('users.create');
	Route::get('/admin/users/edit/{id}', 'Admin\UsersController@edit');
	Route::put('/admin/users/update/{id}', 'Admin\UsersController@update');
	Route::delete('/admin/users/delete/{id}', 'Admin\UsersController@destroy');

	//roles
	Route::get('/roles', 'RolesController@index')->name('roles.home');
	Route::get('/roles/create', 'RolesController@create')->name('roles.form');
	Route::post('/roles', 'RolesController@store')->name('roles.create');
	Route::get('/roles/edit/{id}', 'RolesController@edit');
	Route::put('/roles/update/{id}', 'RolesController@update');
	Route::delete('/roles/delete/{id}', 'RolesController@destroy');

});



Route::group(['middleware' => ['auth:guardian', 'preventBackHistory']], function() {
    // your routes

    //subject
	Route::get('/guardian/students/term', 'GuardianController@termForm');
	Route::post('/guardian/students/term', 'GuardianController@termResults');

	Route::get('/guardian/students/semester', 'GuardianController@semesterForm');
	Route::post('/guardian/students/semester', 'GuardianController@semesterResults');
	
});
