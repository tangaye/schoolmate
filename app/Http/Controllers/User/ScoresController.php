<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Score;
use App\Student;
use App\Subject;
use App\Term;
use App\Grade;
use App\Semester;
use App\Repositories\ScoresRepository;
use App\User;
use App\Academic;

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
        $user = User::findOrFail(Auth::guard('web')->user()->id);
        return view('user.scores.home', compact('terms', 'grades', 'user', 'academics'));
    }

    /**
     * Display a form to retrieve terms/period tables.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentScores(Request $request, ScoresRepository $scores)
    {
        $term = Term::findOrFail($request->term_id);
        $grade = Grade::findOrFail($request->grade_id);
        $subject = Subject::findOrFail($request->subject_id);
        $academic = Academic::findOrFail($request->academic_id);

        $students = $scores->findScores($grade->id, $subject->id, $term->id, $academic->id);

        if (count($students) > 0) {
            return \View::make('user.scores.partials.students-scores')->with(
                [
                    'students' => $students,
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

}

