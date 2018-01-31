<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enrollment;
use App\Academic;
use App\Student;
use App\Grade;
use App\Repositories\EnrollmentsRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;



class EnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EnrollmentsRepository $enrollment)
    {
        //
        $academics = Academic::orderBy('created_at', 'desc')->get();

        $academic = new Academic();
        $current_academic = $academic->current();

        $grades = \DB::table('grades')->get(['id', 'name']);
        
        $statuses = $enrollment->enrollment_statuses();

        return view('admin.enrollments.home', compact('academics', 'grades', 'statuses', 'current_academic'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make ( $request->all(), [
            'student_id' => 'required',
            'last_grade' => 'required',
            'current_grade' => 'required',
            'student_type' => 'required',
            'enrollment_status' => 'required',
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
            $grade = Grade::findOrFail($request->current_grade);

            $enrollment = Enrollment::create(request([
                'student_id',
                'last_grade',
                'current_grade',
                'student_type',
                'enrollment_status',
                'academic_id'
            ]));

            return response ()->json ([
                "success" => "<b>".$student->first_name." ".$student->surname."</b> enrolled in <b>".$grade->name."</b> with status <b>".$enrollment->enrollment_status."</b>"
            ]);         
        }    
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, EnrollmentsRepository $enrollmentRepo)
    {
        //
        $enrollment = Enrollment::FindOrFail($id);

        $student = \DB::table('enrollments')
            ->join('students', 'students.id', '=', 'enrollments.student_id')
            ->select(
                'students.id',
                'first_name',
                'middle_name',
                'surname',
                'enrollment_status',
                'student_type',
                'current_grade',
                'last_grade',
                'academic_id',
                'enrollments.id as enrollment_id'
            )
            ->where('enrollments.id', $enrollment->id)
            ->first();

        $academic = Academic::where('id', $student->academic_id)->first();
        $grades = Grade::all();
        $types = $enrollmentRepo->types();
        $statuses = $enrollmentRepo->enrollment_statuses();

        return view('admin.enrollments.edit', compact('student', 'grades', 'statuses', 'types', 'academic'));
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
        // validation rules
        $rules = [
            'student_id' => 'required',
            'last_grade' => 'required',
            'current_grade' => 'required',
            'student_type' => 'required',
            'enrollment_status' => 'required',
            'academic_id' => 'required'

        ];

        //validate and return errors
        $this->validate(request(), $rules);

        $enrollment = Enrollment::findOrFail($id);

        $student = Student::findOrFail($enrollment->student_id);

        $enrollment->update(request([
            'student_id',
            'last_grade',
            'current_grade',
            'student_type',
            'enrollment_status',
            'academic_id'
        ]));

        // send a message to the session 
        session()->flash('message', $student->first_name." ".$student->surname);

        return redirect('/enrollments');
    }

     /**
     * Returns students from the enrollments table within an academic year.
     *
     * @return \Illuminate\Http\Response
     */
    public function enrollmentAcademicStudents($id, EnrollmentsRepository $enrollment)
    {
        $academic = Academic::FindOrFail($id);
        $students = $enrollment->enrollment_academic_students($academic->id);


        if (count($students) > 0) {

            return \View::make('admin.enrollments.partials.academic-students')->with(
                [
                    'students' => $students,
                    'academic' => $academic
                ]
            );
        } else {
            return response("No students found");   
        }
    }

    /**
     * A student id is passed to this function. If such student id exists
     * in the enrollments table, than such student 'type' is 'old student'
     * otherwise 'new student'
     *
     * @return \Illuminate\Http\Response
     */
    public function studentExists($id, EnrollmentsRepository $enrollment)
    {
        $student_exists = $enrollment->enrollment_student_exists($id);

        if ($student_exists) {
            return response()->json([
                'student_type' => 'Old Student'
            ]);
        } else {
            return response()->json([
                'student_type' => 'New Student'
            ]);
        }
    }

    /*
    * This function returns students who are not enrolled for the 
    * current academic year.
    */
    public function unenrolledStudents(EnrollmentsRepository $enrollment)
    {
    
        $students = $enrollment->unenrolled_students();

        if (count($students) > 0) {
            return response()->json($students);   
        } else {
            return response()->json(['none' => "All Students are enrolled for this academic year."]);   
        }
    }

}
