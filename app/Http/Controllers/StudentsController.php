<?php

namespace App\Http\Controllers;

use App\Student;
use App\Grade;
use App\User;
use App\Guardian;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $students = Student::with('grade')->get();

        return view('students.home', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //pass guardians to be assigned to students
        $guardians = \DB::table('guardians')
            ->join('users', 'users.id', '=', 'guardians.user_id')
            ->select('users.surname', 'users.first_name', 'guardians.id')
            ->where('users.type', '\App\Guardian')
            ->get();

        $grades = Grade::all();
        //$guardians = User::where('type', '\App\Guardian')->get();
       
        return view('students.create', compact('grades', 'guardians'));
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
         // validation rules
        $rules = [
            'first_name' => 'bail|required|max:50|min:1|regex:/^[a-z ,.\'-]+$/i',
            'middle_name' => 'bail|nullable|max:50|regex:/^[a-z ,.\'-]+$/i',
            'surname' => 'bail|required|max:50|min:1|regex:/^[a-z ,.\'-]+$/i',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'bail|required|regex:/^[a-z ,.\'-]+$/i',
            'phone' => 'nullable',
            'county' => 'nullable',
            'country' => 'required|regex:/^[a-z ,.\'-]+$/i',
            'last_grade' => 'nullable',
            'last_school' => 'nullable',
            'religion' => 'nullable',
            'student_type' => 'required',
            'grade_id' => 'required|numeric',
            'guardian_id' => 'required|numeric'
        ];

        //validate and return errors
        $this->validate(request(), $rules);

        // create a student
        $student = Student::create(request([
            'first_name',
            'middle_name',
            'surname',
            'date_of_birth',
            'gender',
            'address',
            'phone',
            'county',
            'country',
            'religion',
            'student_type',
            'last_school',
            'last_grade',
            'grade_id',
            'guardian_id'
        ]));

        // get the student id and generate a unique code for the student
        $student->student_code = str_pad($student->id, 4, '0', STR_PAD_LEFT);
        // save
        $student->save();

        // send a message to the session that greets/ thank user
        session()->flash('message', $student->first_name." ".$student->surname);

        return back();
            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $student = Student::findOrfail($id);

        //dd($student->guardian->user->address);

        //pass all grades
        $grades =  Grade::all();

        //pass guardians to be assigned to students
        $guardians = \DB::table('guardians')
            ->join('users', 'users.id', '=', 'guardians.user_id')
            ->select('users.surname', 'users.first_name', 'guardians.id')
            ->where('users.type', '\App\Guardian')
            ->get();

        return view('students.edit', compact('student', 'grades', 'guardians'));
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
        // validation rules
        $rules = [
            'first_name' => 'bail|required|max:50|min:1|regex:/^[a-z ,.\'-]+$/i',
            'middle_name' => 'bail|nullable|max:50|regex:/^[a-z ,.\'-]+$/i',
            'surname' => 'bail|required|max:50|min:1|regex:/^[a-z ,.\'-]+$/i',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'bail|required|regex:/^[a-z ,.\'-]+$/i',
            'phone' => 'nullable',
            'county' => 'nullable',
            'country' => 'required|regex:/^[a-z ,.\'-]+$/i',
            'last_grade' => 'nullable',
            'last_school' => 'nullable',
            'religion' => 'nullable',
            'student_type' => 'required',
            'grade_id' => 'required|numeric',
            'guardian_id' => 'required||numeric'
        ];

        //validate and return errors
        $this->validate(request(), $rules);

        // find student
        $student = Student::findOrFail($id);

        //update student record
        $student->update(request([
            'first_name',
            'middle_name',
            'surname',
            'date_of_birth',
            'gender',
            'address',
            'phone',
            'county',
            'country',
            'religion',
            'student_type',
            'last_school',
            'last_grade',
            'grade_id',
            'guardian_id'
        ]));

        // send a message to the session that greets/ thank user
        session()->flash('message', $student->first_name." ".$student->surname);

        return redirect('/students');
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

        /**
         * if student is related to others entities
         * warn user to modify or delete records
         * related to the student to be deleted before deleting.
         */
        try {
            $student = Student::findOrFail($id);
            $student->delete();
            return response()->json ( array (
                'message' => "Student deleted!"
            ) );
        } catch (\Illuminate\Database\QueryException $e) {

            $error_code = $e->errorInfo[1];

            // Integrity constraint violation: 1451
            if($error_code  == 1451){
                return response()->json ( array (
                    'error' => "Student is reference in other tables. Please unlink the student from those tables and try again"
                ) );
            }
            
        }
    }
}
