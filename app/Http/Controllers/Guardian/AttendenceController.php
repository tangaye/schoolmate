<?php

namespace App\Http\Controllers\Guardian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Guardian;
use App\Attendence;
use App\Student;
use App\Repositories\AttendenceRepository;
use App\Repositories\GuardianRepository;
use Carbon\Carbon;

class AttendenceController extends Controller
{
    //

    public function index(GuardianRepository $guardian)
    {
        $logged_in_guardian = Guardian::findOrFail(Auth::guard('guardian')->user()->id);
        //guardian should only see academic years he has had students enrolled for.
        $academics = $guardian->guardian_student_academic_years($logged_in_guardian->id);

    	return view('guardian.attendence.home', compact('academics'));
    }


    /**
     * Display attendence of students on a guardian ward.
     *
     */
    public function studentAttendence(Request $request, AttendenceRepository $attendence)
    {
    	$student = Student::findOrFail($request->student_id);
    	$date = $request->date;

    	$attendences = $attendence->guardian_student_attendence($student->id, $date);

    	return \View::make('guardian.attendence.partials.student-attendence')->with(
    		[
    			'attendences' => $attendences, 
    			'student' => $student->full_name,
    			'date' => $date
    		]
    	);
    }

    /*
    * Returns a listing of students assigned to a logged in guardian
    * who have attended school on a particular date.
    */
    public function attendees($date, AttendenceRepository $attendence)
    {
        $logged_in_guardian = Guardian::findOrFail(Auth::guard('guardian')->user()->id);
        //students assigned to the logged in guardian who attended school on the date passed
        $students = \DB::table('attendences')
            ->join('students', 'students.id', '=', 'attendences.student_id')
            ->select(
                'students.id',
                'students.student_code',
                'students.first_name',
                'students.middle_name',
                'students.surname'
            )
            ->distinct()
            ->where([
                ['attendences.date', $date],
                ['students.guardian_id', $logged_in_guardian->id]
            ])
            ->get();

        if (count($students) > 0) {
            
            return response()->json($students);
        } else {
            return response()->json(['none' => 'No attendence recorded for students assigned to you on this date.']);
        }
    }
}
