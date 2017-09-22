<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Teacher;
use App\Common;



class TeachersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin,web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $teachers = Teacher::all();
        return view('admin-teachers.home', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $genders = Common::genders();

        return view('admin-teachers.create', compact('genders'));

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
        $this->validate(request(),[
            'first_name' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
            'surname' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
            'gender' => 'required|string',
            'date_of_birth' => 'bail|required',
            'qualification' => 'required|string',
            'address' => 'required|string|max:255|regex:/^[a-z ,.\'-]+$/i',
            'phone' => 'required',
            'user_name' => 'required|string|unique:teachers|max:20',
            'email' => 'bail|required|email|unique:teachers',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $teacher = Teacher::create([
            'first_name' => request('first_name'),
            'surname' => request('surname'),
            'gender' => request('gender'),
            'date_of_birth' => request('date_of_birth'),
            'qualification' => request('qualification'),
            'address' => request('address'),
            'phone' => request('phone'),
            'user_name' => request('user_name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);

        // notify guardian was created
        session()->flash('message', $teacher->first_name." ".$teacher->surname);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $teacher = Teacher::findOrfail($id);
        $genders = Common::genders();

        return view('admin-teachers.edit', compact('teacher', 'genders'));
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
        $this->validate(request(),[
            'first_name' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
            'surname' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
            'gender' => 'required|string',
            'date_of_birth' => 'bail|required',
            'qualification' => 'required|string',
            'address' => 'required|string|max:255|regex:/^[a-z ,.\'-]+$/i',
            'phone' => 'required',
            'user_name' => 'required|string|max:30|unique:teachers,user_name,'.$id,
            'email' => 'bail|required|email|unique:teachers,email,'.$id
        ]);

        $teacher = Teacher::findOrfail($id);

        // update teacher/user
        $teacher->first_name = $request->first_name;
        $teacher->surname = $request->surname;
        $teacher->gender = $request->gender;
        $teacher->date_of_birth = $request->date_of_birth;
        $teacher->qualification = $request->qualification;
        $teacher->address = $request->address;
        $teacher->phone = $request->phone;
        $teacher->user_name = $request->user_name;
        $teacher->email = $request->email;

        // if password is being updated
        if ($request->has('password')) {

            $this->validate(request(),[
                'password' => 'required|string|min:6|confirmed'
            ]);

            $teacher->password = bcrypt($request->password);  
        }

        $teacher->update();

        // notify guardian has been updated
        session()->flash('message', $teacher->first_name." ".$teacher->surname);

        return redirect()->route('teachers.home');
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
    }
}
