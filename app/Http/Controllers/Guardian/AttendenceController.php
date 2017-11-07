<?php

namespace App\Http\Controllers\Guardian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Guardian;
use App\Attendence;
use App\Student;

use Carbon\Carbon;

class AttendenceController extends Controller
{
    //

    public function index(Attendence $attendence)
    {
    	//return unique years from date column/field in the attendence table
        $years = $attendence->years();
        // passes students related to the logged in guardian
        $guardians = Guardian::with('student')->where('id', Auth::guard('guardian')->user()->id)->get();

    	return view('guardian.attendence.home', compact('years', 'guardians'));
    }

    public function student_attendence(Request $request, Attendence $attendence)
    {
    	$student = Student::findOrFail($request->student_id);
    	$date = $request->date;

    	$attendences = $attendence->guardian_student_attendence($student->id, $date);

    	return \View::make('guardian.attendence.partials.student-attendence')->with(
    		[
    			'attendences' => $attendences, 
    			'student' => $student->first_name." ".$student->middle_name." ".$student->surname,
    			'date' => Carbon::parse($date)
    		]
    	);
    }
}
