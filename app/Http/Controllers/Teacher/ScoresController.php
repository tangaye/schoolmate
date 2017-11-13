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
    public function index()
    {
        //
        $terms = Term::all();
        // returns all grades teacher is teaching
        $teacher_grades = Teacher::teacherGrades(Auth::guard('teacher')->user()->id); 

        return view('teacher.scores.home', compact('teacher_grades', 'terms'));

    }

     /**
     * Show the form to generate master grade sheet.
     *
     * @return \Illuminate\Http\Response
     */
    public function master()
    {
        $terms = Term::all();
        $teacher_grades = Teacher::teacherGrades(Auth::guard('teacher')->user()->id); 
        //dd($teacher_grades);
        return view('teacher.scores.master-scores-form', compact('teacher_grades', 'terms'));
    }


    // returns all subjects assigned to a grade that a teacher is teaching
    public function gradeSubjects($id)
    {
        $subjects = Teacher::teacherGradeSubjects($id, Auth::guard('teacher')->user()->id);

        return response()->json($subjects);
    }


     /**
     * displays scores of students who are taught by a logged in teacher
     *
     * @return \Illuminate\Http\Response
     */
    public function studentsScores(Request $request)
    {
       $term = Term::findOrFail($request->term_id);
       $grade = Grade::findOrFail($request->grade_id);
       $subject = Subject::findOrFail($request->subject_id);

       $students = Teacher::teacherStudentsScores($grade->id, $subject->id, $term->id);
       //dd($students);

        return \View::make('teacher.scores.partials.students-scores')->with(array(
                'students'=>$students,
                'grade' => $grade->name,
                'term' => $term->name,
                'subject' => $subject->name
            ));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $grade = Grade::findOrFail($request->grade_id);
        $term = Term::findOrFail($request->term_id);
        $subject = Subject::findOrFail($request->subject_id);


        $students = \DB::table('students')
            ->join('grades', 'grades.id', '=', 'students.grade_id')
            ->select('students.surname', 'students.first_name', 'students.middle_name', 'students.id', 'grades.id as grade')
            ->where('students.grade_id', $grade->id)
            ->get();  

        return \View::make('scores.partials.create')->with(array(
            'students'=>$students, 
            'grade'=>$grade->name, 
            'subject'=>$subject, 
            'term'=>$term
        ));

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

   
}
