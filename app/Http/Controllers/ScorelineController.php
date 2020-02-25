<?php
/**
 * Created by PhpStorm.
 * User: ligen
 * Date: 2017/9/7
 * Time: 16:52
 */

namespace App\Http\Controllers;



class ScorelineController extends Controller
{
    public function index($major_id) {

//        $major = Major::where('id', $major_id)->first();
//        $school = $major->school;
        return view('scoreline/index', compact('major', 'school'));
    }
}