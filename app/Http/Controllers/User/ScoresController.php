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

        return view('user-scores.home', compact('terms'));
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

       return \View::make('user-scores.partials.term-tables')->with(array(
                'students'=>$students
            ));

    }

}

