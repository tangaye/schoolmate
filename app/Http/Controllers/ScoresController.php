<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Score;
use App\Student;
use App\Subject;
use App\Term;
use App\Grade;
use App\Semester;

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

        if (Auth::guard('admin')->check()) 
        {
            return view('scores.home', compact('terms'));
        } 
        else if (Auth::guard('web')->check()) {
            return view('user-scores.home', compact('terms'));
        }
    }

    /**
     * Display a form to retrieve terms/period tables.
     *
     * @return \Illuminate\Http\Response
     */
    public function scoreTerm(Request $request, Score $score)
    {
       $term = Term::findOrFail($request->term_id);

       $students = $score->termTables($term->id);

        if (Auth::guard('admin')->check()) 
        {
            return \View::make('scores.partials.term-tables')->with(array(
                'students'=>$students
            ));
        } 
        else if (Auth::guard('web')->check()) {
            return \View::make('user-scores.partials.term-tables')->with(array(
                'students'=>$students
            ));
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

        return view('scores.partials.master-scores-form', compact('subjects', 'grades', 'terms'));
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

        return \View::make('scores.create')->with(array(
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
                        'duplicate' => "A score already exists for <b>".$student->surname."</b> in <b>".$subject->name."</b> for <b>".$term->name."</b>. If you want to make changes to the score Please go to the <a href='#'>Scores</a> table to do the modification."
                    ) );
                }
            }
            
        }
    }

    /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function term(Request $request)
    {
        //
        $terms = Term::all();

        return view('scores.partials.student-term-scores', compact('terms'));
    }

    /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function findTerm(Request $request, Score $score)
    {
        //
        return $score->termReport($request->term_id, $request->student_code);
    }

    /**
     * Show the form to search for a specific.
     * student semester report
     *
     * @return \Illuminate\Http\Response
     */
    public function semester(Request $request)
    {
        //
        $semesters = Semester::all();
        return view('scores.partials.student-semester-scores', compact('semesters'));
    }

    public function findSemester(Request $request, Score $score)
    {
        return $score->semesterReport($request->student_code, $request->semester_id);
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
        // if validation succeeds update records

        // get score to be updated
        //dd($request);
        $score = Score::findOrFail($id);

        $student = Student::findOrFail($score->student_id);
        $subject = Subject::findOrFail($score->subject_id);
        $term = Term::findOrFail($score->term_id);

        $score->update(request([
            'student_id', 
            'subject_id', 
            'grade_id', 
            'term_id', 
            'score'
        ]));

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
}
