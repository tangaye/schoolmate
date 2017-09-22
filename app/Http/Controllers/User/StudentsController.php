<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use App\Student;
use App\Grade;
use App\User;
use App\Guardian;
use Image;

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

        return view('user-students.home', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('user-students.create');
    
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
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500000',
            'guardian_id' => 'required|numeric'
        ];

        //validate and return errors
        $this->validate(request(), $rules);

        $student = new Student;

        $student->first_name = $request->first_name;
        $student->middle_name = $request->middle_name;
        $student->surname = $request->surname;
        $student->date_of_birth = $request->date_of_birth;
        $student->gender = $request->gender;
        $student->address = $request->address;
        $student->phone = $request->phone;
        $student->county = $request->county;
        $student->country = $request->country;
        $student->religion = $request->religion;
        $student->student_type = $request->student_type;
        $student->last_school = $request->last_school;
        $student->last_grade = $request->last_grade;
        $student->grade_id = $request->grade_id;
        $student->guardian_id = $request->guardian_id;

        // if student photo is being uploaded
        if ($request->hasFile('photo')) {

            $image = $request->file('photo');
            $ext = $image->guessExtension();
            $photoName = time().'.'.$ext;
            $location = public_path('images/' .$photoName);  
            Image::make($image)->resize(160, 160)->save($location);

            $student->photo = $photoName;
        } 
        //save the student
        $student->save();

        // get the student id and generate a unique code for the student
        $student->student_code = str_pad($student->id, 4, '0', STR_PAD_LEFT);
        // and then save again
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

        return view('user-students.edit', compact('student'));
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
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2000000',
            'guardian_id' => 'required||numeric'
        ];

        //validate and return errors
        $this->validate(request(), $rules);

        // find student
        $student = Student::findOrFail($id);

        $student->first_name = $request->first_name;
        $student->middle_name = $request->middle_name;
        $student->surname = $request->surname;
        $student->date_of_birth = $request->date_of_birth;
        $student->gender = $request->gender;
        $student->address = $request->address;
        $student->phone = $request->phone;
        $student->county = $request->county;
        $student->country = $request->country;
        $student->religion = $request->religion;
        $student->student_type = $request->student_type;
        $student->last_school = $request->last_school;
        $student->last_grade = $request->last_grade;
        $student->grade_id = $request->grade_id;
        $student->guardian_id = $request->guardian_id;

        // if student photo is being uploaded
        if ($request->hasFile('photo')) {

            $image = $request->file('photo');
            $ext = $image->guessExtension();
            $photoName = time().'.'.$ext;
            $location = public_path('images/' .$photoName);  
            Image::make($image)->resize(160, 160)->save($location);

            //get old student photo name from database
            $oldPhotoName = $student->photo;

            //assigned new photo name
            $student->photo = $photoName;

            //delete the old photo
            \Storage::delete($oldPhotoName);
        } 

        //update the student
        $student->update();


        // send a message to the session that greets/ thank user
        session()->flash('message', $student->first_name." ".$student->surname);

        return redirect('/users/students');
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
            //delete student photo
            \Storage::delete($student->photo);

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

