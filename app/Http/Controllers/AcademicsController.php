<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Academic;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class AcademicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $academics = Academic::orderBy('year_start', 'asc')->get();
        return view('admin.academics.home', compact('academics'));

    }

    /**
     * This function takes the year start and check 
     * whether is exists in the database. If it does
     * A message is return stating so.
     * @return \Illuminate\Http\Response
     */
    public function findStartYear(Request $request, $year_start)
    {
        //
        if ($request->ajax()) {

            // get all the years from the year start column in the academics table
            $startYears = Academic::all()->pluck('year_start');

            $found = false;
            $year = null;

            /*
            * loop through the start year and check if the $year_start is 
            * equivalent to any of the start years. If so, assign such year to
            * the $year variable.
            */
            foreach ($startYears as $index => $year) {

                if ($year == $year_start) {
                    $found = true;
                    $year = $year_start;
                    break;
                } 
            }

            if($found) {
                 return response()->json(['exists' => 'The year: <b>'.$year.'</b> of School Year Start already exists']);
            } else {
                return response()->json(['none' => null]);
            }
        }

    }

    /**
     * This function takes date(date start year) and check 
     * whether is exists in the database
     * @return \Illuminate\Http\Response
     */
    public function findEditStartYear(Request $request, $id, $year_start)
    {
        //
        if ($request->ajax()) {

            $academic = Academic::findOrFail($id);
            $startYears = Academic::all()->pluck('year_start');

            $found = false;
            $year = null;

            foreach ($startYears as $index => $year) {

                if ($year == $year_start && $year != $academic->year_start){
                    $found = true;
                    $year = $year_start;
                    break; 
                }
            }

            if($found) {
                 return response()->json(['exists' => 'The year: <b>'.$year.'</b> of School Date Start already exists']);
            } else {
                return response()->json(['none' => null]);
            }
        }

    }

    /**
     * This function takes the year and check 
     * whether is exists in the database. If it does
     * A message is return stating so.
     * @return \Illuminate\Http\Response
     */
    public function findEndYear(Request $request, $year_start)
    {
        //
        if ($request->ajax()) {

            $endYears = Academic::all()->pluck('year_end');

            $found = false;
            $year = null;

            foreach ($endYears as $index => $year) {
                if ($year == $year_start) {
                    $found = true;
                    $year = $year_start;
                    break;
                } 
            }

            if($found) {
                 return response()->json(['exists' => 'The year: <b>'.$year.'</b> of School Year End already exists']);
            } else {
                return response()->json(['none' => null]);
            }
        }

    }

    /**
     * This function takes date(date start year) and check 
     * whether is exists in the database
     * @return \Illuminate\Http\Response
     */
    public function findEditEndYear(Request $request, $id, $year_end)
    {
        //
        if ($request->ajax()) {

            $academic = Academic::findOrFail($id);
            $endYears = Academic::all()->pluck('year_end');

            $found = false;
            $year = null;

            foreach ($endYears as $index => $year) {

                if ($year == $year_end && $year != $academic->year_end){
                    $found = true;
                    $year = $year_end;
                    break; 
                }
            }

            if($found) {
                 return response()->json(['exists' => 'The year: <b>'.$year.'</b> of School Year End already exists']);
            } else {
                return response()->json(['none' => null]);
            }
        }

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
        $rules = [
            'year_start' => 'bail|required|unique:academics',
            'year_end' => 'bail|required|unique:academics',
            'status' => 'required|boolean'
        ];

        $this->validate(request(), $rules);

        /*
        * If the status of the academic year being created is set to active or
        * "1" check if records exists in the academic table; if that is so,
        * set all the academic years status to "0" or "inactive". 
        * If there are no records in the academics table stored the academic year.
        *
        * If the status of the academic year being created is not set to "active"
        * or "1" create the academic year.
        */

        if ($request->status) {

            $academicExists = Academic::all()->count();

            if ($academicExists > 0) {
                
                //update the academic years that are currently active to inactive
                $activeAcademic = Academic::where('status', 1)
                    ->update(['status' => 0]);

                //set academic year being created to active
                $academic = Academic::create(request([
                    'year_start',
                    'year_end',
                    'status'
                ]));

            } else {

                $academic = Academic::create(request([
                    'year_start',
                    'year_end',
                    'status'
                ]));
            }
        } else {

            $academic = Academic::create(request([
                'year_start',
                'year_end',
                'status'
            ]));
        }

        // send a message to the session that greets/ thank user
        session()->flash('message', $academic->year_start." - ".$academic->year_end." save!");

        return redirect('/academics');
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
        $academic = Academic::findOrFail($id);
        $statuses = Academic::statuses();

        return view('admin.academics.edit', compact('academic', 'statuses'));

        /*return \View::make('admin.academics.partials.status-assigned')->with(array(
            'academic' => $academic,
            'statuses' => $statuses // returns a collection all statuses
        ));*/
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
        $rules = [
            'year_start' => 'required|unique:academics,year_start,'.$id,
            'year_end' => 'required|unique:academics,year_end,'.$id,
            'status' => 'required|boolean'
        ];

        //validate and return errors
        $this->validate(request(), $rules);

        $academic = Academic::findOrFail($id);  

        // if the user is updating the current academic year to inactive
        if ($academic->status && !$request->status) {

            return redirect()->back()->with('error_message', "Atleast one academic year should be active!");
        } 
        // if the user is updating an inactive academic year to active
        elseif (!$academic->status && $request->status) {
            
            /*
            * Set all other academic year to inactive and make this active
            */
            //update the academic years that are currently active to inactive
            $activeAcademic = Academic::where('status', 1)
                ->update(['status' => 0]);

            //set academic year being created to active
            $academic->update(request([
                'year_start',
                'year_end',
                'status'
            ]));

        } else {

            $academic->update(request([
                'year_start',
                'year_end',
                'status'
            ]));
        }
        // send a message to the session 
        session()->flash('message', $academic->year_start." - ".$academic->year_end." updated!");

        return redirect('/academics');
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
         * If academic year being deleted is active throw an error message.
         */
        

        try {
            $academic = Academic::findOrFail($id);
            if ($academic->status) {
                return response()->json ( array (
                    'error' => "This academic year cannot be deleted because it's currently active."
                ) );
            }
            else {
                $academic->delete();
                
                return response()->json ( array (
                    'message' => "Academic year deleted!"
                ) );
            }
        } catch (\Illuminate\Database\QueryException $e) {

            $error_code = $e->errorInfo[1];

            // Integrity constraint violation: 1451
            if($error_code  == 1451){
                return response()->json ( array (
                    'error' => "This academic year cannot be deleted because it's reference in other areas."
                ) );
            }
            
        }
    }
}
