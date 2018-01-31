<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Academic;
use App\Teacher;
use App\Grade;
use App\GradeSponsor;
use App\Repositories\TeachersRepository;
use Illuminate\Support\Facades\Validator;

class GradesSponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $academics = Academic::all();
        $academic = new Academic();
        $current_academic = $academic->current();

        return view('admin.grades-sponsor.home', compact('academics', 'current_academic'));
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
        $this->validate($request, [
            'teacher_id' => 'required',
            'grade_id' => 'required',
            'academic_id' => 'required'
        ]);

        $grade = Grade::findOrFail($request->grade_id);
        $teacher = Teacher::findOrFail($request->teacher_id);
        $academic = Academic::findOrFail($request->academic_id);

        try {

            $grades_teacher = GradeSponsor::create(request([
                'teacher_id',
                'grade_id',
                'academic_id'
            ]));

            return response ()->json ([
                "success" => '<b><u>'.$teacher->full_name.'</u></b> successfully assigned  as sponsor to <b>'.$grade->name.'</b> for <b>'.$academic->full_year.'</b>'
            ]);  
            
        } catch (\Illuminate\Database\QueryException $e) {
            // 
            $error_code = $e->errorInfo[1];

            // if a duplicate entry error(1062) is caught display custom message
            if($error_code == 1062){

                $errors = "A teacher is already assigned as sponsor to <b>".$grade->name."</b> in <b>".$academic->full_year."</b>";
                return redirect()->back()
                    ->withInput()
                    ->withErrors($errors);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, TeachersRepository $teacher)
    {
        //
        //
        $grade_sponsors = GradeSponsor::FindOrFail($id);

        $sponsor = \DB::table('grade_sponsors')
            ->join('teachers', 'teachers.id', '=', 'grade_sponsors.teacher_id')
            ->join('academics', 'academics.id', '=', 'grade_sponsors.academic_id')
            ->join('grades', 'grades.id', '=', 'grade_sponsors.grade_id')
            ->select(
                'grade_sponsors.id',
                'teachers.id as teacher_id',
                'first_name',
                'surname',
                'grades.id as grade_id',
                'grades.name',
                'academics.id as academic_id'
            )
            ->where('grade_sponsors.id', $grade_sponsors->id)
            ->first();

        $instructor = Teacher::findOrFail($sponsor->teacher_id);

        //get all the grades assigned to the teacher
        $grades = $teacher->teacher_grades($instructor->id);

        $academic = Academic::where('id', $sponsor->academic_id)->first();

        return view('admin.grades-sponsor.edit', compact('sponsor', 'academic', 'grades'));
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
        $rules = [
            'teacher_id' => 'required',
            'grade_id' => 'required',
            'academic_id' => 'required'
        ];

        //validate and return errors
        $this->validate(request(), $rules);

        $grade_sponsors = GradeSponsor::findOrFail($id);

        $teacher = Teacher::findOrFail($grade_sponsors->teacher_id);

        $grade_sponsors->update(request([
            'teacher_id',
            'grade_id',
            'academic_id'
        ]));

        // send a message to the session 
        session()->flash('message', $teacher->full_name);

        return redirect('/admin/sponsor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grade_sponsor = GradeSponsor::findOrFail($id);
        $teacher = Teacher::findOrFail($grade_sponsor->teacher_id);
        $grade = Grade::findOrFail($grade_sponsor->grade_id);
        $grade_sponsor->delete();

        return response()->json ( array (
            'message' => $teacher->full_name."is no longer a sponsor of ".$grade->name."!"
        ) );
    }

    /**
     * Returns sponsors of grades within an academic year.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function academicSponsors($academic_year)
    {
        $academic = Academic::findOrFail($academic_year);

        $sponsors = \DB::table('grade_sponsors')
            ->join('teachers', 'teachers.id', '=', 'grade_sponsors.teacher_id')
            ->join('grades', 'grades.id', '=', 'grade_sponsors.grade_id')
            ->join('academics', 'academics.id', '=', 'grade_sponsors.academic_id')
            ->select(
                'grade_sponsors.id',
                'teachers.first_name',
                'teachers.surname',
                'grades.name as grade_name',
                'academics.year_start',
                'academics.year_end'
            )
            ->where('academics.id', $academic->id)
            ->get();

        if (count($sponsors) > 0) {
            return \View::make('admin.grades-sponsor.partials.academic-sponsors')->with(
                [
                    'sponsors' => $sponsors,
                    'academic' => $academic
                ]
            );
        } else {
            return response()->json(['none' => 'No sponsor found in the selected academic year.']);
        }
    }

    /**
     * Returns a listing of teachers who are not sponsors of a grade.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function notASponsor(TeachersRepository $teacher)
    {
        $teachers = $teacher->teachers_with_no_sponsor_grade();

        if (count($teachers) > 0) {
            return response()->json($teachers);   
        } else {
            return response()->json(['none' => "All teachers are assigned to sponsor a grade."]);   
        }
    }

    /**
     * Returns a listing of grades that a teacher is teaching in the current academic year.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function teacherGrades($teacher_id, TeachersRepository $teacher)
    {

        $instructor = Teacher::findOrFail($teacher_id);
        $grades = $teacher->teacher_grades($instructor->id);

        if (count($grades) > 0) {
            return response()->json($grades);   
        } else {
            return response()->json(['none' => "There are no grades assigned to the teacher selected."]);   
        }
    }
}
