<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorsController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('preventBackHistory');
     
    }

    //this returns a view for unauthorized users
  	//or users with permision

  	public function unauthorized()
  	{
  		return view('errors.unauthorized');
  	}
}
