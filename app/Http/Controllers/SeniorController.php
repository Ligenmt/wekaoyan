<?php

namespace App\Http\Controllers;



class SeniorController extends Controller
{
    public function index($major_id) {
//        $major = Major::where('id', $major_id)->first();
//        $school = $major->school;
        return view('senior/index', compact('major', 'school'));
    }
}
