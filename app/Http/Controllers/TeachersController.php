<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


/**
 * This controller handles redirecting logged in teachers
 * to the home or teacher dashboard page.
 * In the future this controller should posses functions that 
 * allows one to create scores for student(s) he/she is teacher.  
 *
 * It should also in the future allow a teacher to view scores of 
 * grades/classes they are sponsor of.
 */
class TeachersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('preventBackHistory');
        $this->middleware('auth:teacher');
    }

    /**
     * Show the application dashboard for teachers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('teachers.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    
}
