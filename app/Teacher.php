<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class Teacher extends Authenticatable
{
	use Notifiable;

    protected $guard = 'teacher';

    protected $fillable = [
        'first_name',
        'surname',
        'gender',
        'date_of_birth',
        'qualification',
        'address',
        'phone',
        'user_name',
        'email',
        'password',
    ];

    // relationship between teacher and students
    // a teacher teaches many students
    public function students()
    {
    	return $this->hasMany(Student::class);
    }

    // relationship between teacher and grades
    // a teacher teaches many grades/classes
    public function grades()
    {
    	return $this->hasMany(Grade::class);
    }

    // returns the grade a teacher is sponsor of
    public function sponsor_grade()
    {
        return  $this->hasOne(Grade::class);
    }

    // this helps get a readable format for the date of birth field
    protected $dates = ['date_of_birth'];

    public function setDateOfBirthAttribute($value)
    {
       return $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    // gets the total number of teachers
    public static function teachers_count()
    {
        return Teacher::count();
    }

    public function gradesTeacher()
    {
        return $this->hasMany(GradeTeacher::class);
    }

    //this function returns all grades/classes assigned to a teacher
   public static function teacherGrades($teacher_id){
        return \DB::table('grade_teachers')
            ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
            ->join('grades', 'grades.id', '=', 'grade_teachers.grade_id')
            ->select(
                'grades.name as name', 
                'grades.id as id'
            )
            ->where('grade_teachers.teacher_id', $teacher_id)
            ->distinct()
            ->get();
    }

    /**public static function teacherGrades($teacher_id){
        return \DB::table('grade_teachers')
            ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
            ->join('grades', 'grades.id', '=', 'grade_teachers.grade_id')
            ->join('subjects', 'subjects.id', '=', 'grade_teachers.subject_id')
            ->select(
                \DB::raw('count(subject_id) as subject'),
                'grades.name as name',
            )
            ->where('grade_teachers.teacher_id', $teacher_id)
            ->groupBy('grades.name')
            ->get();
    }**/

   

    // this function returns all subjects assigned to a teacher
    public static function teacherSubjects($teacher_id){
        return \DB::table('grade_teachers')
            ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
            ->join('subjects', 'subjects.id', '=', 'grade_teachers.subject_id')
            ->select(
                'subjects.name as name'
            )
            ->where('grade_teachers.teacher_id', $teacher_id)
            ->distinct()
            ->get();
    }

    // this function returns all the subjects assigned to a particular class
    // a teacher is teaching
    public static function teacherGradeSubjects($id, $teacher_id)
    {
        return \DB::table('grade_teachers')
            ->join('subjects', 'subjects.id', '=', 'grade_teachers.subject_id')
            ->join('teachers', 'teachers.id', '=', 'grade_teachers.teacher_id')
            ->join('grades', 'grades.id', '=', 'grade_teachers.grade_id')
            ->select(
                'subjects.name as name', 
                'subjects.id as id'
            )
            ->distinct()
            ->where('grades.id', $id)
            ->where('grade_teachers.teacher_id', $teacher_id)
            ->pluck('name', 'id');
    }

    /*
    * this function returns scores of students who are in the classes a teacher
    * teaches for a specific subject and term(period)

    * The reason why the teacher id isn't specify here is that both the subject and grade 
    * ids being passed are contrained by the program to be grades a teacher is teaching
    * and subjects he/she teaches in such grade
    */
    public static function teacherStudentsScores($grade_id, $subject_id, $term_id)
    {
        return \DB::table('scores')
            ->join('subjects', 'subjects.id', '=', 'scores.subject_id')
            ->join('terms', 'terms.id', '=', 'scores.term_id')
            ->join('grades', 'grades.id', '=', 'scores.grade_id')
            ->join('students', 'students.id', '=', 'scores.student_id')
            ->join('grade_teachers', 'grade_teachers.subject_id', '=', 'scores.subject_id')
            ->select(
                'subjects.name as subject', 
                'students.surname', 
                'students.first_name',  
                'score'
            )
            ->where('scores.term_id', $term_id)
            ->where('scores.grade_id', $grade_id)
            ->where('scores.subject_id', $subject_id)
            ->distinct()
            ->get();
    }



}
