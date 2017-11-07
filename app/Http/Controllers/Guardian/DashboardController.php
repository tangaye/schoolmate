<?php

namespace App\Http\Controllers\Guardian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Guardian;

class DashboardController extends Controller
{
    //
    /**
     * Show the application dashboard for guardian.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // passes the logged in guardian details
        $guardian = Guardian::findOrFail(Auth::guard('guardian')->user()->id);
        // passes students related to the logged in guardian
        $guardians = Guardian::with('student')->where('id', Auth::guard('guardian')->user()->id)->get();

        return view('guardian.dashboard', compact('guardians', 'guardian'));
    }
}
