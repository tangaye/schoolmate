<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * This controller handles redirecting logged in users
 * to the home or user dashboard page
 * 
 */

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('preventBackHistory');
        $this->middleware('auth:web');
    }

   /**
     * Show the application dashboard for users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('users.home');
    }
}
