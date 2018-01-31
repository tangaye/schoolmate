<?php

namespace App\Repositories;
use App\Attendence;
use Carbon\Carbon;
use App\Grade;
use App\Subject;
use App\Academic;


/**
 * summary
 */
class AttendenceRepository
{
	public function statuses()
    {
        return [
            "Present", 
            "Absent"
        ];
    }
    
    /**
     * This function displays attendence of students.
     *
     */
    public function student_attendence($grade, $subject, $date, $academic)
    {
        return \DB::table('attendences')
            ->join('subjects', 'subjects.id', '=', 'attendences.subject_id')
            ->join('grades', 'grades.id', '=', 'attendences.grade_id')
            ->join('students', 'students.id', '=', 'attendences.student_id')
            ->join('academics', 'academics.id', '=', 'attendences.academic_id')
            ->select(
                'attendences.id',
                'students.id as student_id',
                'subjects.name as subject',
                'grades.name as grade',
                'students.student_code as student_code',
                'students.first_name',
                'students.middle_name',
                'students.surname',
                'attendences.status',
                'attendences.remarks'
            )
            ->where([
                ['attendences.grade_id', $grade],
                ['attendences.subject_id', $subject],
                ['attendences.date', $date],
                ['attendences.academic_id', $academic]
            ])
            ->get();
    }

    /**
     * This function displays attendence of students in the guardian view.
     *
     */
    public function guardian_student_attendence($student, $date)
    {
        return \DB::table('attendences')
            ->join('subjects', 'subjects.id', '=', 'attendences.subject_id')
            ->join('grades', 'grades.id', '=', 'attendences.grade_id')
            ->join('students', 'students.id', '=', 'attendences.student_id')
            ->select(
                'subjects.name as subject',
                'attendences.status',
                'attendences.remarks'
            )
            ->where('attendences.student_id', $student)
            ->where('attendences.date', $date)
            ->get();
    }

    /**
     * Return an array of dates in a selected academic year.
     *
     * @return \Illuminate\Http\Response
     */
    public function year_dates($academic_year_id)
    {
        //return unique years from date column/field in the attendence table
        //for the specify academic year
        $dates = Attendence::where('academic_id', $academic_year_id)
            ->distinct('date')
            ->get(['date'])
            ->toArray();

        $datesArray = array();

        foreach ($dates as $values) {

            foreach ($values as $date) {

                //populate the dates array with an associate array containing
                // a date value and its equivalent user readable format
                //Ex. [2017-10-23 => Oct 23, 2017]
                array_push($datesArray, array(Carbon::parse($date)->toDateString() => Carbon::parse($date)->toFormattedDateString()));
                //array_push($datesArray, Carbon::parse($date)->toDateString());
            }
        }

        // return an array of dates found for a particular year
        if (count($datesArray) > 0) {
            
            return response()->json($datesArray);
        } else {
            return response()->json(['none' => 'No attendence recorded in the year selected.']);
        }
    }

    // returns a listing of students who attendend school on a particular date
    public function daily_attendees($date)
    {
        $students = \DB::table('attendences')
            ->join('students', 'students.id', '=', 'attendences.student_id')
            ->select(
                'students.id',
                'students.student_code as code',
                'students.first_name',
                'students.middle_name',
                'students.surname'
            )
            ->distinct()
            ->where('attendences.date', $date)
            ->get();

        if (count($students) > 0) {
            
            return response()->json($students);
        } else {
            return response()->json(['none' => 'No attendence recorded for students on this date.']);
        }
    }

    /*
    * Returns students in a selected grade that attendence are to be recorded for 
    * in the current academic year
    */
    function record_attendence($grade, $academic)
    {

        $students = \DB::table('enrollments') 
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->join('grades', 'grades.id', '=', 'enrollments.current_grade')
            ->join('academics', 'academics.id', '=', 'enrollments.academic_id')
            ->select(
                'students.id',
                'students.first_name',
                'students.middle_name',
                'students.surname',
                'students.student_code',
                'grades.id as grade_id'
            )
            ->where([
                ['enrollments.current_grade', '=', $grade],
                ['enrollments.academic_id', '=', $academic],
                ['enrollments.enrollment_status', '=', 'Enrolled']
            ])
            ->get();

        return $students;
    }

    /*
    * Returns a listing of grades that students attendence have been recorded for
    * on a particular date in an academic year.
    */
    function academic_date_grades($date, $academic)
    {
        $grades = \DB::table('attendences')
            ->join('grades', 'grades.id', '=', 'attendences.grade_id')
            ->select(
                'grades.id',
                'grades.name'
            )
            ->distinct()
            ->where([
                ['attendences.date', $date],
                ['attendences.academic_id', $academic]
            ])
            ->get();

        return $grades;
    }
}
