<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('preventBackHistory');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // if user is admin, secretary or registrar
        if (!Auth::user()->hasType('\App\Guardian')) {
            return view('admin-dashboard');   
        }
        // else if the user is guardian 
        elseif (Auth::user()->hasType('\App\Guardian')){
            return view('guardian-dashboard');
        }
    }
}
