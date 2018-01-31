<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Guardian;
use App\User;
use App\Term;
use App\Score;
use App\Student;
use App\Semester;
use App\Common;


class GuardiansController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $guardians = Guardian::all();
        $user = User::findOrFail(Auth::guard('web')->user()->id);
        return view('user.guardians.home', compact('guardians', 'user'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $relationships = Guardian::relationships();
        $user = User::findOrFail(Auth::guard('web')->user()->id);
        return view('user.guardians.create', compact('relationships', 'user'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'first_name' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
            'surname' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
            'gender' => 'required|string',
            'relationship' => 'required|string',
            'address' => 'required|string|max:255',
            'phone' => 'required|unique:guardians',
            'user_name' => 'required|string|unique:guardians|max:20',
            'email' => 'sometimes|email|unique:guardians|nullable',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $guardian = Guardian::create([
            'first_name' => request('first_name'),
            'surname' => request('surname'),
            'gender' => request('gender'),
            'relationship' => request('relationship'),
            'address' => request('address'),
            'phone' => request('phone'),
            'user_name' => request('user_name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);

        // notify guardian was created
        session()->flash('message', $guardian->first_name." ".$guardian->surname);
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
        $guardian = Guardian::findOrfail($id);
        $genders = Common::genders();
        $relationships = Guardian::relationships();
        $user = User::findOrFail(Auth::guard('web')->user()->id);
        
        return view('user.guardians.edit', compact('guardian', 'genders', 'relationships', 'user'));

        
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

        $this->validate(request(), [
            'first_name' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
            'surname' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
            'gender' => 'required|string',
            'relationship' => 'required|string',
            'address' => 'required|string|max:255|',
            'phone' => 'required|unique:guardians,phone,'.$id,
            'user_name' => 'required|string|max:30|unique:guardians,user_name,'.$id,
            'email' => 'sometimes|nullable|email|unique:guardians,email,'.$id
        ]);

        $guardian = Guardian::findOrfail($id);

        // update guardian/user
        $guardian->first_name = $request->first_name;
        $guardian->surname = $request->surname;
        $guardian->gender = $request->gender;
        $guardian->relationship = $request->relationship;
        $guardian->address = $request->address;
        $guardian->phone = $request->phone;
        $guardian->user_name = $request->user_name;
        $guardian->email = $request->email;

        // if password is being updated
        if ($request->has('password')) {

            $this->validate(request(),[
                'password' => 'required|string|min:6|confirmed'
            ]);

            $guardian->password = bcrypt($request->password);  
        }

        $guardian->update();

        // notify guardian has been updated
        session()->flash('message', $guardian->first_name." ".$guardian->surname);

        return redirect('/users/guardians');
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find user to be deleted
        $guardian = Guardian::findOrFail($id);
        //delete user from user table
        $guardian->delete();

        return response()->json ( array (
            'message' => "Guardian deleted!"
        ) );
        
    }
}

