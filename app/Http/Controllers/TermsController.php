<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Term;
use App\Semester;

class TermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $terms = Term::with('semester')->get();

        $semesters = Semester::all();
        
        return view('terms.home', compact('terms', 'semesters'));
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
        $validator = Validator::make ( $request->all(), [
            'name' => 'bail|required|unique:terms|max:30|min:5',
            'semester_id' => 'required'
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $term = Term::create(request(['name', 'semester_id']));

            return response ()->json ($term::where('id', $term->id)->with('semester')->get());
            
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
        //
        $term = Term::findOrfail($id);
        //find all divisions assigned to the subject
        $term_semester = $term->semester()->pluck('id');
        
        $semesters =  Semester::all();


        return \View::make('partials.semester-selected')->with(array('semesters'=>$semesters, 'term_semester'=>$term_semester->toArray()));
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
            'name' => 'bail|required|max:20|unique:terms,name,'.$id,
            'semester_id' => 'required'
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $term = Term::findOrFail($id);

            $term->update(request(['name', 'semester_id']));

            return response ()->json ($term::where('id', $term->id)->with('semester')->get());
            
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
         * if term is related to others entities
         * warn user to modify or delete records
         * related to the deleted to be deleted before deleting.
         */
        try {
            $term = Term::findOrFail($id);
            $term->delete();
            return response()->json ( array (
                'message' => "Term deleted!"
            ) );
        } catch (\Illuminate\Database\QueryException $e) {

            $error_code = $e->errorInfo[1];

            // Integrity constraint violation: 1451
            if($error_code  == 1451){
                return response()->json ( array (
                    'error' => "Term is reference in other tables. Please unlink the term from those tables and try again"
                ) );
            }
            
        }


    }
}
