<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Term;
use App\Academic;
use App\Semester;
use App\Teacher;
use App\Repositories\ScoresRepository;
use App\Repositories\TeachersRepository;

class ScoresReportController extends Controller
{
    //
     /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function term(Request $request, TeachersRepository $teacher)
    {
        //
        $terms = Term::all();
        $instructor = Teacher::findOrFail(Auth::guard('teacher')->user()->id);
        //years teacher has been teaching for.
        $academics = $teacher->teacher_academic_years($instructor->id);
        return view('teacher.scores.student-term-scores', compact('terms', 'academics'));
    }

    /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function findTerm(Request $request, ScoresRepository $scores)
    {
        //
        return $scores->termReport($request->term_id, $request->student_id, $request->academic_id);
    }

    /**
     * Show the form to search for a specific.
     * student semester report
     *
     * @return \Illuminate\Http\Response
     */
    public function semester(Request $request, TeachersRepository $teacher)
    {
        //
        $semesters = Semester::all();
        $instructor = Teacher::findOrFail(Auth::guard('teacher')->user()->id);
        //years teacher has been teaching for.
        $academics = $teacher->teacher_academic_years($instructor->id);
        return view('teacher.scores.student-semester-scores', compact('semesters', 'academics'));
    }

    public function findSemester(Request $request, ScoresRepository $scores)
    {
        return $scores->semesterReport($request->student_id, $request->semester_id, $request->academic_id);
    }

     /**
     * Show the form to search for a specific.
     * student semester report
     *
     * @return \Illuminate\Http\Response
     */
    public function annual(Request $request, TeachersRepository $teacher)
    {
        $instructor = Teacher::findOrFail(Auth::guard('teacher')->user()->id);
        //years teacher has been teaching for.
        $academics = $teacher->teacher_academic_years($instructor->id);
        return view('teacher.scores.student-annual-scores', compact('academics'));
    }

    public function findAnnual(Request $request, ScoresRepository $scores)
    {
        return $scores->annualReport($request->student_id, $request->academic_id);
    }

}
