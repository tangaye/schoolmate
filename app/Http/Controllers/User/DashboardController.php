<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard for users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('user.dashboard');
    }
}
