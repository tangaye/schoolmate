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

// user login view
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/users', 'UsersController@index')->name('user.dashboard');
Route::post('users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

// routes for admin login and dashboard
Route::group(['prefix' => 'admin'], function () {
	Route::get('/', 'AdminController@index')->name('admin.dashboard');
	Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::post('logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});



// routes for teacher login and dashboard
Route::group(['prefix' => 'teacher'], function () {
	Route::get('/', 'TeachersController@index')->name('teacher.dashboard');
	Route::get('login', 'Auth\TeacherLoginController@showLoginForm')->name('teacher.login');
	Route::post('login', 'Auth\TeacherLoginController@login')->name('teacher.login.submit');
	Route::post('logout', 'Auth\TeacherLoginController@logout')->name('teacher.logout');

	// routes teacher uses to access scores resources
	Route::get('/scores', 'Teacher\ScoresController@index')->name('teacher.scores-home');
	Route::get('/manage-scores', 'Teacher\ScoresController@master')->name('teacher.manage-scores');
	Route::get('/grade-subjects/{id}', 'Teacher\ScoresController@gradeSubjects');
	Route::get('/manage-scores/create', 'Teacher\ScoresController@create');
	Route::post('/manage-scores', 'Teacher\ScoresController@store' );

	Route::get('/students-scores', 'Teacher\ScoresController@studentsScores');
});

//charts
Route::group(['prefix' => 'charts'], function () {
	Route::get('gender', 'ChartsController@genderChart')->name('charts.gender');
	Route::get('grades', 'ChartsController@gradesChart')->name('charts.grades');
});



// the routes below have gates and polices assigned to them as to what a user
// can do with a given student resource
Route::group(['prefix' => 'users/students',  'middleware' => 'auth:web'], function()
{
    Route::get('/', 'User\StudentsController@index');

    Route::get('create', 'User\StudentsController@create')
    	->middleware('can:create-student');

    Route::post('/', 'User\StudentsController@store')
    	->middleware('can:create-student');

    Route::get('edit/{id}', 'User\StudentsController@edit')
    	->middleware('can:view-student');

    Route::put('update/{id}', 'User\StudentsController@update')
    	->middleware('can:update-student');

    Route::delete('delete/{id}', 'User\StudentsController@destroy')
    	->middleware('can:delete-student');
});

Route::group(['prefix' => 'users/scores', 'middleware' => 'auth:web'], function () {
	Route::get('/', 'User\ScoresController@index');
	Route::get('terms', 'User\ScoresController@scoreTerm');
});

// the routes below have gates and polices assigned to them as to what a user
// can do with a given guardian resource
Route::group(['prefix' => 'users/guardians',  'middleware' => 'auth:web'], function()
{
    Route::get('/', 'User\GuardiansController@index');

    Route::get('create', 'User\GuardiansController@create')
    	->middleware('can:create-guardian');

    Route::post('/', 'User\GuardiansController@store')
    	->middleware('can:create-guardian');

    Route::get('edit/{id}', 'User\GuardiansController@edit')
    	->middleware('can:view-guardian');

    Route::put('update/{id}', 'User\GuardiansController@update')
    	->middleware('can:update-guardian');
});

// routes that are only accessible to admin
Route::group(['middleware' => ['auth:admin', 'preventBackHistory']], function() {

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

	// query out subjects assigned to a grade or class
	Route::get('/grades/grade-subjects/{id}', 'GradesController@gradeSubjects');

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

	Route::get('/scores/report/annual', 'ScoresController@annual')->name('annual-scores');
	Route::post('/scores/report/annual', 'ScoresController@findAnnual')->name('find.annual-scores');

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

	//teacher
	Route::group(['prefix' => '/admin/teachers'], function () {
		Route::get('/', 'Admin\TeachersController@index')->name('teachers.home');
		Route::get('edit/{id}', 'Admin\TeachersController@edit');
		Route::get('create', 'Admin\TeachersController@create')->name('teachers.form');
		Route::post('/', 'Admin\TeachersController@store')->name('teachers.create');
		Route::put('update/{id}', 'Admin\TeachersController@update');
		Route::delete('delete/{id}', 'Admin\TeachersController@destroy');
	});

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

	// grades teachers
	Route::group(['prefix' => '/grades-teacher'], function (){
		Route::get('/', 'GradesTeacherController@index')->name('admin-gradesTeacher.home');
		Route::get('create', 'GradesTeacherController@create')->name('admin-gradesTeacher.form');
		Route::post('/', 'GradesTeacherController@store')->name('admin-gradesTeacher.submit');
		Route::delete('/delete/{id}', 'GradesTeacherController@destroy');
	});
});

// routes for guardian login and dashboard
Route::group(['prefix' => 'guardian'], function () {
	Route::get('/', 'GuardianController@index')->name('guardian.dashboard');
	Route::get('login', 'Auth\GuardianLoginController@showLoginForm')->name('guardian.login');
	Route::post('login', 'Auth\GuardianLoginController@login')->name('guardian.login.submit');
	Route::post('logout', 'Auth\GuardianLoginController@logout')->name('guardian.logout');
});

//routes that are only accessible to guardian
Route::group(['prefix' => '/guardian/students'], function() {

	Route::get('term', 'GuardianController@termForm');
	Route::post('term', 'GuardianController@termResults');

	Route::get('semester', 'GuardianController@semesterForm');
	Route::post('semester', 'GuardianController@semesterResults');

	Route::get('annual', 'GuardianController@annualForm');
	Route::post('annual', 'GuardianController@annualResults');
	
});
