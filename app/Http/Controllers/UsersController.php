<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        $users = User::where('type', 'admin')
        ->orWhere('type', 'registrar')
        ->orWhere('type', 'secretary')
        ->get();
        //dd($users);
        return view('users.home', compact('users'));
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
        $roles = User::roles();
        $genders = User::genders();
        $educations = User::educations();

        $relationships = User::relationships();

        // if someone attempts to passed an id to any of the user/guardians urls the 
        // right view should be returned

        if ($user->type !== '\App\Guardian'){
            return view('users.edit', compact('user', 'roles', 'genders', 'educations'));
        } else {
            return view('guardians.edit', compact('user', 'relationships', 'genders', 'educations'));
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

        // update user relationship if he/she is a guardian
        // a chooses to update their relationship.
        if ($user->type !== '\App\Guardian') {

            // update ordinary user
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
                'type' => 'required|string'
            ]);
            //dd($request->all());  
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
                'email',
                'type'
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

             return redirect('/users');
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
        //find user to be deleted
        $user = User::findOrFail($id);
        //delete user relation for guardian/teacher tables
        $user->data()->delete();
        //delete user from user table
        $user->delete();

        if ($user->type === '\App\Guardian') {
            return response()->json ( array (
                'message' => "Guardian deleted!"
            ) );

        } else {
            return response()->json ( array (
                'message' => "User deleted!"
            ) );

        }
    }
}
