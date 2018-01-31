<?php

namespace App\Repositories;
use App\Academic;


/**
 * Holds queries functions to query the grades table.
 */
class GradesRepository
{
    /**
     * Returns the total number of enrolled students in each grade/class for the current academic year
     */
    public function grades_student_count()
    {
        $current_academic = Academic::where('status', 1)->first();

        return \DB::table('enrollments')
            ->join('grades', 'grades.id', '=', 'enrollments.current_grade')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->join('academics', 'academics.id', '=', 'enrollments.academic_id')
            ->select(
                'grades.name as name', 
               \DB::raw('COUNT(students.id) as students')
            )
            ->groupBy('grades.name')
            ->orderBy(\DB::raw('COUNT(students.id)'), 'desc')
             ->where([
                ['enrollments.academic_id', '=', $current_academic->id],
                ['enrollments.enrollment_status', '=', 'Enrolled']
            ])
            ->get();
    }
}
