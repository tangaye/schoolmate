<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Grade;

class DashboardController extends Controller
{
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $grades = Grade::grades_student_count();
        //dd($grades);
        return view('admin.dashboard', compact('grades'));
    }
}
