<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use App\Teacher;
use App\Attendence;
use App\Student;
use App\Grade;
use App\Subject;



class AttendenceController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Attendence $attendence)
    {
        //return unique years from date column/field in the attendence table
        $years = $attendence->years();

        // returns all grades teacher is teaching
        $teacher_grades = Teacher::teacherGrades(Auth::guard('teacher')->user()->id); 

        return view('teacher.attendence.home', compact('years', 'teacher_grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // returns all grades teacher is teaching
        $teacher_grades = Teacher::teacherGrades(Auth::guard('teacher')->user()->id); 
        $date = Carbon::today()->toDateString();
        return view('teacher.attendence.create', compact('teacher_grades', 'date'));

    }


    /**
     * Display a listing of dates in a selected year.
     *
     * @return \Illuminate\Http\Response
     */
    public function datesInYear($year, Attendence $attendence)
    {
        //return unique years from date column/field in the attendence table
        $dates = $attendence->year_dates($year);

        return response()->json($dates);
    }

    public function attendence(Request $request, Attendence $attendence){

        $grade = Grade::findOrFail($request->grade_id);
        $subject = Subject::findOrFail($request->subject_id);

        $attendences = $attendence->student_attendence($grade->id, $subject->id, $request->date);

        $date = Carbon::parse($request->date);

        if (count($attendences) > 0) {
            return \View::make('teacher.attendence.partials.students-attendence')->with(array(
                    'attendences' => $attendences, 
                    'date' => $date
                )
            );
        } else {
            return response("There is no recorded attendence for the specified grade, subject and date");
        }
    }
}