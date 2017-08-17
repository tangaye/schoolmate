<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Semester;

class SemestersController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $semesters = Semester::all();

        return view('semesters.home', compact('semesters'));
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
        // make validation
        $validator = Validator::make ( $request->all(), [
            'name' => 'bail|required|unique:semesters|max:30|min:5'
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $semester = Semester::create(request(['name']));

            return response()->json ( array (
                'name' => $semester->name,
                'id' => $semester->id,
            ) );
            
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
        //
        // make validation
        $validator = Validator::make ( $request->all(), [
            'name' => 'bail|required|max:20|unique:semesters,name,'.$id,
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $semester = Semester::findOrFail($id);

            $semester->update(request(['name']));

            return response()->json ( array (
                'name' => $semester->name,
                'id' => $semester->id,
            ) );
            
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
        //

        /**
         * if semester is related to others entities
         * warn user to modify or delete records
         * related to the semester to be deleted before deleting.
         */
        try {
            $semester = Semester::find($id);
            $semester->delete();
            return response()->json ( array (
                'message' => 'Semester deleted!'
            ) );
        } catch (\Illuminate\Database\QueryException $e) {

            $error_code = $e->errorInfo[1];

            // Integrity constraint violation: 1451
            if($error_code  == 1451){
                return response()->json ( array (
                    'error' => "Semester is reference in other tables. Please unlink the semester from those tables and try again"
                ) );
            }
            
        }
        
    }
}
