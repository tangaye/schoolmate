<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Grade;
use App\Repositories\GradesRepository;
use App\Repositories\StudentsRepository;




class ChartsController extends Controller
{
    
    public function genderChart(StudentsRepository $student)
    {
    	$gender_count = $student->students_gender_count();
    	return response ()->json ($gender_count);
    }

    public function gradesChart(GradesRepository $grade)
    {
    	$grades = $grade->grades_student_count();
    	return response ()->json ($grades);
    }
}
