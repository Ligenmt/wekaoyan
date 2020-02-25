<?php

namespace App\Http\Controllers;

use App\Model\TeacherFocusForum;
use App\Model\User;
use App\Model\Forum;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function show($userId) {

        $user = User::where('id', $userId)->first();
        if ($user == null) {
            return view('errors/404');
        }
        $shuoshuos = $user->shuoshuos()
            ->with(['user', 'shuoshuocomments', 'shuoshuoupvotes'])
            ->withCount(['shuoshuocomments', 'shuoshuoupvotes'])
            ->orderBy('created_at', 'desc')->take(10)->get();
        $experiences = $user->experiences()
            ->with(['user', 'experiencecomments', 'experienceupvotes'])
            ->withCount(['experiencecomments', 'experienceupvotes'])
            ->orderBy('created_at', 'desc')->take(10)->get();
        $questions = $user->questions()
            ->with(['user'])
            ->orderBy('created_at', 'desc')->take(10)->get();
        $answers = $user->answers()
            ->with(['user', 'question'])
            ->orderBy('created_at', 'desc')->take(10)->get();

        $files = $user->files()
            ->with(['user'])
            ->orderBy('created_at', 'desc')->take(10)->get();
        $forum = Forum::where('id', $user->forum_id)->first();
        $teacher_focus_forums = [];
        if ($user->is_teacher) {
            $teacher_focus_forums = TeacherFocusForum::where('user_id', $user->id)
                ->with(['forum'])->get();
        }
        return view('user/show', compact('user', 'shuoshuos', 'experiences', 'questions', 'answers', 'files', 'forum', 'teacher_focus_forums'));
    }


    public function basic($userId) {

        $user = User::where('id', $userId)
            ->withCount(['shuoshuos', 'experiences', 'questions', 'answers', 'files'])
            ->first();
        if ($user == null) {
            return view('errors/404');
        }

        return view('user/basic', compact('user'));
    }

    function shuoshuo($userId) {

        $user = User::where('id', $userId)
            ->withCount(['shuoshuos', 'experiences', 'questions', 'answers', 'files'])
            ->first();
        if ($user == null) {
            return view('errors/404');
        }
        $shuoshuos = $user->shuoshuos()
            ->with(['user', 'shuoshuocomments', 'shuoshuoupvotes'])
            ->withCount(['shuoshuocomments', 'shuoshuoupvotes'])
            ->orderBy('created_at', 'desc')->take(100)->get();
        return view('user/myshuoshuo', compact('user', 'shuoshuos'));
    }

    function experience($userId) {
        $user = User::where('id', $userId)
            ->withCount(['shuoshuos', 'experiences', 'questions', 'answers', 'files'])
            ->first();
        if ($user == null) {
            return view('errors/404');
        }
        $experiences = $user->experiences()
            ->with(['user', 'experiencecomments', 'experienceupvotes'])
            ->withCount(['experiencecomments', 'experienceupvotes'])
            ->orderBy('created_at', 'desc')->take(100)->get();
        return view('user/myexperience', compact('user', 'experiences'));
    }

    function file($userId) {
        $user = User::where('id', $userId)
            ->withCount(['shuoshuos', 'experiences', 'questions', 'answers', 'files'])
            ->first();
        if ($user == null) {
            return view('errors/404');
        }
        $files = $user->files()
            ->with(['user'])
            ->orderBy('created_at', 'desc')->take(100)->get();
        return view('user/myfile', compact('user', 'files'));
    }

    function question($userId) {
        $user = User::where('id', $userId)
            ->withCount(['shuoshuos', 'experiences', 'questions', 'answers', 'files'])
            ->first();
        if ($user == null) {
            return view('errors/404');
        }
        $questions = $user->questions()
            ->with(['user'])
            ->orderBy('created_at', 'desc')->take(100)->get();
        return view('user/myquestion', compact('user', 'questions'));
    }

    function answer($userId) {
        $user = User::where('id', $userId)
            ->withCount(['shuoshuos', 'experiences', 'questions', 'answers', 'files'])
            ->first();
        if ($user == null) {
            return view('errors/404');
        }
        $answers = $user->answers()
            ->with(['user', 'question'])
            ->orderBy('created_at', 'desc')->take(100)->get();
        return view('user/myanswer', compact('user', 'answers'));
    }

    function focusforum($userId) {

        $user = User::where('id', $userId)
            ->withCount(['shuoshuos', 'experiences', 'questions', 'answers', 'files'])
            ->first();
        if ($user == null) {
            return view('errors/404');
        }
        $teacher_focus_forums = [];
        if ($user->is_teacher) {
            $teacher_focus_forums = TeacherFocusForum::where('user_id', $user->id)
                ->with(['forum'])->get();
        }
        return view('user/myfocusforum', compact('user', 'teacher_focus_forums'));
    }
}
