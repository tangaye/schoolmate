<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $grades = Grade::all();

        return view('user-scores.home', compact('terms', 'grades'));
    }

    /**
     * Display a form to retrieve terms/period tables.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentScores(Request $request, Score $score)
    {
       $term = Term::findOrFail($request->term_id);
       $grade = Grade::findOrFail($request->grade_id);
       $subject = Subject::findOrFail($request->subject_id);

       $students = $score->findScores($grade->id, $subject->id, $term->id);
       //dd($students);

        return \View::make('user-scores.partials.students-scores')->with(array(
                'students'=>$students
            ));
    }

}

