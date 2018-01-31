<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Term;
use App\Semester;
use App\Repositories\ScoresRepository;
use App\Academic;



class ScoresReportController extends Controller
{
 
     /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function term(Request $request)
    {
        //
        $terms = Term::all();
        $academics = Academic::all();

        return view('scores.student-term-scores', compact('terms', 'academics'));
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
    public function semester(Request $request)
    {
        //
        $semesters = Semester::all();
        $academics = Academic::all();
        return view('scores.student-semester-scores', compact('semesters', 'academics'));
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
    public function annual(Request $request)
    {
        $academics = Academic::all();
        return  view('scores.student-annual-scores', compact('academics'));
    }

    public function findAnnual(Request $request, ScoresRepository $scores)
    {
        return $scores->annualReport($request->student_id, $request->academic_id);
    }

}
