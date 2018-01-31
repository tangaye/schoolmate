<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;


class RolesController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::all();
        return view('admin.roles.home', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permissions = Role::permissions();
        return view('admin.roles.create', compact('permissions'));
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
            'name' => 'required|min:2|unique:roles',
            'description' => 'required|min:10',
            'permissions' => 'required'
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->permissions = $request->permissions;
        $role->description = $request->description;
        $role->save();

        // send a message to the session that notify that the role was created
        session()->flash('message', $role->name);

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
        $role = Role::findOrFail($id);
        $permissions = Role::permissions();
        
        return view('admin.roles.edit', compact('role', 'permissions'));
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

        $this->validate($request, [
            'name' => 'required|min:2|unique:roles,name,'.$id,
            'description' => 'required|min:10',
            'permissions' => 'required'
        ]);

        $role = Role::findOrFail($id);

        $role->name = $request->name;
        $role->permissions = $request->permissions;
        $role->description = $request->description;
        $role->update();

        // send a message to the session that notify that the role was created
        session()->flash('message', $role->name);

        return redirect()->route('roles.home');

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
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response()->json ( array (
                'message' => "Role deleted!"
            ) );
        } catch (\Illuminate\Database\QueryException $e) {

            $error_code = $e->errorInfo[1];

            // Integrity constraint violation: 1451
            if($error_code  == 1451){
                return response()->json ( array (
                    'error' => "Please check if this role is assigned to a user. If so, please unassigned the role from the user and try again."
                ) );
            }
            
        }
    }
}
