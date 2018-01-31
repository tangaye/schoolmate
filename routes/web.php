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




/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
// user login view
Route::get('/', function () {return view('auth.login');});

Auth::routes();
Route::post('users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
// routes that are only accessible to users
Route::group(['middleware' => ['auth:web', 'preventBackHistory']], function() {

	Route::get('/users', 'User\DashboardController@index')->name('user.dashboard');

	// the routes below have gates and polices assigned to them as to what a user
	// can do with a given student resource
	Route::group(['prefix' => 'users/students'], function()
	{
	    Route::get('/', 'User\StudentsController@index')
	    	->name('users.students')
	    	->middleware('can:view-student');

	    Route::get('create', 'User\StudentsController@create')
	    	->name('users.students.create')
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

	Route::group(['prefix' => 'users/scores'], function () {
		Route::get('/', 'User\ScoresController@index')
			->name('users.scores')
	    	->middleware('can:view-scores');
		Route::post('/students', 'User\ScoresController@studentScores');
	});

	// the routes below have gates and polices assigned to them as to what a user
	// can do with a given guardian resource
	Route::group(['prefix' => 'users/guardians'], function()
	{
	    Route::get('/', 'User\GuardiansController@index')
	    	->name('users.guardians')
	    	->middleware('can:view-guardian');

	    Route::get('create', 'User\GuardiansController@create')
	    	->name('users.guardians.create')
	    	->middleware('can:create-guardian');

	    Route::post('/', 'User\GuardiansController@store')
	    	->middleware('can:create-guardian');

	    Route::get('edit/{id}', 'User\GuardiansController@edit')
	    	->middleware('can:view-guardian');

	    Route::put('update/{id}', 'User\GuardiansController@update')
	    	->middleware('can:update-guardian');
	});
});



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// routes for admin login and dashboard
Route::group(['prefix' => 'admin'], function () {
	Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::post('logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});

// routes that are only accessible to admin
Route::group(['middleware' => ['auth:admin', 'preventBackHistory']], function() {

	Route::get('admin', 'Admin\DashboardController@index')->name('admin.dashboard');

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
	Route::group(['prefix' => '/students'], function (){
		Route::get('/', 'StudentsController@index')->name('students.home');
		Route::get('/create', 'StudentsController@create')->name('students.create');
		Route::post('/', 'StudentsController@store');
		Route::get('/edit/{id}', 'StudentsController@edit');
		Route::put('/update/{id}', 'StudentsController@update');
		Route::delete('/delete/{id}', 'StudentsController@destroy');
	});

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

	/*
	-----------------------------scores------------------------------
	*/
	Route::group(['prefix' => '/scores'], function (){

		Route::get('/', 'ScoresController@index');
		// display score table for each term/period
		Route::post('/students', 'ScoresController@studentScores');
		// update term score
		Route::put('/terms/update/{id}', 'ScoresController@update'); 
		Route::delete('/scores/terms/delete/{id}', 'ScoresController@destroy'); 
		//show form to generate master grade sheet
		Route::get('/master', 'ScoresController@master'); 
		// show form to enter or store student score
		Route::get('/master/create', 'ScoresController@create'); 
		Route::post('/', 'ScoresController@store');
		//This route passes the academic id and return a listing of students in the scores table
		//who has recored scores in for the academic year id passed
		Route::get('/academic-students/{id}', 'ScoresController@academicStudents');
	});

	/*
	-----------------------------scores report------------------------------
	*/
	Route::group(['prefix' => '/scores/report'], function (){
		// display form to search for student term report
		Route::get('/terms', 'ScoresReportController@term'); 
		// send data and return student term report
		Route::post('/terms', 'ScoresReportController@findTerm'); 
		// display form to search for student report
		Route::get('/semesters', 'ScoresReportController@semester');
		// send data and return student semester report 
		Route::post('/semesters', 'ScoresReportController@findSemester'); 
		Route::get('/annual', 'ScoresReportController@annual')->name('annual-scores');
		Route::post('/annual', 'ScoresReportController@findAnnual')->name('find.annual-scores');
	});
	

	//school information
	Route::get('/institution', 'InstitutionController@index');
	Route::post('/institution', 'InstitutionController@store');
	Route::put('/institution/update/{id}', 'InstitutionController@update');

	//school academic year information
	Route::group(['prefix' => '/academics'], function () {
		Route::get('/', 'AcademicsController@index')->name('academics.home');
		Route::get('/edit/{id}', 'AcademicsController@edit');
		Route::post('/', 'AcademicsController@store');
		Route::put('/update/{id}', 'AcademicsController@update');
		Route::delete('/delete/{id}', 'AcademicsController@destroy');


		Route::get('/start/{year}', 'AcademicsController@findStartYear');
		Route::get('/end/{year}', 'AcademicsController@findEndYear');

		Route::get('/edit-start/{id}/{date}', 'AcademicsController@findEditStartYear');
		Route::get('/edit-end/{id}/{date}', 'AcademicsController@findEditEndYear');
	});


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

		//Returns a listing of teachers who have grades and subjects assigned to them in a academic year
		Route::get('/academic/{year}', 'GradesTeacherController@academicTeacher');
		//Returns a view of the subjects and grades a teacher is teaching
		Route::post('/grade-subject', 'GradesTeacherController@teacherGradesAndSubjects');
	});

	//grades sponsors(teachers)
	Route::group(['prefix' => '/admin/sponsor'], function (){
		Route::get('/', 'GradesSponsorController@index')->name('admin.ponsor.home');
		Route::get('/{academic_year}', 'GradesSponsorController@academicSponsors');
		Route::post('/', 'GradesSponsorController@store');
		Route::get('/edit/{id}', 'GradesSponsorController@edit');
		Route::put('/update/{id}', 'GradesSponsorController@update');
		Route::delete('/delete/{id}', 'GradesSponsorController@destroy');
		//Returns a listing of teachers who are not sponsors of a grade.
		Route::post('/teachers', 'GradesSponsorController@notASponsor');
		Route::get('/grades/{teacher_id}', 'GradesSponsorController@teacherGrades');
	});


	// attendence
	Route::group(['prefix' => '/attendence'], function (){

		Route::get('/', 'AttendenceController@index')->name('attendence');
		Route::get('/create', 'AttendenceController@create')->name('attendence.create');
		Route::get('/edit/{id}', 'AttendenceController@edit')->name('attendence.edit');

		Route::put('/update/{id}', 'AttendenceController@update');
		Route::delete('/delete/{id}', 'AttendenceController@destroy');

		// an ajax accessible route that returns a listing of students in a particular grade for attendence recording
		Route::post('/record/students', 'AttendenceController@students');

		// route for returning recorded students attendence
		Route::get('/students', 'AttendenceController@attendence')->name('attendence.students-attendence');

		// an ajax accessible route that returns a listing of grades that attendence are recoreded of in 
		// the academic year selected
		Route::post('/date/grades', 'AttendenceController@dateGrades');
	});

	//enrollments
	Route::group(['prefix' => '/enrollments'], function(){
		Route::get('/', 'EnrollmentsController@index')->name('enrollments.home');
		Route::get('/create', 'EnrollmentsController@create')->name('enrollments.create');
		Route::get('/edit/{id}', 'EnrollmentsController@edit');
		Route::put('/update/{id}', 'EnrollmentsController@update');
		Route::post('/', "EnrollmentsController@store");
		// This route triggers an ajax call that returns students who are not enrolled for 
		// the current academic year.
		Route::get('/unenrolled-students', 'EnrollmentsController@unenrolledStudents');
		// This route returns students from the enrollment table within the academic
		// year id passed.
		Route::get('/academic-students/{id}', 'EnrollmentsController@enrollmentAcademicStudents');
		// This route passed a student id to check if it exists in the enrollments table.
		// The reason is to determine the student type, whether the student is an old student or new 
		// student.
		Route::get('/student-exists/{id}', 'EnrollmentsController@studentExists');
		
	});

	//transcript
	Route::group(['prefix' => '/transcripts'], function(){
		Route::get('/', 'TranscriptsController@index')->name('transcripts.home');
		Route::post('/setup', 'TranscriptsController@setupTranscript');
		//the route helps generate transcript for students in four(4) more grades
		Route::post('/generate', 'TranscriptsController@generateTranscript');
	});
});


/*
|--------------------------------------------------------------------------
| Guardian Routes
|--------------------------------------------------------------------------
*/
// routes for guardian login
Route::get('/guardian/login', 'Auth\GuardianLoginController@showLoginForm')->name('guardian.login');
Route::post('/guardian/login', 'Auth\GuardianLoginController@login')->name('guardian.login.submit');

//routes that are only accessible to guardian
Route::group(['middleware' => ['auth:guardian', 'preventBackHistory']], function() {

	Route::group(['prefix' => 'guardian'], function () {
		Route::get('/', 'Guardian\DashboardController@index')->name('guardian.dashboard');
		Route::post('logout', 'Auth\GuardianLoginController@logout')->name('guardian.logout');

		Route::get('/attendence', 'Guardian\AttendenceController@index')->name('guardian.attendence');

		//ajax route
		Route::post('/attendence/students', 'Guardian\AttendenceController@studentAttendence')->name('guardian.attendence-student');

		// an ajax accessible route that returns a listing of students assigned to a guardian who attended school on a 
		// particular date.
		Route::get('/attendence/students/{date}', 'Guardian\AttendenceController@attendees');
	});


	Route::group(['prefix' => '/guardian/students'], function() {

		Route::get('term', 'Guardian\ScoresController@termForm');
		Route::post('term', 'Guardian\ScoresController@termResults');

		Route::get('semester', 'Guardian\ScoresController@semesterForm');
		Route::post('semester', 'Guardian\ScoresController@semesterResults');

		Route::get('annual', 'Guardian\ScoresController@annualForm');
		Route::post('annual', 'Guardian\ScoresController@annualResults');

		//This route passes the academic id and return a listing of students enrolled for 
		//the academic year passed who are assigned to the guardian logged in.
		Route::get('/{academic_year}', 'Guardian\ScoresController@guardianAcademicStudents');

		//This route returns a view of students who are assigned to a guardian for a particular academic year
		Route::get('/dashboard/{academic_year}', 'Guardian\DashboardController@guardianAcademicStudents');
	});
});


/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/
// teacher login routes
Route::get('teacher/login', 'Auth\TeacherLoginController@showLoginForm')->name('teacher.login');
Route::post('teacher/login', 'Auth\TeacherLoginController@login')->name('teacher.login.submit');

// other routes accessible to teachers only
Route::group(['middleware' => ['auth:teacher', 'preventBackHistory']], function() {

	Route::post('logout', 'Auth\TeacherLoginController@logout')->name('teacher.logout');
	
	// routes for teacher login and dashboard
	Route::group(['prefix' => 'teacher'], function () {

		Route::get('/', 'Teacher\DashboardController@index')->name('teacher.dashboard');
		//returns grades that are assigned to a teacher in an academic year
		Route::get('/academic/grades/{academic_year}', 'Teacher\DashboardController@academicGrades');
		//Returns subjects assigned to a grade a teacher is teaching in the current academic year
		Route::get('/grade/subjects/{grade}', 'Teacher\DashboardController@gradeSubjects');
		//Returns subjects assigned to a grade a teacher is teaching in an academic year
		Route::post('/academic/grade/subjects', 'Teacher\DashboardController@academicGradeSubjects');

		//teacher attendence routes
		Route::get('/attendence', 'Teacher\AttendenceController@index')->name('teacher-attendence');

		Route::get('/attendence/create', 'Teacher\AttendenceController@create')->name('teacher-attendence.create');
		// route for returning recorded students attendence
		Route::get('/attendence/students/recorded', 'Teacher\AttendenceController@attendence');
		// an ajax accessible route that returns a listing of students in a particular grade for attendence recording
		Route::get('/attendence/students', 'Teacher\AttendenceController@students');
		// the academic year selected. The grades returned are grades the logged in teacher is teaching.
		Route::post('/attendence/date/grades', 'Teacher\AttendenceController@dateGrades');

		//teacher scores reports route
		Route::group(['prefix' => '/scores/report'], function (){
			// display form to search for student term report
			Route::get('/terms', 'Teacher\ScoresReportController@term')->name('teacher.term-scores'); 
			// send data and return student term report
			Route::post('/terms', 'Teacher\ScoresReportController@findTerm'); 
			// display form to search for student report
			Route::get('/semesters', 'Teacher\ScoresReportController@semester')->name('teacher.semester-scores');
			// send data and return student semester report 
			Route::post('/semesters', 'Teacher\ScoresReportController@findSemester'); 
			Route::get('/annual', 'Teacher\ScoresReportController@annual')->name('teacher.annual-scores');
			Route::post('/annual', 'Teacher\ScoresReportController@findAnnual')->name('find.annual-scores');
		});

		//returns the grade a teacher is sponsoring in an academic year
		Route::get('/sponsor/grade/{academic_year}', 'Teacher\DashboardController@academicSponsorGrade');

		// routes teacher uses to access scores resources
		Route::get('/scores', 'Teacher\ScoresController@index')->name('teacher.scores-home');
		Route::get('/manage-scores', 'Teacher\ScoresController@master')->name('teacher.manage-scores');
		Route::get('/manage-scores/create', 'Teacher\ScoresController@create');
		Route::post('/manage-scores', 'Teacher\ScoresController@store' );
		Route::get('/students-scores', 'Teacher\ScoresController@studentsScores');

		//This route eturns a listing of students in the scores table who has recored scores for them in the academic year selected and are enrolled in the grade the logged in tacher is teaching.
		Route::post('/scores/academic/grade/students/', 'Teacher\ScoresController@academicGradeStudents');

	});

});


/*
|--------------------------------------------------------------------------
| Other Routes
|--------------------------------------------------------------------------
*/

//charts
Route::group(['prefix' => 'charts'], function () {
	Route::get('gender', 'ChartsController@genderChart')->name('charts.gender');
	Route::get('grades', 'ChartsController@gradesChart')->name('charts.grades');
});


Route::group(['middleware' => ['auth:web,admin']], function() {

	//This route passes the academic id and return a listing of grades in the scores table
	//that scores have been recorded for.
	Route::get('/scores/grades/{academic_year}', 'ScoresController@academicScoresGrades');
	// query out subjects assigned to a grade or class
	Route::get('/grades/subjects/{id}', 'GradesController@gradeSubjects');

	//This route passes the academic id and return a listing of grades in the scores table
	//that scores have been recorded for.
	Route::get('/grades/{academic_year}', 'ScoresController@academicScoresGrades');

});


Route::group(['middleware' => ['auth:teacher,admin,guardian']], function() {

	// an ajax accessible route that returns a listing of dates in a particular academic year
	Route::get('/attendence/academic/{year}', 'AttendenceController@datesInYear')->name('attendence.datesInYear');
	// an ajax accessible route that returns a listing of students who attended school on a 
	// particular date.
	Route::get('/attendence/attendees/{date}', 'AttendenceController@attendees');

});


//Only teachers and administrators can record attendence
Route::group(['middleware' => ['auth:teacher,admin']], function() {

	// both teacher and admin can store attendence
	Route::post('/attendence', 'AttendenceController@store')->name('attendence.submit');

});


