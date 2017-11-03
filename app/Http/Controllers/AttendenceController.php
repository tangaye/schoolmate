<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Attendence;
use App\Student;
use App\Grade;
use App\Subject;




class AttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Attendence $attendence)
    {
        //return unique years from date column/field in the attendence table
        $years = $attendence->years();

        $grades = Grade::all()->pluck('name', 'id');

        return view('admin.attendence.home', compact('years', 'grades'));
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $grades = Grade::all()->pluck('name', 'id');
        $date = Carbon::today()->toDateString();
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
        //dd($request->all());
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
                'remarks' => $row['remarks']
            ];
        }

        Attendence::insert($attendence);

        return response()->json("Attendence save for <b>".count($attendence)." student(s)</b>");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $attendence = Attendence::findOrFail($id);
        $statuses = Attendence::statuses();

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
     * Display a listing of students in a particular grade.
     * This function returns a partial view of students in a specific
     * grade, so that attendence can be recorded for those students
     * @return \Illuminate\Http\Response
     */
    public function students(Request $request)
    {
        //
        $grade = Grade::findOrFail($request->grade_id);

        $subject = Subject::findOrFail($request->subject_id);

        $statuses = Attendence::statuses();

        $students = Student::where('grade_id', $grade->id)
            ->get(['id', 'first_name','middle_name', 'surname', 'grade_id', 'student_code']);

        if (count($students) > 0) {
            // this check if attendence has been setup for the given date.
            // if so prevent user for enter another date
            $attendenceExists = Attendence::where([
                'grade_id' => $grade->id, 
                'subject_id' => $subject->id, 
                'date' => $request->date
            ])->first();

            
            if ($attendenceExists) {
                return 'Attendence is already recorded for the specified grade, subject and date!';
            } else {
                return \View::make('admin.attendence.partials.attendence-form')->with(array(
                    'students' => $students,
                    'subject' => $subject,
                    'date' => $request->date,
                    'statuses' => $statuses
                ));
            }
            
        } else {
            return 'No studens found in the seleted grade!';
        }  
    }


     /**
     * This function returns a partial view that includes recorded
     * attendence of students in a specific grade and for a specific
     * date. If no attendence is found recorded for the specify date and 
     * grade a message is return the tells the user such.
     * @return \Illuminate\Http\Response
     */
    public function attendence(Request $request, Attendence $attendence){

        $grade = Grade::findOrFail($request->grade_id);
        $subject = Subject::findOrFail($request->subject_id);

        $attendences = $attendence->student_attendence($grade->id, $subject->id, $request->date);
        $date = Carbon::parse($request->date);

        if (count($attendences) > 0) {
            return \View::make('admin.attendence.partials.students-attendence')->with(array(
                'attendences' => $attendences, 
                'date' => $date
            ));
        } else {
            return response("There is no recorded attendence for the specified grade, subject and date");
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
}
