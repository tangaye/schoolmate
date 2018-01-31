<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Term;
use App\Teacher;
use App\Grade;
use App\Subject;
use App\Student;
use App\Score;
use App\Academic;

use App\Repositories\TeachersRepository;
use App\Repositories\ScoresRepository;


/**
 * This class allows an instructor to view and enter scores of 
 * students he/she teaches, but removes functions that allows one
 * to update and delete scores.
 * 
 */

class ScoresController extends Controller
{
    /**
     * Display a form to retrieve terms/period tables.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TeachersRepository $teacher)
    {
        //
        $terms = Term::all();
        $instructor = Teacher::findOrFail(Auth::guard('teacher')->user()->id);
        // returns all grades teacher is teaching 
        $teacher_grades = $teacher->teacher_grades($instructor->id); 
        //years teacher has been teaching for.
        $academics = $teacher->teacher_academic_years($instructor->id);

        return view('teacher.scores.home', compact('teacher_grades', 'terms', 'academics'));

    }

     /**
     * Show the form to generate master grade sheet.
     *
     * @return \Illuminate\Http\Response
     */
    public function master(TeachersRepository $teachers)
    {
        $terms = Term::all();
        $teacher_grades = $teachers->teacher_grades(Auth::guard('teacher')->user()->id); 
        return view('teacher.scores.master-scores-form', compact('teacher_grades', 'terms'));
    }


     /**
     * displays scores of students who are taught by a logged in teacher
     *
     * @return \Illuminate\Http\Response
     */
    public function studentsScores(Request $request, TeachersRepository $teachers)
    {
       $term = Term::findOrFail($request->term_id);
       $grade = Grade::findOrFail($request->grade_id);
       $subject = Subject::findOrFail($request->subject_id);
       $academic = Academic::findOrFail($request->academic_id);

       $students = $teachers->teacher_students_scores($grade->id, $subject->id, $term->id, $academic->id);

        if (count($students) > 0) {
            return \View::make('teacher.scores.partials.students-scores')->with(array(
                'students' => $students,
                'grade' => $grade->name,
                'term' => $term->name,
                'subject' => $subject->name,
                'academic' => $academic->full_year
            ));   
        } else {
           return  response()->json(['none' => 'No score found for students in <b>'.$grade->name.'</b> for academic year <u>'.$academic->full_year.'</u>']);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $academic = new Academic;
        $current_academic = $academic->current();
        $grade = Grade::findOrFail($request->grade_id);
        $term = Term::findOrFail($request->term_id);
        $subject = Subject::findOrFail($request->subject_id);

        // return a listing of enrolled students in a particular grade/class
        // so that subject score for a term(1st, 2nd, 3rd period) can be  recorded for the current academic year.
        $enrolled_students = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->join('grades', 'grades.id', '=', 'enrollments.current_grade')
            ->join('academics', 'academics.id', '=', 'enrollments.academic_id')
            ->select(
                'students.id'
            )
            ->where([
                ['enrollments.current_grade', '=', $grade->id],
                ['enrollments.academic_id', '=', $current_academic->id],
                ['enrollments.enrollment_status', '=', 'Enrolled']
            ])
            ->get();  

        $students = Student::whereIn('id', $enrolled_students->pluck('id'))->get();

        if (count($students) > 0) {
            return \View::make('scores.partials.create')->with(
                [
                    'students' => $students, 
                    'grade' => $grade, 
                    'subject' => $subject, 
                    'term' => $term,
                    'academic' => $current_academic
                ]
            );
            
        } else {
            return "There is no <u>Enrolled</u> students in <b>".$grade->name."</b> for academic year: <b>".$current_academic->full_year."</b>";
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make ( $request->all(), [
            'student_id' => 'required',
            'subject_id' => 'required',
            'grade_id' => 'required',
            'term_id' => 'required',
            'score' => 'bail|required|min:2|max:3'
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $student = Student::findOrFail($request->student_id);
            $subject = Subject::findOrFail($request->subject_id);
            $term = Term::findOrFail($request->term_id);

            try {
                $score = Score::create(request([
                    'student_id', 
                    'subject_id', 
                    'grade_id', 
                    'term_id', 
                    'score'
                ]));

                return response ()->json ( array( "success" => "<b>".$student->surname."</b>". " score of "."<b>".$score->score."</b> in <b>".$subject->name."</b> for <b>".$term->name."</b> save") );
                
            } catch (\Illuminate\Database\QueryException $e) {
                // 
                $error_code = $e->errorInfo[1];

                // if a duplicate entry error(1062) is caught display custom message
                if($error_code == 1062){
                    return response()->json ( array (
                        'duplicate' => "A score already exists for <b>".$student->surname."</b> in <b>".$subject->name."</b> for <b>".$term->name."</b>."
                    ) );
                }
            }
            
        }
    }


    // returns students who have score recorded for in an academic year
    public function academicGradeStudents(Request $request, ScoresRepository $scores)
    {
        $academic = Academic::findOrFail($request->academic_id);
        $sponsor_grade = Grade::findOrFail($request->grade_id);

        $students = $scores->scores_grade_academic_students($academic->id, $sponsor_grade->id);

        if (count($students) > 0) {
            return response()->json($students);
        } else {
            return response()->json(array('none' => 'No score recorded for students in <b>'.$sponsor_grade->name.'</b> for <u>'.$academic->full_year.'</u>'));
        }
    }

   
}
