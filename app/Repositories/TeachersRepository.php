<?php 

namespace App\Repositories;
use App\Teacher;
use App\Academic;
use App\Grade;


/**
*This class holds all the queries functions relating to teachers
 */
class TeachersRepository
{
    
   // gets the total number of teachers
    public static function teachers_count()
    {
        return Teacher::count();
    }


    //this function returns all grades/classes assigned to a teacher
    //in the current academic year
    public function teacher_grades($teacher_id){

        $academic = new Academic();
        $current_academic = $academic->current();
        
        return \DB::table('grade_teachers')
            ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
            ->join('grades', 'grades.id', '=', 'grade_teachers.grade_id')
            ->join('academics', 'academics.id', '=', 'grade_teachers.academic_id')
            ->select(
                'grades.name as name', 
                'grades.id as id'
            )
            ->where([
                ['grade_teachers.teacher_id', $teacher_id],
                ['academics.id', $current_academic->id]
            ])
            ->distinct()
            ->get();
    }

    /*
    * This function returns all grades/classes assigned to a teacher
    * in the academic year selected
    */
    public function teacher_academic_grades($teacher_id, $academic_id){
        
        return \DB::table('grade_teachers')
            ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
            ->join('grades', 'grades.id', '=', 'grade_teachers.grade_id')
            ->join('academics', 'academics.id', '=', 'grade_teachers.academic_id')
            ->select(
                'grades.name as name', 
                'grades.id as id'
            )
            ->where([
                ['grade_teachers.teacher_id', $teacher_id],
                ['academics.id', $academic_id]
            ])
            ->distinct()
            ->get();
    }


    // this function returns all the subjects assigned to a particular grade
    // that a teacher is teaching in the academic year that is current
    public static function teacher_grade_subjects($grade, $teacher)
    {
        $academic = new Academic();
        $current_academic = $academic->current();
           
        return \DB::table('grade_teachers')
            ->join('subjects', 'subjects.id', '=', 'grade_teachers.subject_id')
            ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
            ->join('grades', 'grades.id', '=', 'grade_teachers.grade_id')
            ->join('academics', 'academics.id', '=', 'grade_teachers.academic_id')
            ->select(
                'subjects.name', 
                'subjects.id'
            )
            ->distinct()
            ->where([
                ['grades.id', $grade],
                ['grade_teachers.teacher_id', $teacher],
                ['academics.id', $current_academic->id]
            ])
            ->pluck('name', 'id');
    }

    /*This function returns all the subjects assigned to a particular grade
    * that a teacher is teaching in the selected academic year
    */
    public static function teacher_academic_grade_subjects($teacher, $grade, $academic_id)
    {
           
        return \DB::table('grade_teachers')
            ->join('subjects', 'subjects.id', '=', 'grade_teachers.subject_id')
            ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
            ->join('grades', 'grades.id', '=', 'grade_teachers.grade_id')
            ->join('academics', 'academics.id', '=', 'grade_teachers.academic_id')
            ->select(
                'subjects.name', 
                'subjects.id'
            )
            ->distinct()
            ->where([
                ['grades.id', $grade],
                ['grade_teachers.teacher_id', $teacher],
                ['academics.id', $academic_id]
            ])
            ->pluck('name', 'id');
    }

    /*
    * this function returns scores of students who are in the classes a teacher
    * teaches for a specific subject and term(period)

    * The reason why the teacher id isn't specify here is that both the subject and grade 
    * ids being passed are contrained by the program to be grades a teacher is teaching
    * and subjects he/she teaches in such grade
    */
    public function teacher_students_scores($grade_id, $subject_id, $term_id, $academic_id)
    {
        return \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->join('academics', 'academics.id', '=', 'scores.academic_id')
            ->select(
                'subjects.name as subject', 
                'students.surname', 
                'students.first_name', 
                'students.student_code as code', 
                'score'
            )
            ->distinct()
            ->where([
                ['scores.term_id', $term_id],
                ['scores.grade_id', $grade_id],
                ['scores.subject_id', $subject_id],
                ['scores.academic_id', $academic_id]
            ])
            ->get();
    }


    /*
    * This function returns a listing of teachers from the "Grade Teacher Model"
    * who have grades and subjects assigned to them in a given academic year.
    */
    public function academic_teachers($academic_year)
    {
        $grade_teachers = \DB::table('grade_teachers')
            ->join('subjects', 'subjects.id', '=', 'grade_teachers.subject_id')
            ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
            ->join('grades', 'grades.id', '=', 'grade_teachers.grade_id')
            ->select(
                'teachers.id'
            )
            ->distinct()
            ->where('grade_teachers.academic_id', $academic_year)
            ->get();

        $teachers = Teacher::whereIn('id', $grade_teachers->pluck('id'))->get();

        return $teachers;
    }

