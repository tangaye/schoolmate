<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;
use Image;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $institution = Institution::find(1);
        if ($institution === null) {
            return view('admin.institution.create');  
        } elseif ($institution->exists()) {
            return view('admin.institution.edit', compact('institution'));
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
        // validation rules
        $rules = [
            'name' => 'bail|required|max:50|min:1|regex:/^[a-z ,.\'-]+$/i',
            'date_established' => 'required',
            'address' => 'bail|required|regex:/^[a-z ,.\'-]+$/i',
            'motto' => 'bail|required|regex:/^[a-z ,.\'-]+$/i',
            'email' => 'sometimes|email|nullable',
            'phone' => 'required',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500000'
        ];

        //validate and return errors
        $this->validate(request(), $rules);

        $institution = new Institution;

        $institution->name = $request->name;
        $institution->address = $request->address;
        $institution->date_established = $request->date_established;
        $institution->email = $request->email;
        $institution->phone = $request->phone;
        $institution->motto = $request->motto;

        // if school logo is being uploaded
        if ($request->hasFile('logo')) {

            $image = $request->file('logo');
            $ext = $image->guessExtension();
            $logoName = time().'.'.$ext;
            $location = public_path('logo/' .$logoName);  
            Image::make($image)->resize(160, 160)->save($location);

            $institution->logo = $logoName;
        } 
        //save the institution
        $institution->save();

        // send a message to the session that greets/ thank user
        session()->flash('message', $institution->name);

        return redirect('/institution');
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
        // validation rules
        $rules = [
            'name' => 'bail|required|max:50|min:1|regex:/^[a-z ,.\'-]+$/i',
            'date_established' => 'required',
            'address' => 'bail|required|regex:/^[a-z ,.\'-]+$/i',
            'motto' => 'bail|required|regex:/^[a-z ,.\'-]+$/i',
            'email' => 'sometimes|email|nullable',
            'phone' => 'required',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500000'
        ];

        //validate and return errors
        $this->validate(request(), $rules);

        $institution = Institution::findOrFail($id);;

        $institution->name = $request->name;
        $institution->address = $request->address;
        $institution->date_established = $request->date_established;
        $institution->email = $request->email;
        $institution->phone = $request->phone;
        $institution->motto = $request->motto;

        // if school logo is being uploaded
        if ($request->hasFile('logo')) {

            $image = $request->file('logo');
            $ext = $image->guessExtension();
            $logoName = time().'.'.$ext;
            $location = public_path('images/' .$logoName); 

            Image::make($image)->resize(160, 160)->save($location);

            //get old school logo name from database
            $oldLogoName = $institution->logo;

            //assigned new logo name
            $institution->logo = $logoName;

            //delete the old photo
            \Storage::delete($oldLogoName);
        } 
        //save the institution
        $institution->update();

        // send a message to the session that greets/ thank user
        session()->flash('message', $institution->name." Updated");

        return redirect('/institution');
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
    }
}
