<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Attendence;
use App\Student;
use App\Grade;
use App\Subject;
use App\Academic;
use App\Repositories\AttendenceRepository;





class AttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AttendenceRepository $attendence)
    {
        //return unique years from date column/field in the attendence table
        //$years = $attendence->years();

        $grades = Grade::all()->pluck('name', 'id');

        $academics = Academic::all();

        return view('admin.attendence.home', compact('years', 'grades', 'academics'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $grades = Grade::all()->pluck('name', 'id');
        $date = new Carbon();
        return view('admin.attendence.create', compact('grades', 'date'));

    }

    /**
     * Allows one to insert multiple rows of attendence.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rows = $request->rows;
        $attendence = array();
        
        foreach ($rows as $row)
        {
            $attendence[] = [
                'student_id' => $row['student_id'],
                'subject_id' => $row['subject_id'],
                'grade_id' => $row['grade_id'],
                'date' => $row['date'],
                'status' => $row['status'],
                'remarks' => $row['remarks'],
                'academic_id' => $row['academic_id']
            ];
        }

        Attendence::insert($attendence);

        return response()->json("Attendence recorded for <b>".count($attendence)." student(s)</b>");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, AttendenceRepository $attendenceRepo)
    {
        //
        $attendence = Attendence::findOrFail($id);
        $statuses = $attendenceRepo->statuses();

        return response()->json([
            "attendence" => $attendence->status,
            "statuses" => $statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // make validation
        $validator = Validator::make ( $request->all(), [
            'status' => 'required',
            'remarks' => 'nullable'
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        else {

            $attendence = Attendence::findOrFail($id);
            $student = Student::findOrFail($attendence->student_id);

            $attendence->update(request(['status', 'remarks']));


            return response()->json([
                "success" => "Student <b>".$student->first_name." ".$student->surname."</b> attendence updated!",

                "date" => $attendence->date->toFormattedDateString(),

                "attendence" => $attendence::where('id', $attendence->id)
                    ->with('student')
                    ->with('grade')
                    ->with('subject')
                    ->get()
            ]);
        }
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $attendence = Attendence::findOrFail($id);
        $student = Student::findOrFail($attendence->student_id);
        $attendence->delete();

        return response()->json([
            "message" => $student->first_name." ".$student->surname." attendence for ".$attendence->date->toFormattedDateString()." deleted!"
        ]);
    }


     /**
     * Display a listing of dates in a selected academic year.
     *
     * @return \Illuminate\Http\Response
     */
    public function datesInYear($year, AttendenceRepository $attendence)
    {
        //return unique years from date column/field in the attendence table
        $dates = $attendence->year_dates($year);

        return $dates;
    }

    /**
     * Display a listing of grades/classes that recorded attendence
     * on a particular date.
     *
     * @return \Illuminate\Http\Response
    */
    public function dateGrades(Request $request, AttendenceRepository $attendence)
    {
        $academic = Academic::findOrFail($request->academic_id);

        $date_grades = $attendence->academic_date_grades($request->date, $academic->id);

        if (count($date_grades) > 0) {
            
            return response()->json($date_grades);
        } else {
            return response()->json(['none' => 'No grade found to have attendence recorded on the selected date.']);
        }
    }

     /**
     * Returns a listing of students who attended school on a particular
     * date.
     * @return \Illuminate\Http\Response
     */
     public function attendees($date, AttendenceRepository $attendence)
     {
        $students = $attendence->daily_attendees($date);

        return $students;
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
                return \View::make('admin.attendence.partials.attendence-form')->with(array(
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
     * This function returns a partial view that includes recorded
     * attendence of students in a specific grade and for a specific
     * date in a academic year. 
     * If no attendence is found recorded for the specify date and 
     * grade a message is return the tells the user such.
     * @return \Illuminate\Http\Response
     */
    public function attendence(Request $request, AttendenceRepository $attendence){

        $grade = Grade::findOrFail($request->grade_id);
        $subject = Subject::findOrFail($request->subject_id);
        $academic = Academic::findOrFail($request->academic_id);

        $attendences = $attendence->student_attendence($grade->id, $subject->id, $request->date, $academic->id);
        $date = Carbon::parse($request->date);

        if (count($attendences) > 0) {
            return \View::make('admin.attendence.partials.students-attendence')->with(array(
                'attendences' => $attendences, 
                'date' => $date
            ));
        } else {
            return response("There is no recorded attendence for <b>".$grade->name." ".$subject->name."</b> students on <u>".$date->toFormattedDateString());
        }
    }

}