    /*
    * This function returns the grads and subjects assigned to a teacher in 
    * an academic year.
    */
    public function grade_and_subject($academic_year, $teacher_id){

        return \DB::table('grade_teachers')
            ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
            ->join('subjects', 'subjects.id', '=', 'grade_teachers.subject_id')
            ->join('grades', 'grades.id', '=', 'grade_teachers.grade_id')
            ->join('academics', 'academics.id', '=', 'grade_teachers.academic_id')
            ->select(
                'teachers.id as teacher_id',
                'subjects.name as subject', 
                'grades.name as grade', 
                'grade_teachers.id as id',
                'academics.id as academic_id'
            )
            ->where([
                ['academics.id', $academic_year],
                ['teachers.id', $teacher_id]
            ])
            ->get();
    }

    //This function returns the details of the teacher assigned to a subject and grade
    //in an academic year. Used in the Grade Teacher create view.
    public function isAssigned($subject, $grade, $academic_year)
    {
        $grade_teacher = \DB::table('grade_teachers')
            ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
            ->join('subjects', 'subjects.id', '=', 'grade_teachers.subject_id')
            ->join('grades', 'grades.id', '=', 'grade_teachers.grade_id')
            ->join('academics', 'academics.id', '=', 'grade_teachers.academic_id')
            ->select(
                'teachers.id as teacher_id'
            )
            ->where([
                ['academics.id', $academic_year],
                ['subjects.id', $subject],
                ['grades.id', $grade]
            ])
            ->value('teacher_id');

        $teacher = Teacher::findOrFail($grade_teacher);

        return $teacher;
    }

    //This function queries out teachers who are not sponsors in the current academic year.
    public function teachers_with_no_sponsor_grade()
    {
        $academic = new Academic();
        $current_academic = $academic->current();
        
        $teachers_with_no_sponsor_grade = \DB::table('teachers')
            ->select(
                'teachers.id'
            )
            ->whereNotExists( function ($query) use ($current_academic) {
                $query->select(\DB::raw(1))
                ->from('grade_sponsors')
                ->whereRaw('teachers.id = grade_sponsors.teacher_id')
                ->where('grade_sponsors.academic_id', '=', $current_academic->id);
            })
            ->get();

        $teachers = Teacher::whereIn('id', $teachers_with_no_sponsor_grade->pluck('id'))->get(); 

        return $teachers;  
    }

    //This function queries out teachers who are not sponsors in the current academic year.
    public function grades_with_no_sponsor()
    {
        $academic = new Academic();
        $current_academic = $academic->current();
        
        $grades_with_no_sponsor = \DB::table('grades')
            ->select(
                'grades.id',
                'grades.name'
            )
            ->whereNotExists( function ($query) use ($current_academic) {
                $query->select(\DB::raw(1))
                ->from('grade_sponsors')
                ->whereRaw('grades.id = grade_sponsors.grade_id')
                ->where('grade_sponsors.academic_id', '=', $current_academic->id);
            })
            ->get();

        $grades = Grade::whereIn('id', $grades_with_no_sponsor->pluck('id'))->get(); 

        return $grades;  
    }

    /*
    * This function returns all the academic years that a teacher has been teaching for
    * in the school.
    */
    function teacher_academic_years($teacher)
    {
        $teacher_acad_years = \DB::table('grade_sponsors')
            ->join('teachers', 'teachers.id', '=', 'grade_sponsors.teacher_id')
            ->join('academics', 'academics.id', '=', 'grade_sponsors.academic_id')
            ->select(
                'academics.id as academic_id'
            )
            ->distinct()
            ->where('teachers.id', $teacher)
            ->get();

        $academics = Academic::whereIn('id', $teacher_acad_years->pluck('academic_id'))->get();

        return $academics;
    }

    /*
    * Return details of the grade a teacher is sponsoring.
    *
    */
    function sponsoring($teacher)
    {
        $academic = new Academic();
        $current_academic = $academic->current();
        
        return \DB::table('grade_sponsors')
            ->join('teachers', 'teachers.id', '=', 'grade_sponsors.teacher_id')
            ->join('grades', 'grades.id', '=', 'grade_sponsors.grade_id')
            ->join('academics', 'academics.id', '=', 'grade_sponsors.academic_id')
            ->where([
                ['grade_sponsors.teacher_id', $teacher],
                ['academics.id', $current_academic->id]
            ])
            ->value('grades.name');
    }

    /*
    * Returns the grade a teacher is sponsoring in an academic year.
    */
    function teacher_academic_sponsor_grade($teacher, $academic)
    {
        return \DB::table('grade_sponsors')
            ->join('teachers', 'teachers.id', '=', 'grade_sponsors.teacher_id')
            ->join('grades', 'grades.id', '=', 'grade_sponsors.grade_id')
            ->join('academics', 'academics.id', '=', 'grade_sponsors.academic_id')
            ->select(
                'grades.id',
                'grades.name'
            )
            ->where([
                ['academics.id', $academic],
                ['teachers.id', $teacher]
            ])
            ->get();
    }

}
