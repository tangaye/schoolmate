<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Division;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class GradesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Grade $grades)
    {
        //
        $grades = Grade::with('division')->get();
        $divisions = Division::all();

        return view('grades.home', compact('grades', 'divisions'));
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
            'name' => 'bail|required|unique:grades|max:50|min:5',
            'division_id' => 'required'
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $grade = Grade::create(request(['name', 'division_id']));

            return response ()->json ($grade::where('id', $grade->id)->with('division')->get());
            
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
        $grade = Grade::findOrfail($id);
        //find all divisions assigned to the subject
        $grade_divisions = $grade->division()->pluck('id');
        
        $divisions =  Division::all();


        return \View::make('grades.partials.grade-division')->with(array('divisions'=>$divisions, 'grade_divisions'=>$grade_divisions->toArray()));
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
            'name' => 'bail|required|max:20|unique:grades,name,'.$id,
            'division_id' => 'required'
        ] );
        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $grade = Grade::findOrFail($id);

            $grade->update(request(['name', 'division_id']));

            return response ()->json ($grade::where('id', $grade->id)->with('division')->get());
            
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
        try {
            $grade = Grade::findOrFail($id);
            $grade->delete();
            return response()->json ( array (
                'message' => "Grade deleted!"
            ) );
        } catch (\Illuminate\Database\QueryException $e) {

            $error_code = $e->errorInfo[1];

            // Integrity constraint violation: 1451
            if($error_code  == 1451){
                return response()->json ( array (
                    'error' => "Grade/Class is reference in other tables. Please unlink the grade from those tables and try again"
                ) );
            }
            
        }
    }

    public function gradeSubjects($id)
    {
        $grade = Grade::findOrfail($id);

        $subjects = $grade->subjects->pluck('name', 'id');

        return response()->json($subjects);
    }
}
