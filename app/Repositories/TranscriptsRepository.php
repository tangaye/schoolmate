<?php

namespace App\Repositories;
use App\Academic;
use App\Institution;
use App\Student;
use App\Enrollment;


/**
 * summary
 */
class TranscriptsRepository
{
    // this function returns the years and grades the student is enrolled 
    // in.
    public function years_student_enrolled_for($student_id)
    {

    	return \DB::table('enrollments')
    		->join('students', 'students.id', '=', 'enrollments.student_id')
    		->join('grades', 'grades.id', '=', 'enrollments.current_grade')
    		->join('academics', 'academics.id', '=', 'enrollments.academic_id')
            ->select(
                'grades.id as grade_id',
                'grades.name as grade_name',
                'academics.year_start',
                'academics.year_end'
            )
            ->where([
                ['enrollments.student_id', $student_id],
                ['enrollments.enrollment_status', 'Enrolled']
            ])
    		->get();
    }

    // this function generates transcript for students.
    public function generate_transcript($request)
    {
        //get the student selected
        $student = Student::findOrFail($request->student_id);

        //get all the grades choosen
        $grades_ids = $request->grades_id;

        $scores_averages = \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->select(
                'subjects.name as subject',
                'grades.name as grade', 
                'academics.id as academic_id',
                'academics.year_start',
                'academics.year_end',
                \DB::raw('AVG(score) as averages')
            )
            ->groupBy('subjects.name', 'grades.name', 'academics.id')
            ->orderBy('academics.year_start', 'asc')
            ->where('scores.student_id', $student->id)
            ->whereIn('grades.id', $grades_ids)
            ->get();

        $institution = Institution::where('id', 1)->first();
        $subjects = $scores_averages->pluck('subject')->unique(); 
        $grades = $scores_averages->pluck('grade')->unique();

        //ids of academic years the student has been enrolled for.
        $academic_ids = $scores_averages->pluck('academic_id')->unique();

        //It is important to order the academic years exactly as it has been ordered when getting
        //the subject averages for the student transcript.
        $academics = Academic::whereIn('id', $academic_ids)->orderBy('year_start', 'asc')->get(['year_start', 'year_end', 'id']);

        
        $transcriptTable = [];

        foreach ($subjects as $subject) {
            foreach ($grades as $grade) {
                $transcriptTable[$subject][$grade] = '';
            }
        }

        foreach ($scores_averages as $row) {
            $transcriptTable[$row->subject][$row->grade] = round($row->averages, 0, PHP_ROUND_HALF_UP);
        }

        if (count($scores_averages) > 0) {
            return \View::make('admin.transcripts.partials.student-transcript')->with(
                [
                    'transcriptTable' => $transcriptTable,
                    'grades' => $grades,
                    'academics' => $academics,
                    'student' => $student,
                    'institution' => $institution,
                    'conduct' => $request->conduct,
                    'leaving_reason' => $request->leaving_reason
                ]
            );   
        } else {
            return ['none' => "Cannot generate transcript because no score found for student <b>".$student->full_name."</b>"];
        }
    }
}
