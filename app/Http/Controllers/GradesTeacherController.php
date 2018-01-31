<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GradeTeacher;
use App\Teacher;
use App\Grade;
use App\Subject;
use App\Academic;
use App\Repositories\TeachersRepository;


class GradesTeacherController extends Controller
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
        return view('admin.grades-teacher.home', compact('academics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $subjects = Subject::all();
        $grades = Grade::all();
        $teachers = Teacher::all();
        $current_academic = Academic::where('status', 1)->first();
        return view('admin.grades-teacher.create', compact('subjects', 'grades', 'teachers', 'current_academic'));
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
            'subject_id' => 'required',
            'academic_id' => 'required'
        ]);

        $grade = Grade::findOrFail($request->grade_id);
        $teacher = Teacher::findOrFail($request->teacher_id);
        $subject = Subject::findOrFail($request->subject_id);
        $academic = Academic::findOrFail($request->academic_id);

        try {

            $grades_teacher = GradeTeacher::create(request([
                'teacher_id',
                'grade_id',
                'subject_id',
                'academic_id'
            ]));

            // send a message to the session that greets/ thank user
            session()->flash('message', '<b><u>'.$teacher->surname.'</u></b> successfully assigned to <b>'.$grade->name.'</b> teaching <b>'.$subject->name.'</b> for <b>'.$academic->full_year.'</b>');

            return back();
            
        } catch (\Illuminate\Database\QueryException $e) {
            // 
            $error_code = $e->errorInfo[1];

            // if a duplicate entry error(1062) is caught display custom message
            if($error_code == 1062){

                $grade_teacher = new TeachersRepository();
                $teacher_assigned = $grade_teacher->isAssigned($subject->id, $grade->id, $academic->id);

                $errors = "Teacher <b>".$teacher_assigned->full_name."</b> is already assigned to teach <b>".$subject->name."</b> in <b>".$grade->name."</b>";
                return redirect()->back()
                    ->withInput()
                    ->withErrors($errors);
            }
        }

        
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
        $grade_teacher = GradeTeacher::findOrFail($id);
        $grade_teacher->delete();

        return response()->json ( array (
            'message' => "Teacher is no longer teaching this grade!"
        ) );
    }

    public function academicTeacher($academic_year, TeachersRepository $teacher)
    {
        $academic = Academic::findOrfail($academic_year);
        $teachers = $teacher->academic_teachers($academic->id);

        if (count($teachers) > 0) {
            return response()->json($teachers);
        } else {
            return response()->json(['none' => 'An assignment has not been made for any teacher in the academic year selected.']);
        }
    }

    public function teacherGradesAndSubjects(Request $request, TeachersRepository $teacher)
    {
        $instructor = Teacher::findOrfail($request->teacher_id);
        $academic = Academic::findOrfail($request->academic_id);

        $grade_teacher = $teacher->grade_and_subject($academic->id, $instructor->id);

        if (count($grade_teacher) > 0) {
            return \View::make('admin.grades-teacher.partials.teacher-academic-subject-and-grade')->with(
            [
                'grade_teacher' => $grade_teacher,
                'instructor' => $instructor,
                'academic' => $academic
            ]
        );
        } else {
            return response()->json(['none' => 'No grade and subject assigned to the teacher selected.']);
        }
    }
}
