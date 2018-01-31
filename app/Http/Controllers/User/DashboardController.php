<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard for users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
    	$user = User::findOrFail(Auth::guard('web')->user()->id);
        return view('user.dashboard', compact('user'));
    }
}
