<?php

namespace App\Http\Controllers\Guardian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Guardian;
use App\Academic;

use App\Repositories\GuardianRepository;

class DashboardController extends Controller
{
    //
    /**
     * Show the application dashboard for guardian.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GuardianRepository $guardian)
    {   
        // passes the logged in guardian details
        $logged_in_guardian = Guardian::findOrFail(Auth::guard('guardian')->user()->id);

        $academics = $guardian->guardian_student_dashboard_academic_years($logged_in_guardian->id);

        return view('guardian.dashboard', compact('guardians', 'logged_in_guardian', 'academics'));
    }

    public function guardianAcademicStudents($academic_year, GuardianRepository $guardian)
    {
        $logged_in_guardian = Guardian::findOrFail(Auth::guard('guardian')->user()->id);
        $academic = Academic::findOrFail($academic_year);

        $students = $guardian->guardian_dashboard_academic_students($logged_in_guardian->id, $academic->id);

        if (count($students) > 0) {
            return \View::make('guardian.partials.academic-students')->with(array(
                'students' => $students,
                'academic' => $academic
            ));
        } else {
            return response()->json(array('none' => 'No enrolled student found for the academic year selected!'));
        }
    }
}
