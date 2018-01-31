<?php

namespace App\Repositories;
use App\Enrollment;
use App\Student;
use App\Academic;


/**
 * summary
 */
class EnrollmentsRepository
{
    public function types()
    {
        return [
            "Old Student", 
            "New Student"
        ];
    }

    public function enrollment_statuses()
    {
        return [
            "Enrolled", 
            "Pending",
            "Suspended",
            "Expelled",
            "Dropped"
        ];
    }

    /*
    * This function returns students from the enrollment table within 
    * a particular academic year with their enrollment detatils.
    */
    public function enrollment_academic_students($academic_id)
    {
        return \DB::table('enrollments as enroll')
            ->join('students as stud', 'stud.id', '=', 'enroll.student_id')
            ->join('academics as acad', 'acad.id', '=', 'enroll.academic_id')
            ->join('grades as lastGrade', 'lastGrade.id', '=', 'enroll.last_grade')
            ->join('grades as currentGrade', 'currentGrade.id', '=', 'enroll.current_grade')
            ->select(
                'enroll.id as enrollment_id',
                'stud.id as student_id',
                'stud.student_code as student_code',
                'stud.first_name',
                'stud.surname',
                'lastGrade.id as last_grade_id',
                'lastGrade.name as last_grade',
                'currentGrade.id as current_grade_id',
                'currentGrade.name as current_grade',
                'enroll.student_type',
                'enroll.enrollment_status',
                'acad.id as academic_id'
            )
            ->where('enroll.academic_id', $academic_id)
            ->get();
    }

    /*
    * This function returns all students who have been enrolled in the school
    * or who enrollment status is set to " enrolled". Regardless of a specific
    * academic year.
    */
    public function enrolled_students()
    {
        return \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->select(
                'students.id',
                'student_code',
                'first_name',
                'middle_name',
                'surname'
            )
            ->distinct()
            ->where('enrollments.enrollment_status', 'Enrolled')
            ->get();
    }

    public function enrollment_student_exists($student_id)
    {

        $student = Student::findOrFail($student_id);

        $student_exists = Enrollment::where('student_id', $student->id)->distinct()->first();

        if ($student_exists === null) {
            return false;
        } else {
           return true; 
        }
    }

    // this gunction returns students who have no enrollments details 
    // in the enrollment table for the current academic year.
    public function unenrolled_students()
    {
        $academic = new Academic;
        $current_academic = $academic->current();

        return \DB::table('students')
            ->select(
                'students.id',
                'student_code',
                'first_name',
                'middle_name',
                'surname'
            )
            ->whereNotExists( function ($query) use ($current_academic) {
                $query->select(\DB::raw(1))
                ->from('enrollments')
                ->whereRaw('students.id = enrollments.student_id')
                ->where('enrollments.academic_id', '=', $current_academic->id);
            })
            ->get();
    }
}
