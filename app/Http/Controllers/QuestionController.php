<?php

namespace App\Http\Controllers;


use App\Jobs\QuestionNotificationJob;
use \App\Model\Question;
use App\Model\QuestionFocusUser;



class QuestionController extends Controller
{
    public $menu = 4;

    public function index() {
//        $forum_id = session('forum_id');
        $questions = Question::where('id', '>', 0)
            ->with('user', 'forum')
            ->withCount(['answers'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('question/index', compact('questions'));
    }

    public function post() {

        $user = \Auth::user();
        if($user == null) {
            return view('unlogin');
        }

        return view('question/post');
    }

    public function doPost() {


        $user = \Auth::user();
        if ($user == null) {
            return view('unlogin', compact('forum'));
        }
        $forum_id = session('forum_id');

        $this->validate(request(), [
            'content' => 'required|string|min:3|max:300',
//            'title' => 'required'
        ], [
//            'title.required' => '需要问题标题',
            'content.required' => '需要问题描述',
            'content.min' => '问题最少需要3个字',
            'content.max' => '问题最多不能超过300个字',
        ]);
        $user_id = $user->id;
//        $title = request('title');
        $content = request('content');

        $question = new Question();
        $question->user_id = $user_id;
        $question->title = $content;
        $question->content = $content;
        $question->forum_id = $forum_id;
        $question->save();

        //提醒关注此板块的老师
        $job = new QuestionNotificationJob($forum_id, $user_id, $question->id);
        $this->dispatch($job);

        return redirect('question');
    }

    public function show($question_id) {

        $question = Question::where('id', $question_id)
            ->with(['user', 'answers', 'answers.user'])
            ->withCount(['answers'])
            ->first();
        $is_focus = false;
        $user = \Auth::user();
        if ($user != null) {
            $focususer = $question->focus($user->id);
            if ($focususer) $is_focus = true;
        }
//        dd($question);
        return view('question/show', compact('question', 'is_focus'));
    }

    public function focus(Question $question) {
        $user = \Auth::user();
        if ($user == null) {
            return view('unlogin', compact('forum'))->with("menu",  $this->menu);
        }
        if($question->focus($user->id)->exists()) {
            $question->focus($user->id)->delete();
            return [
                'code' => '200',
                'msg' => 'success',
                'focus' => false
            ];
        }
        $focus_user = new QuestionFocusUser();
        $focus_user->user_id = $user->id;
        $focus_user->question_id = $question->id;
        $focus_user->save();
        return [
            'code' => '200',
            'msg' => 'success',
            'focus' => true
        ];

    }
}
