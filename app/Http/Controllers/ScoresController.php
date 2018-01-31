<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Score;
use App\Student;
use App\Subject;
use App\Term;
use App\Grade;
use App\Semester;
use App\Academic;

use App\Repositories\ScoresRepository;


class ScoresController extends Controller
{
    
    /**
     * Display a form to retrieve terms/period tables.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::all();
        $grades = Grade::all();
        $academics = Academic::all();

        return view('scores.home', compact('terms', 'grades', 'academics'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Academic $academic)
    {
        //
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
                'students.surname', 
                'students.first_name', 
                'students.middle_name', 
                'students.id', 
                'grades.id as grade'
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
            return response()->json(["none" => "There is no <u>Enrolled</u> students in <b>".$grade->name."</b> for academic year: <b>".$current_academic->full_year."</b>"]);
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
            'score' => 'bail|required|min:2|max:3',
            'academic_id' => 'required'
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
            $academic = Academic::findOrFail($request->academic_id);



            try {


                $score = Score::create(request([
                    'student_id', 
                    'subject_id', 
                    'grade_id', 
                    'term_id', 
                    'score',
                    'academic_id'
                ]));

                return response ()->json ( array( "success" => "<b>".$student->surname."</b>". " score of "."<b>".$score->score."</b> in <b>".$subject->name."</b> for <b>".$term->name."</b> save") );
                
            } catch (\Illuminate\Database\QueryException $e) {
                // 
                $error_code = $e->errorInfo[1];

                // if a duplicate entry error(1062) is caught display custom message
                if($error_code == 1062){

                    

                    return response()->json ( array (
                        'duplicate' => "A score already exists for <b>".$student->first_name." ".$student->surname."</b> in <b>".$subject->name."</b> for <b>".$term->name."</b>."
                    ) );
                }
            }
            
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make ( $request->all(), [
            'score' => 'bail|required|min:2|max:3'
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds update records

        // get score to be updated
        //dd($request);
        $score = Score::findOrFail($id);

        $student = Student::findOrFail($score->student_id);
        $subject = Subject::findOrFail($score->subject_id);
        $term = Term::findOrFail($score->term_id);

        $score->update(request(['score']));

        return response ()->json ( array( 

            "success" => "<b>".$student->surname."</b>". " score of "."<b>".$score->score."</b> in <b>".$subject->name."</b> for <b>".$term->name."</b> updated!",

            "score" => $score::where('id', $score->id)
                ->with('student')
                ->with('grade')
                ->with('subject')
                ->with('term')
                ->get()
        ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $score = Score::findOrFail($id);

        $student = Student::findOrFail($score->student_id);
        $subject = Subject::findOrFail($score->subject_id);
        $term = Term::findOrFail($score->term_id);

        $score->delete();

        return response ()->json ( array( 

            "message" => $student->surname. " score of ".$score->score." in ".$subject->name." for ".$term->name." deleted!"
        ) );
    }

    /**
     * Display a form to retrieve terms/period tables for an 
     * academic year.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentScores(Request $request, ScoresRepository $scores)
    {
       $term = Term::findOrFail($request->term_id);
       $grade = Grade::findOrFail($request->grade_id);
       $subject = Subject::findOrFail($request->subject_id);
       $academic = Academic::findOrFail($request->academic_id);

       $students_score = $scores->findScores($grade->id, $subject->id, $term->id, $academic->id);

       if (count($students_score) > 0) {
            return \View::make('scores.partials.students-scores')->with(
                [
                    'students' => $students_score,
                    'grade' => $grade->name,
                    'term' => $term->name,
                    'subject' => $subject->name,
                    'academic' => $academic->full_year
                ]
            );
       } else {
           return  response()->json(['none' => 'No score found for students in <b>'.$grade->name.'</b> for academic year <u>'.$academic->full_year.'</u>']);
       }
    
    }

    /**
     * Show the form to generate master grade sheet.
     *
     * @return \Illuminate\Http\Response
     */
    public function master()
    {
        $subjects = Subject::all();
        $terms = Term::all();
        $grades = Grade::all();
        $academics = Academic::all();


        return view('scores.master-scores-form', compact('subjects', 'grades', 'terms', 'academics'));
    }

    // returns students who have score recorded for in an academic year
    public function academicStudents($id, ScoresRepository $scores)
    {
        $academic = Academic::findOrFail($id);
        $students = $scores->scores_academic_students($academic->id);
        if (count($students) > 0) {
            return response()->json($students);
        } else {
            return response()->json(array('none' => 'No score recorded for students in the specify academic year!'));
        }
    }

    /*
    * This function returns grades that have scores recorded for them in an
    * academic year.
    */
    public function academicScoresGrades($academic_year, ScoresRepository $scores)
    {
        $academic = Academic::findOrFail($academic_year);
        $grades = $scores->scores_academic_grades($academic->id);

        if (count($grades) > 0) {
            return response()->json($grades);
        } else {
            return response()->json(array('none' => 'There are no grades that scores have been recorded for!'));
        }
    }
}
