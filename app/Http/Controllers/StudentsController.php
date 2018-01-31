<?php

namespace App\Http\Controllers;

use App\Student;
use App\Grade;
use App\User;
use App\Guardian;
use App\Academic;
use App\Enrollment;

use Image;

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
        $students = Student::all();

       return view('admin.students.home', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.students.create');
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
            'address' => 'required',
            'phone' => 'nullable',
            'county' => 'nullable',
            'country' => 'required|regex:/^[a-z ,.\'-]+$/i',
            'last_school' => 'nullable',
            'last_school_address' => 'nullable',
            'principal_name' => 'nullable',
            'principal_number' => 'nullable',
            'religion' => 'nullable',
            'father_name' => 'bail|required|max:255|min:1|regex:/^[a-z ,.\'-]+$/i',
            'father_address' => 'required',
            'father_number' => 'required',
            'mother_name' => 'bail|required|max:255|min:1|regex:/^[a-z ,.\'-]+$/i',
            'mother_address' => 'required',
            'mother_number' => 'required',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500000',
            'guardian_id' => 'required',
            'admission_date' => 'required'
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
        $student->last_school = $request->last_school;
        $student->last_school_address = $request->last_school_address;
        $student->principal_name = $request->principal_name;
        $student->principal_number = $request->principal_number;
        $student->father_name = $request->father_name;
        $student->father_address = $request->father_address;
        $student->father_number = $request->father_number;
        $student->mother_name = $request->mother_name;
        $student->mother_address = $request->mother_address;
        $student->mother_number = $request->mother_number;
        $student->guardian_id = $request->guardian_id;
        $student->admission_date = $request->admission_date;

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
        
        $academic = new Academic();
        $current_academic = $academic->current();

        return view('admin.students.edit', compact('student', 'current_academic'));
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
            'address' => 'bail|required',
            'phone' => 'nullable',
            'county' => 'nullable',
            'country' => 'required|regex:/^[a-z ,.\'-]+$/i',
            'last_school' => 'nullable',
            'last_school_address' => 'nullable',
            'principal_name' => 'nullable',
            'principal_number' => 'nullable',
            'religion' => 'nullable',
            'father_name' => 'bail|required|max:255|min:1|regex:/^[a-z ,.\'-]+$/i',
            'father_address' => 'required',
            'father_number' => 'required',
            'mother_name' => 'bail|required|max:255|min:1|regex:/^[a-z ,.\'-]+$/i',
            'mother_address' => 'required',
            'mother_number' => 'required',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2000000',
            'guardian_id' => 'required',
            'admission_date' => 'required'

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
        $student->last_school = $request->last_school;
        $student->last_school_address = $request->last_school_address;
        $student->principal_name = $request->principal_name;
        $student->principal_number = $request->principal_number;
        $student->father_name = $request->father_name;
        $student->father_address = $request->father_address;
        $student->father_number = $request->father_number;
        $student->mother_name = $request->mother_name;
        $student->mother_address = $request->mother_address;
        $student->mother_number = $request->mother_number;
        $student->guardian_id = $request->guardian_id;
        $student->admission_date = $request->admission_date;


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


        // send a message to the session 
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
