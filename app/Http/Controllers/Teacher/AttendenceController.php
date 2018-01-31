<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use App\Teacher;
use App\Attendence;
use App\Academic;
use App\Student;
use App\Grade;
use App\Subject;
use App\Repositories\AttendenceRepository;
use App\Repositories\TeachersRepository;


class AttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TeachersRepository $teachers)
    {
        
        $teacher = Teacher::findOrFail(Auth::guard('teacher')->user()->id); 

        $academics = $teachers->teacher_academic_years($teacher->id);

        return view('teacher.attendence.home', compact('academics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TeachersRepository $teacher)
    {
        // returns all grades teacher is teaching in the current academic year
        $teacher_grades = $teacher->teacher_grades(Auth::guard('teacher')->user()->id); 
        $date = new Carbon();
        return view('teacher.attendence.create', compact('teacher_grades', 'date'));

    }


    /**
     * Display a listing of dates in a selected year.
     *
     * @return \Illuminate\Http\Response
     */
    public function datesInYear($year, AttendenceRepository $attendence)
    {
        //return unique years from date column/field in the attendence table
        $dates = $attendence->year_dates($year);

        return response()->json($dates);
    }

     /**
     * This function returns a partial view that includes recorded
     * attendence of students in a specific grade and for a specific
     * date in a academic year. 
     * If no attendence is found recorded for the specify date and 
     * grade a message is return the tells the user such.
     * The view returned doesn't allow one to modify student attendence
     * details like the view returned on the admin account.
     * @return \Illuminate\Http\Response
     */
    public function attendence(Request $request, AttendenceRepository $attendence){

        $grade = Grade::findOrFail($request->grade_id);
        $subject = Subject::findOrFail($request->subject_id);
        $academic = Academic::findOrFail($request->academic_id);

        $attendences = $attendence->student_attendence($grade->id, $subject->id, $request->date, $academic->id);
        $date = Carbon::parse($request->date);


        if (count($attendences) > 0) {
            return \View::make('teacher.attendence.partials.students-attendence')->with(array(
                    'attendences' => $attendences, 
                    'date' => $date
                )
            );
        } else {
             return response("There is no recorded attendence for <b>".$grade->name." ".$subject->name."</b> students on <u>".$date->toFormattedDateString());
        }
    }

    /**
     * Display a listing of students in a particular grade.
     * This function returns a partial view of students in a specific
     * grade, so that attendence can be recorded for those students.
     *
     * The students returned are students who are enrolled in the current
     * academic year
     * @return \Illuminate\Http\Response
     */
    public function students(Request $request, AttendenceRepository $attendence)
    {
        $statuses = $attendence->statuses();
        $grade = Grade::findOrFail($request->grade_id);
        $subject = Subject::findOrFail($request->subject_id);

        $academics = new Academic();
        $current_academic = $academics->current();

        //This returns a view of students of whom attendence are going to be recorded for
        $record_students_attendence = $attendence->record_attendence($grade->id, $current_academic->id);

        if (count($record_students_attendence) > 0) {
            // this check if attendence has been setup for the given date.
            // if so prevent user for enter another date
            $attendenceExists = Attendence::where([
                'grade_id' => $grade->id, 
                'subject_id' => $subject->id, 
                'date' => $request->date
            ])->first();

            
            if ($attendenceExists) {
                return 'Attendence is already recorded today for the specified grade, subject!';
            } else {
                return \View::make('teacher.attendence.partials.attendence-form')->with(array(
                    'students' => $record_students_attendence,
                    'subject' => $subject,
                    'date' => $request->date,
                    'statuses' => $statuses,
                    'current_academic' => $current_academic
                ));
            }
            
        } else {
            return 'No student found in the seleted grade!';
        }  
    }

    /**
     * Display a listing of grades/classes that recorded attendence
     * on a particular date. The dates returned are then filter out to
     * be the the logged in teacher is teaching in the academic year passed.
     *
     * @return \Illuminate\Http\Response
    */
    public function dateGrades(Request $request, AttendenceRepository $attendence, TeachersRepository $teachers)
    {
        $teacher = Teacher::findOrFail(Auth::guard('teacher')->user()->id); 
        $academic = Academic::findOrFail($request->academic_id);
        $date = Carbon::parse($request->date);

        // get date grades
        $date_grades = $attendence->academic_date_grades($request->date, $academic->id);

        // get teacher grades
        $teacher_grades = $teachers->teacher_academic_grades($teacher->id, $academic->id);

        //filter out the date grades to return grades that the teacher is teaching
        $grades = $teacher_grades->whereIn('id', $date_grades->pluck('id'));


        if (count($grades) > 0) {
            
            return response()->json($grades);
        } else {
            return response()->json(['none' => 'You are not teaching none of the grades found to have attendence recorded for on <b>'.$date->toFormattedDateString().'</b>']);
        }
    }
}
