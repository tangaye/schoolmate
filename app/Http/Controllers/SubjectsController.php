<?php

namespace App\Http\Controllers;

use App\Subject;

use App\Grade;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;



class SubjectsController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Subject $subject)
    {
        //
        $subjects = Subject::with('grade')->get();

        $grades = Grade::all();
        
        return view('subjects.home', compact('subjects', 'grades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // make validation
        $validator = Validator::make ( $request->all(), [
            'name' => 'bail|required|unique:subjects|max:50|min:5',
            'grade_id' => 'required'
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $subject = Subject::create(request(['name']));

            foreach (request(['grade_id']) as $grade){
                //assigned grade or grades to subject
                // this will insert records in the pivot table
                $subject->grade()->attach($grade);
            }

            return response ()->json ( $subject::where('id', $subject->id)->with('grade')->get(['id', 'name']));
            
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //-
        $subject = Subject::findOrFail($id);
        //find all grade assigned to the subject
        $subject_grades = $subject->grade()->pluck('grade_id');
        $grades =  Grade::all();


        return \View::make('partials.grade-assigned')->with(array(
            'grades'=>$grades, 
            'subject_grades'=>$subject_grades->toArray()
        ));
    }



    /**
     * Update the specified resource in storage.s
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        
        // make validation
        $validator = Validator::make ( $request->all(), [
            'name' => 'bail|required|max:20|unique:subjects,name,'.$id,
            'grade_id' => 'required'
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $subject = Subject::findOrFail($id);

            $subject->update(request(['name']));

            foreach (request(['grade_id']) as $grade){
                $subject->grade()->sync($grade);
            }

            return response ()->json ( 
                $subject::where('id', $subject->id)
                ->with('grade')
                ->get(['id', 'name'])
            );
            
        }
       
        
    }


    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        //

        /**
         * if subject is related to others entities
         * warn user to modify or delete records
         * related to the subject to be deleted before deleting.
         */
        try {
            $subject = Subject::findOrFail($id);
            $subject->grade()->detach();
            $subject->delete();

            return response()->json ( array (
                'message' => "Subject deleted!"
            ) );
        } catch (\Illuminate\Database\QueryException $e) {

            $error_code = $e->errorInfo[1];

            // Integrity constraint violation: 1451
            if($error_code  == 1451){
                return response()->json ( array (
                    'error' => "Subject is reference in other tables. Please unlink the subject from those tables and try again"
                ) );
            }
            
        }

    }
}
