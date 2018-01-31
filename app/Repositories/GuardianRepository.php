<?php 

namespace App\Repositories;
use App\Guardian;
use App\Academic;
use App\Student;



/**
 * Holds functions to query the query the guardian table.
 */
class GuardianRepository
{
	/*
	* Returns all academic years of students assigned to the guardian logged
	* in who have any kind of enrollment status(Enrolled, Pending, E.t.c).
	* Details of these academic years will be view on the guardian dashboard.
	*
	* With such a logged in guardian can view all students assigned to him/her
	* and their enrollment details.
	*/
	public function guardian_student_dashboard_academic_years($guardian)
    {
        $years = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->join('academics', 'academics.id', '=', 'enrollments.academic_id')
            ->select(
                'academics.id'
            )
            ->distinct()
            ->where('students.guardian_id', $guardian)
            ->whereNotNull('enrollments.enrollment_status')
            ->get();

        $academics = Academic::whereIn('id', $years->pluck('id'))->get();

        return $academics;
    }

    /*
	* Returns all academic years of students assigned to the guardian logged
	* who enrollment status is set to "Enrolled".
	* This is so that the guardian logged in can only view attendence details
	* and reports of students who are enrolled in the academic year to be selected.
	*
	* I think it makes no sense for a guardian to view a student term report 
	* whilst the student is not enrolled for the academic year selected.
	*/
    public static function guardian_student_academic_years($guardian)
    {
        $years = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->join('academics', 'academics.id', '=', 'enrollments.academic_id')
            ->select(
                'academics.id'
            )
            ->distinct()
            ->where([
                ['enrollments.enrollment_status', 'Enrolled'],
                ['students.guardian_id', $guardian]
            ])
            ->get();

        $academics = Academic::whereIn('id', $years->pluck('id'))->get();

        return $academics;
    }

    /*
    * This function returns students who enrollment status is set to 'Enrolled'
    * for a particular academic year and are assigned to the guardian logged in.
    * Details of these will be populated into a list for the logged in guardian
    * to view reports and attendece of the student selected.
    */
    public function guardian_academic_students($guardian, $academic_year)
    {
    
        $guardian_students = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->join('academics', 'academics.id', '=', 'enrollments.academic_id')
            ->select(
                'students.id'
            )
            ->where([
                ['enrollments.enrollment_status', 'Enrolled'],
                ['enrollments.academic_id', $academic_year],
                ['students.guardian_id', $guardian]
            ])
            ->get();

        $students = Student::whereIn('id', $guardian_students->pluck('id'))->get();

        return $students;
    }

    /*
    * This function returns students who are assigned to the logged in guardian
    * for a particular academic year regardless of their enrollment status.
    * Details of these students will be shown on the guardian dashboard.
    */
    public function guardian_dashboard_academic_students($guardian, $academic_year)
    {
        // returns students who are enrolled for the academic year selected and 
        // are assigned to the guardian logged in
        $guardian_students = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->join('academics', 'academics.id', '=', 'enrollments.academic_id')
            ->select(
                'students.id'
            )
            ->where([
                ['enrollments.academic_id', $academic_year],
                ['students.guardian_id', $guardian]
            ])
            ->get();

        $students = Student::whereIn('id', $guardian_students->pluck('id'))->get();

        return $students;
    }

}


