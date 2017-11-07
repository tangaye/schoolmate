<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendence extends Model
{
    //
     protected $fillable = [
        'student_id',
    	'subject_id',
    	'grade_id',
    	'date',
    	'status',
        'remarks'
    ];

    // relation between attendence and student.
    // each attendence record has a student
    public function student()
    {
        return $this->belongsTo(Student::class)->select(['id', 'student_code', 'first_name', 'middle_name', 'surname']);
    }

    // relation between attendence and subject.
    // each attendence record has a subject
    public function subject()
    {
        return $this->belongsTo(Subject::class)->select(['id', 'name']);
    }

    // relation between attendence and grade
    // each attendence record has a grade
    public function grade()
    {
        return $this->belongsTo(Grade::class)->select(['id','name']);
    }

    // this helps get a readable format for the date field
    protected $casts = [
        'date' => 'date', 
    ];

    public function setDateAttribute($value)
    {
        //dd($value);
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public static function statuses()
    {
        return [
            "Present", 
            "Absent"
        ];
    }

    public function student_attendence($grade, $subject, $date)
    {
        return \DB::table('attendences')
            ->join('subjects', 'subjects.id', '=', 'attendences.subject_id')
            ->join('grades', 'grades.id', '=', 'attendences.grade_id')
            ->join('students', 'students.id', '=', 'attendences.student_id')
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
            ->where('attendences.grade_id', $grade)
            ->where('attendences.subject_id', $subject)
            ->where('attendences.date', $date)
            ->get();
    }

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
     * Return a collection of unique/non-repeating years in the attendence table.
     *
     * @return \Illuminate\Http\Response
     */
    public function years()
    {
       return \DB::table('attendences')
            ->select(\DB::raw('DISTINCT YEAR(date) years'))
            ->get()
            ->toArray();
    }

    /**
     * Return an array of dates in a selected year.
     *
     * @return \Illuminate\Http\Response
     */
    public function year_dates($year)
    {
        //return unique years from date column/field in the attendence table
        $dates = Attendence::whereYear('date', $year)
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
        return $datesArray;
    }
}
