<?php

namespace App\Http\Controllers;

use \App\Model\Major;
use \App\Model\Lecture;

class LectureController extends Controller
{
    public function index($major_id) {
        $major = Major::where('id', $major_id)->first();
        $school = $major->school;

        $lectures = Lecture::where('major_id', $major_id)
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('lecture/index', compact('major', 'school', 'lectures'));
    }

    public function show($lecture_id) {

        $lecture = Lecture::where('id', $lecture_id)->first();

        $major = Major::where('id', $lecture->major_id)->first();
        $school = $major->school;

        return view('lecture/show', compact('lecture', 'major', 'school'));
        }
}
