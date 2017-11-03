<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Teacher;

/**
 * This controller handles redirecting logged in teachers
 * to the home or teacher dashboard page.
 * In the future this controller should posses functions that 
 * allows one to create scores for student(s) he/she is teacher.  
 *
 * It should also in the future allow a teacher to view scores of 
 * grades/classes they are sponsor of.
 */
class DashboardController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('preventBackHistory');
        $this->middleware('auth:teacher');
    }

    /**
     * Show the application dashboard for teachers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $teacher = Teacher::findOrFail(Auth::guard('teacher')->user()->id);
        $subjects = Teacher::teacherSubjects(Auth::guard('teacher')->user()->id);
        $grades = Teacher::teacherGrades(Auth::guard('teacher')->user()->id); 
        //dd($grades);

        return view('teacher.dashboard', compact('teacher', 'subjects', 'grades'));
    }
}
