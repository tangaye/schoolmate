<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Grade;



class ChartsController extends Controller
{
    
    public function genderChart()
    {
    	$gender_count = Student::students_gender_count();

    	return response ()->json ($gender_count);
    }

    public function gradesChart()
    {
    	$grades = Grade::grades_student_count();
    	return response ()->json ($grades);
    }
}
