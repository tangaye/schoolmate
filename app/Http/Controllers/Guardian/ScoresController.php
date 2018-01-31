<?php

namespace App\Http\Controllers\Guardian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Guardian;
use App\Term;
use App\Semester;
use App\Score;
use App\Academic;
use App\Repositories\ScoresRepository;
use App\Repositories\GuardianRepository;

class ScoresController extends Controller
{
    //

     /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function termForm(Request $request, GuardianRepository $guardian)
    {
        //
        $terms = Term::all();
        $logged_in_guardian = Guardian::findOrFail(Auth::guard('guardian')->user()->id);
        //guardian should only see academic years he has had students enrolled for.
        $academics = $guardian->guardian_student_academic_years($logged_in_guardian->id);
        return view('guardian.scores.student-term', compact('terms', 'academics'));
    }


    /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function termResults(Request $request, ScoresRepository $scores)
    {
        //dd($request);
        return $scores->termReport($request->term_id, $request->student_id, $request->academic_id);
    }

    /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function semesterForm(Request $request, GuardianRepository $guardian)
    {
        //
        $semesters = Semester::all();
        $logged_in_guardian = Guardian::findOrFail(Auth::guard('guardian')->user()->id);
        //guardian should only see academic years he has had students enrolled for.
        $academics = $guardian->guardian_student_academic_years($logged_in_guardian->id);
        return view('guardian.scores.student-semester', compact('semesters', 'academics'));
    }

    /**
     * display a student semester report
     *
     * @return \Illuminate\Http\Response
     */
    public function semesterResults(Request $request, ScoresRepository $scores)
    {
        return $scores->semesterReport($request->student_id, $request->semester_id, $request->academic_id);
    }

    /**
     * Show the form to generate a student annual report
     *
     * @return \Illuminate\Http\Response
     */
    public function annualForm(Request $request, GuardianRepository $guardian)
    {
        $logged_in_guardian = Guardian::findOrFail(Auth::guard('guardian')->user()->id);
        //guardian should only see academic years he has had students enrolled for.
        $academics = $guardian->guardian_student_academic_years($logged_in_guardian->id);
        return view('guardian.scores.student-annual', compact('academics'));
    }

    /**
     * display a student semester report
     *
     * @return \Illuminate\Http\Response
     */
    public function annualResults(Request $request, ScoresRepository $scores)
    {

        return $scores->annualReport($request->student_id, $request->academic_id);
    }

    /*
    * Returns a listin of "enrolled" students assigned to the logged in guardian for 
    * the selected academic year/or the academic year passed.
    */
    public function guardianAcademicStudents($academic_year, GuardianRepository $guardian)
    {
        $logged_in_guardian = Guardian::findOrFail(Auth::guard('guardian')->user()->id);
        $academic = Academic::findOrFail($academic_year);

        $students = $guardian->guardian_academic_students($logged_in_guardian->id, $academic->id);

        if (count($students) > 0) {
            return response()->json($students);
        } else {
            return response()->json(array('none' => 'No enrolled student found for the academic year selected!'));
        }
    }

}
