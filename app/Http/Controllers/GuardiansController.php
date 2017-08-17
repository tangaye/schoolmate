<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guardian;
use App\User;
use App\Term;
use App\Score;
use App\Student;
use App\Semester;


use Illuminate\Support\Facades\Auth;


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
        $guardians = User::where('type', '\App\Guardian')->get();
        //dd($guardians);

        //dd($guardians);
        return view('guardians.home', compact('guardians'));
    }

    /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function termForm(Request $request)
    {
        //
        $terms = Term::all();
        $guardians = \App\Guardian::with('student')->where('id', Auth::user()->data->id)->get();
        return view('guardians.student-term', compact('terms', 'guardians'));
    }

    /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function termResults(Request $request, Score $score)
    {
        //
        return $score->termReport($request->term_id, $request->student_id);
    }

    /**
     * Show the form to search for a specific.
     * student term(periodic) report
     *
     * @return \Illuminate\Http\Response
     */
    public function semesterForm(Request $request)
    {
        //
        $semesters = Semester::all();
        $guardians = \App\Guardian::with('student')->where('id', Auth::user()->data->id)->get();
        return view('guardians.student-semester', compact('semesters', 'guardians'));
    }


    /**
     * display a student semester report
     *
     * @return \Illuminate\Http\Response
     */
    public function semesterResults(Request $request, Score $score)
    {
        return $score->semesterReport($request->student_id, $request->semester_id);
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
        $user = User::findOrfail($id);

        //pass guardian with students assigned to he/she
        $guardians = \App\Guardian::with('student')->where('guardians.user_id', $user->id)->get();


        //dd($guardians);
        $relationships = User::relationships();
        $genders = User::genders();
        $educations = User::educations();

        $roles = User::roles();

        if ($user->type === '\App\Guardian') {
            return view('guardians.edit', compact('user', 'relationships', 'genders', 'educations','guardians'));
        } else {
            return view('users.edit', compact('user', 'roles', 'genders', 'educations'));
        }
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
        $user = User::findOrfail($id);

        if ($user->type === '\App\Guardian') {

            $this->validate(request(), [
                'first_name' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
                'surname' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
                'date_of_birth' => 'required',
                'gender' => 'required|string',
                'education' => 'required|string',
                'address' => 'required|string|max:255|regex:/^[a-z ,.\'-]+$/i',
                'country' => 'required|string|regex:/^[a-z ,.\'-]+$/i',
                'phone' => 'required',
                'user_name' => 'required|string|max:255|unique:users,user_name,'.$user->id,
                'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
                'relationship' => 'required|string'
            ]);
            // update guardian/user
            $user->update(request([
                'first_name',
                'surname',
                'date_of_birth',
                'gender',
                'education',
                'address',
                'country',
                'phone',
                'user_name',
                'email'
            ])); 

            // update user relationship if he/she is a guardian
            // a chooses to update their relationship.
            $user->data->update(request([
                'relationship'
            ])); 

            // if password is being updated
            if ($request->has('password')) {
                $this->validate(request(),[
                    'password' => 'required|string|min:6|confirmed'
                ]);

                $user->password = bcrypt($request->password);  
                $user->save();
            }

            // send a message to the session that greets/ thank user
            session()->flash('message', $user->first_name." ".$user->surname);

            return redirect('/guardians');
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


        
    }
}
