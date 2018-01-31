<?php 

namespace App\Repositories;
use App\Academic;
use App\Enrollment;


/**
 * Holds queries functions to query the students table
 */
class StudentsRepository
{
   
    /**
     * this function returns the total number of enrolled students by gender
     * for the current academic year
     */
    public function students_gender_count()
    {
        $academics = new Academic;
        $current_academic = $academics->current();

    	return \DB::table('enrollments')
    		->join('students', 'students.id', '=', 'enrollments.student_id')
    		->join('academics', 'academics.id', '=', 'enrollments.academic_id')
    		->select(
    			'students.gender',
    			\DB::raw('COUNT(students.gender) as total')
    		)
    		->groupBy('students.gender')
    		->where([
                ['enrollments.academic_id', '=', $current_academic->id],
                ['enrollments.enrollment_status', '=', 'Enrolled']
            ])
            ->get();
    }

    /**
    * This function returns the total number of enrolled students for the current academic year
    */
    public static function students_count()
    {
        $academics = new Academic;
        $current_academic = $academics->current();

        return \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->join('academics', 'academics.id', '=', 'enrollments.academic_id')
            ->select(
                'students.id',
                'students.first_name',
                'students.surname',
                'enrollments.enrollment_status',
                'enrollments.academic_id',
                'academics.year_start'
            )
            ->where([
                ['enrollments.academic_id', '=', $current_academic->id],
                ['enrollments.enrollment_status', '=', 'Enrolled']
            ])
            ->count();
    }

    // return the years a student has been enrolled in the school for
    public function period_of_attendence($student_id)
    {
        return \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->join('academics', 'academics.id', '=', 'enrollments.academic_id')
            ->select(
                'academics.year_start',
                'academics.year_end'
            )
            ->where('enrollments.student_id', $student_id)
            ->get();
    }

}
