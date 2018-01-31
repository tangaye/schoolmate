<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enrollments;
use App\Repositories\TranscriptsRepository;
use App\Repositories\EnrollmentsRepository;
use App\Student;




class TranscriptsController extends Controller
{
    //
	public function index(EnrollmentsRepository $enrollment)
	{
		$students = $enrollment->enrolled_students();
		return view('admin.transcripts.home', compact('students'));
	}

	public function setupTranscript(Request $request, TranscriptsRepository $transcript)
	{
		$student = Student::findOrFail($request->student_id);
		$years_enrolled = $transcript->years_student_enrolled_for($student->id);

		$grades = $years_enrolled->pluck('grade_id', 'grade_name');

		return \View::make('admin.transcripts.partials.setup')->with(
            [
                'grades' => $grades,
                'student_id' => $student->id
            ]
        );
	}


	public function generateTranscript(Request $request, TranscriptsRepository $transcript)
	{
		return $transcript->generate_transcript($request);
	}
}
