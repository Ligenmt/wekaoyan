<?php

namespace App\Http\Controllers;

use App\Http\Constants\NotificationType;
use App\Http\Constants\ResponseCode;
use \App\Model\Notification;
use \App\Model\Shuoshuo;
use \App\Model\ShuoshuoComment;
use \App\Model\ShuoshuoUpvote;
use Illuminate\Http\Request;

class ShuoshuoController extends Controller
{
    public $menu = 1;
    public function index() {

        $forum_id = session('forum_id');
        $shuoshuos = Shuoshuo::where('forum_id', $forum_id)
            ->with(['user', 'shuoshuocomments', 'shuoshuocomments.user', 'shuoshuocomments.parent', 'shuoshuocomments.parent.user', 'shuoshuoupvotes', 'shuoshuoupvotes.user'])
            ->withCount(['shuoshuocomments', 'shuoshuoupvotes'])
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('shuoshuo/index', compact('shuoshuos'));
    }

    public function post(Request $request) {

        $user = \Auth::user();
        if ($user == null) {
            return view('unlogin');
        }

        return view('shuoshuo/post');
    }

    public function doPost() {

        $user = \Auth::user();
        if ($user == null) {
            return view('unlogin');
        }

        $this->validate(request(), [
            'content' => 'required|string|min:3'
        ], [
            'content.min' => '文章内容过短',
        ]);
        $content = request('content');
        $user_id = \Auth::id();

        if ($user->is_teacher && request('focuses') != null) {
            $focuses = request('focuses');

            foreach ($focuses as $forum_id) {
                $shuoshuo = new Shuoshuo();
                $shuoshuo->user_id = $user_id;
                $shuoshuo->content = $content;
                $shuoshuo->forum_id = $forum_id;
                $shuoshuo->save();
            }

        } else {
            $shuoshuo = new Shuoshuo();
            $shuoshuo->user_id = $user_id;
            $shuoshuo->content = $content;
            $shuoshuo->forum_id = session('forum_id');
            $shuoshuo->save();
        }
//        $shuoshuos = Shuoshuo::where('forum_id', session('forum_id'))->orderBy('created_at', 'desc')->paginate(10);
        return redirect('shuoshuo');
    }

    public function postComment($shuoshuo_id) {

        $user = \Auth::user();
        if ($user == null) {
//            return view('unlogin');
            return [
              'code' => ResponseCode::未登录,
              'msg' => '您尚未登录'
            ];

        }

        $content = request('content');
        $parent_id = request('parent_id');
        $user_id = $user->id;

        $comment = new ShuoshuoComment();
        $comment->user_id = $user_id;
        $comment->content = $content;
        if ($parent_id != null) {
            $comment->parent_id = $parent_id;
        }

        $comment->shuoshuo_id = $shuoshuo_id;
        $comment->save();

        //提醒说说评论
        $notf = new Notification();
        $notf->user_id = Shuoshuo::find($shuoshuo_id)->user->id;  //被提醒的人
        $notf->counteruser_id = $user->id;  //触发提醒的人
        $notf->type = NotificationType::说说评论;
        $notf->shuoshuo_id = $shuoshuo_id;
        $notf->is_read = false;
        $notf->save();
        //提醒说说回复评论
        if ($parent_id != null) {
            $parentComment = ShuoshuoComment::find($parent_id);
            $notf2 = new Notification();
            $notf2->user_id = $parentComment->user_id;
            $notf2->counteruser_id = $user->id;
            $notf2->type = NotificationType::回复说说评论;
            $notf2->shuoshuo_id = $shuoshuo_id;
            $notf2->is_read = false;
            $notf2->save();
        }

        return [
            'code' => '200',
            'msg' => 'success'
        ];

    }

    public function postUpvote(Shuoshuo $shuoshuo) {

        $user = \Auth::user();
        if ($user == null) {
            return view('unlogin', compact('forum'))->with("menu",  $this->menu);
        }

        $user_id = \Auth::id();
        if($shuoshuo->upvote(\Auth::id())->exists()) {
            $shuoshuo->upvote(\Auth::id())->delete();
            return [
                'code' => '200',
                'msg' => 'success',
                'upvote' => false
            ];
        }
        $upvote = new ShuoshuoUpvote();
        $upvote->user_id = $user_id;
        $upvote->shuoshuo_id = $shuoshuo->id;
        $upvote->save();
        //提醒点赞
        $notf = new Notification();
        $notf->user_id = $shuoshuo->user->id;
        $notf->counteruser_id = $user->id;
        $notf->type = NotificationType::说说点赞;
        $notf->shuoshuo_id = $shuoshuo->id;
        $notf->is_read = false;
        $notf->save();

        return [
            'code' => '200',
            'msg' => 'success',
            'upvote' => true
        ];
    }

}
