<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Division;
use Illuminate\Support\Facades\Validator;

class DivisionsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $divisions = Division::all();

        return view('admin.divisions.home', compact('divisions'));
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
            'name' => 'bail|required|unique:divisions|max:50|min:5'
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $division = Division::create(request(['name']));

            return response ()->json ($division);
            
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
            'name' => 'bail|required|max:20|unique:divisions,name,'.$id,
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $division = Division::findOrFail($id);

            $division->update(request(['name']));

            return response ()->json ( $division);
            
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
         * if division is related to others entities
         * warn user to modify or delete records
         * related to the division to be deleted before deleting.
         * Else detach subjects from divisions and then delete.
         */
        try {
            $division = Division::find($id);
            $division->delete();
            return response()->json ( array (
                'message' => 'Division deleted!'
            ) );
        } catch (\Illuminate\Database\QueryException $e) {

            $error_code = $e->errorInfo[1];

            // Integrity constraint violation: 1451
            if($error_code  == 1451){
                return response()->json ( array (
                    'error' => "Division is reference in other tables. Please unlink the division from those tables and try again"
                ) );
            }
            
        }

    }
}
