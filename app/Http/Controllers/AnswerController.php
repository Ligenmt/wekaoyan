<?php

namespace App\Http\Controllers;

use App\Http\Constants\NotificationType;
use \App\Model\Answer;
use App\Model\Notification;
use App\Model\Question;
use App\Model\AnswerUpvote;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{


    public function doPost() {

        $user = \Auth::user();
        if ($user == null) {
            return view('unlogin', compact('forum'));
        }

//        $this->validate(request(), [
//            'content' => 'required|string|min:3',
//            'title' => 'required'
//        ], [
//            'title.required' => '需要问题标题',
//            'content.required' => '需要问题描述',
//        ]);
        $user_id = $user->id;
        $question_id = request('question');
        $content = request('content');

        $answer = new Answer();
        $answer->user_id = $user_id;
        $answer->question_id = $question_id;
        $answer->content = $content;
        $answer_id = $answer->save();

        $bool=DB::update('update questions set count = count+1 where id = ? ', [$question_id]);

        //提醒提问者
        $question = Question::find($question_id);
        $notf = new Notification();
        $notf->user_id = $question->user_id;
        $notf->counteruser_id = $user_id;
        $notf->type = NotificationType::回答问题;
        $notf->question_id = $question_id;
        $notf->answer_id = $answer_id;
        $notf->is_read = false;
        $notf->save();

        return redirect('question/' . $question_id);
    }

    function upvote(Answer $answer) {

        $user = \Auth::user();
        if ($user == null) {
            return view('unlogin', compact('forum'));
        }
        $upvotes = $answer->upvotes;
        if($answer->upvote($user->id)->exists()) {
            $answer->upvote($user->id)->delete();
            $bool=DB::update('update answers set upvotes= ? where id= ? ',[$upvotes-1, $answer->id]);
            return [
                'code' => '200',
                'msg' => 'success',
                'upvote' => false,
                'count' => $upvotes - 1
            ];
        }
        $bool=DB::update('update answers set upvotes= ? where id= ? ',[$upvotes+1, $answer->id]);

        $upvote = new AnswerUpvote();
        $upvote->user_id = $user->id;
        $upvote->answer_id = $answer->id;
        $upvote->question_id = $answer->question_id;
        $upvote->save();

        //提醒答案点赞
        $notf = new Notification();
        $notf->user_id = $answer->user_id;
        $notf->counteruser_id = $user->id;
        $notf->type = NotificationType::答案点赞;
        $notf->question_id = $answer->question_id;
        $notf->answer_id = $answer->id;
        $notf->is_read = false;
        $notf->save();
        return [
            'code' => '200',
            'msg' => 'success',
            'upvote' => true,
            'count' => $answer->upvotes + 1
        ];
    }

}
