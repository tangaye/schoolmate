<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;


class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        $users = User::all();
        //dd($users);
        return view('users.home', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('name')->pluck('name', 'id');
        return view('users.create', compact('roles'));
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
            'name' => 'required|string|max:255|regex:/^[a-z ,.\'-]+$/i',
            'gender' => 'required|string|regex:/^[a-z ,.\'-]+$/i',
            'address' => 'required|string|regex:/^[a-z ,.\'-]+$/i',
            'phone' => 'required|string',
            'user_name' => 'required|string|unique:users|max:30',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required',
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = bcrypt($request->password);

        $user->save();

         // notify guardian was created
        session()->flash('message', $user->user_name);

        return redirect(route('users.home'));
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

        return view('users.edit', compact('user', 'roles', 'genders', 'educations'));
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

        $this->validate(request(), [
            'name' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
            'gender' => 'required|string',
            'address' => 'required|string|max:255|regex:/^[a-z ,.\'-]+$/i',
            'phone' => 'required|unique:users,phone,'.$user->id,
            'user_name' => 'required|string|max:30|unique:users,user_name,'.$user->user_name,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        // if password is being updated
        if ($request->has('password')) {
            $this->validate(request(),[
                'password' => 'required|string|min:6|confirmed'
            ]);

            $user->password = bcrypt($request->password);  

        }

        $user->save();

        // send a message to the session that greets/ thank user
        session()->flash('message', $user->user_name);

         return redirect('/users');
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
        //delete user from user table
        $user->delete();

        return response()->json ( array (
            'message' => "User deleted!"
        ) );

    }
}
