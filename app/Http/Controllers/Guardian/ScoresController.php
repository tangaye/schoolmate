<?php

namespace App\Http\Controllers\Guardian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Guardian;
use App\Term;
use App\Semester;
use App\Score;

class ScoresController extends Controller
{
    //

     /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function termForm(Request $request)
    {
        //
        $terms = Term::all();
        $guardians = Guardian::with('student')->where('id', Auth::guard('guardian')->user()->id)->get();
        return view('guardian.scores.student-term', compact('terms', 'guardians'));
    }


    /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function termResults(Request $request, Score $score)
    {
        //
        return $score->termReport($request->term_id, $request->student_id);
    }

    /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function semesterForm(Request $request)
    {
        //
        $semesters = Semester::all();
        $guardians = Guardian::with('student')->where('id', Auth::guard('guardian')->user()->id)->get();
        return view('guardian.scores.student-semester', compact('semesters', 'guardians'));
    }

    /**
     * display a student semester report
     *
     * @return \Illuminate\Http\Response
     */
    public function semesterResults(Request $request, Score $score)
    {
        return $score->semesterReport($request->student_id, $request->semester_id);
    }

    /**
     * Show the form to generate a student annual report
     *
     * @return \Illuminate\Http\Response
     */
    public function annualForm(Request $request)
    {
        //
        $guardians = Guardian::with('student')->where('id', Auth::guard('guardian')->user()->id)->get();
        return view('guardian.scores.student-annual', compact('guardians'));
    }

    /**
     * display a student semester report
     *
     * @return \Illuminate\Http\Response
     */
    public function annualResults(Request $request, Score $score)
    {

        return $score->annualReport($request->student_id, $request->semester_id);
    }
}
