<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentInformationController extends Controller
{
    public function studentInformation(){
        return view('CET.student_information.student-dashboard');
    }
}
