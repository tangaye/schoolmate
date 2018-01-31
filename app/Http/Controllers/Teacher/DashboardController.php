<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Teacher;
use App\Academic;
use App\Grade;
use App\Repositories\TeachersRepository;

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
    public function index(TeachersRepository $teachers)
    {   
        $teacher = Teacher::findOrFail(Auth::guard('teacher')->user()->id);
        $grades = $teachers->teacher_grades(Auth::guard('teacher')->user()->id); 

        return view('teacher.dashboard', compact('teacher', 'grades'));
    }

    function academicGrades($academic_year, TeachersRepository $teachers)
    {
        $instructor = Teacher::findOrFail(Auth::guard('teacher')->user()->id);

        $academic = Academic::findOrFail($academic_year);   

        $grades = $teachers->teacher_academic_grades($instructor->id, $academic->id);

        if (count($grades) > 0) {
            return response()->json($grades);
        } else {
            return response()->json(['none' => 'There are no grades assigned for the selected academic year']);
        }
    }

    // returns all subjects assigned to a grade that a teacher is teaching in an academic year
    public function academicGradeSubjects(Request $request, TeachersRepository $teachers)
    {
        $instructor = Teacher::findOrFail(Auth::guard('teacher')->user()->id);
        $grade = Grade::findOrFail($request->grade_id);
        $academic = Academic::findOrFail($request->academic_id);

        $subjects = $teachers->teacher_academic_grade_subjects($instructor->id, $grade->id, $academic->id);

        if (count($subjects) > 0) {
            return response()->json($subjects);
        } else {
            return response()->json(['none' => 'No subject assigned for the grade and academic year selected.']);
        }
    }

    // returns all subjects assigned to a grade that a teacher is teaching in the current
    // academic year
    public function gradeSubjects($grade, TeachersRepository $teachers)
    {
        $instructor = Teacher::findOrFail(Auth::guard('teacher')->user()->id);
        $grade = Grade::findOrFail($grade);

        $subjects = $teachers->teacher_grade_subjects($grade->id, $instructor->id);

        if (count($subjects) > 0) {
            return response()->json($subjects);
        } else {
            return response()->json(['none' => 'No subject assigned for the grade and academic year selected.']);
        }
    }

    /*
    * Returns details of the grade a logged in teacher is sponsoring in an academic year.
    */
    public function academicSponsorGrade($academic_year, TeachersRepository $teachers)
    {
        $instructor = Teacher::findOrFail(Auth::guard('teacher')->user()->id);

        $academic = Academic::findOrFail($academic_year);   

        $grade = $teachers->teacher_academic_sponsor_grade($instructor->id, $academic->id);

        if (count($grade) > 0) {
            return response()->json($grade);
        } else {
            return response()->json(['none' => 'You are not a sponsor of any grade in the selected academic year.']);
        }
    }
}
