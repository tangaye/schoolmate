<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GradeTeacher;
use App\Teacher;
use App\Grade;
use App\Subject;





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
        $grades_teacher = GradeTeacher::gradeTeachers();
        //dd($grades_teacher);
        return view('admin.grades-teacher.home', compact('grades_teacher'));
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
        //dd($teachers);
        return view('admin.grades-teacher.create', compact('subjects', 'grades', 'teachers'));
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

        //dd($request);
        $this->validate($request, [
            'teacher_id' => 'required',
            'grade_id' => 'required',
            'subject_id' => 'required'
        ]);

        $grade = Grade::findOrFail($request->grade_id);
        $teacher = Teacher::findOrFail($request->teacher_id);
        $subject = Subject::findOrFail($request->subject_id);
        //dd($subject);

        try {

            $grades_teacher = GradeTeacher::create(request([
                'teacher_id',
                'grade_id',
                'subject_id'
            ]));

            // send a message to the session that greets/ thank user
            session()->flash('message', '<b><u>'.$teacher->surname.'</u></b> successfully assigned to <b>'.$grade->name.'</b> teaching <b>'.$subject->name.'</b>');

            return back();
            
        } catch (\Illuminate\Database\QueryException $e) {
            // 
            $error_code = $e->errorInfo[1];

            // if a duplicate entry error(1062) is caught display custom message
            if($error_code == 1062){

                $errors = "A Teacher has already been assigned to teach <b>".$subject->name."</b> in <b>".$grade->name."</b>";
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
            'message' => "Teacher unassigned from subject and grade!"
        ) );
    }
}
