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
        $academics = Academic::all();
        return view('academics.home', compact('academics'));

    }

    /**
     * This function takes date(date start year) and check 
     * whether is exists in the database
     * @return \Illuminate\Http\Response
     */
    public function findStartYear(Request $request, $date)
    {
        //
        if ($request->ajax()) {

            $recieveDate = Carbon::createFromDate($date);
            $startDates = Academic::all()->pluck('date_start');

            $found = false;
            $year = null;
            //dd($startDates);

            foreach ($startDates as $key => $value) {

                if ($value->year == $recieveDate->year) {
                    $found = true;
                    $year = $value->year;
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
     * This function takes date(date start year) and check 
     * whether is exists in the database
     * @return \Illuminate\Http\Response
     */
    public function findEditStartYear(Request $request, $id, $date)
    {
        //
        if ($request->ajax()) {

            $editDateStart = Academic::findOrFail($id);
            //dd($editDateStart);
            $recieveEditDate = Carbon::createFromDate($date);
            $startDates = Academic::all()->pluck('date_start');

            $found = false;
            $year = null;

            foreach ($startDates as $key => $value) {

                if ($value->year == $recieveEditDate->year && $value->year != $editDateStart->date_start->year){
                    $found = true;
                    $year = $value->year;
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
     * This function takes date(date end year) and check 
     * whether is exists in the database
     * @return \Illuminate\Http\Response
     */
    public function findEndYear(Request $request, $date)
    {
        //
        if ($request->ajax()) {

            $recieveDate = Carbon::createFromDate($date);
            $endDates = Academic::all()->pluck('date_end');

            $found = false;
            $year = null;

            foreach ($endDates as $key => $value) {
                if ($value->year == $recieveDate->year) {
                    $found = true;
                    $year = $value->year;
                    break;
                } 
            }

            if($found) {
                 return response()->json(['exists' => 'The year: <b>'.$year.'</b> of School Date End already exists']);
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
    public function findEditEndYear(Request $request, $id, $date)
    {
        //
        if ($request->ajax()) {

            $editDateEnd = Academic::findOrFail($id);
            //dd($editDateStart);
            $recieveEditDate = Carbon::createFromDate($date);
            $endDates = Academic::all()->pluck('date_end');

            $found = false;
            $year = null;

            foreach ($endDates as $key => $value) {

                if ($value->year == $recieveEditDate->year && $value->year != $editDateEnd->date_end->year){
                    $found = true;
                    $year = $value->year;
                    break; 
                }
            }

            if($found) {
                 return response()->json(['exists' => 'The year: <b>'.$year.'</b> of School Date End already exists']);
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
            'date_start' => 'bail|required|date|date_format:Y/m/d|after:yesterday|unique:academics',
            'date_end' => 'bail|required|date|date_format:Y/m/d|after:date_start|unique:academics',
            'status' => 'required|boolean'
        ];

        $this->validate(request(), $rules);

        $academic = Academic::create(request([
            'date_start',
            'date_end',
            'status'
        ]));

        // send a message to the session that greets/ thank user
        session()->flash('message', $academic->date_start->toFormattedDateString()." - ".$academic->date_end->toFormattedDateString());

        return redirect('/academics');

        //dd($request->all());
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
        $academic_status = Academic::findOrFail($id);
        $status_active = Academic::where('status', 1)->exists();
        $statuses = Academic::statuses();

        return \View::make('academics.partials.status-assigned')->with(array(
            'status' => $academic_status->status, // returns 1 or zero
            'status_active' => $status_active, // returns true if 1 and false if 0
            'statuses' => $statuses // returns a collection all statuses
        ));
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
        //dd(request());
        //
        $rules = [
            'date_start' => 'required|date|date_format:Y/m/d|after:yesterday|unique:academics,date_start,'.$id,
            'date_end' => 'required|date|date_format:Y/m/d|after:date_start|unique:academics,date_end,'.$id,
            'status' => 'required|boolean'
        ];

        // make validation
        $validator = Validator::make ( $request->all(), $rules);

        // if validation fails return error
        if ($validator->fails ()) {
            return response()->json ( array (
                        
             'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        }
        // if validation succeeds insert records
        else {

            $academic = Academic::findOrFail($id);

            $academic->update(request([
                'date_start',
                'date_end',
                'status'
            ]));

            return response ()->json (array(
                'id' => $academic->id,
                'date_start' => $academic->date_start->toFormattedDateString(),
                'format_start' => $academic->date_start->format('Y/m/d'),
                'date_end' => $academic->date_end->toFormattedDateString(),
                'format_end' => $academic->date_end->format('Y/m/d'),
                'status' => $academic->status
            ));     
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
         * if subject is related to others entities
         * warn user to modify or delete records
         * related to the subject to be deleted before deleting.
         */

        $academic = Academic::findOrFail($id);
        if ($academic->status) {
            return response()->json ( array (
                'error' => "This academic year is currently active."
            ) );
        }
        else {
            $academic->delete();
            return response()->json ( array (
                'message' => "Academic term deleted!"
            ) );
        }
    }
}
