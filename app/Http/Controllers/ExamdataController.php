<?php

namespace App\Http\Controllers;


use App\Http\Constants\ResponseCode;
use App\Model\File;
use App\Model\FileComment;


class ExamdataController extends Controller
{

    public function index()
    {

        $forum_id = session('forum_id');
        if (empty($forum_id)) {
            return redirect('/search');
        }
        $filesZhenti = File::where('forum_id', $forum_id)->where('type', 0)
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'zhenti');

        $filesData = File::where('forum_id', $forum_id)->where('type', 1)
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'data');

        return view('examdata/index', compact('filesZhenti', 'filesData'));
    }

    function zhenti()
    {
        $forum_id = session('forum_id');
        if (empty($forum_id)) {
            return redirect('/search');
        }
        $files = File::where('forum_id', $forum_id)->where('type', 0)
            ->with(['user', 'filecomments', 'filecomments.user'])
            ->withCount(['filecomments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page');
        return view('examdata/zhenti', compact('files'));

    }

    function data()
    {
        $forum_id = session('forum_id');
        if (empty($forum_id)) {
            return redirect('/search');
        }
        //type 0 真题 1 资料
        $files = File::where('forum_id', $forum_id)->where('type', 1)
            ->with(['user', 'filecomments', 'filecomments.user'])
            ->withCount(['filecomments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page');
        return view('examdata/data', compact('files'));
    }

    function postComment() {
        if (!\Auth::check()) {
            return [
                'code' => ResponseCode::未登录,
                'msg' => '尚未登录'
            ];
        }

        $file_id = request('id');
        $content = request('content');
        $user_id = \Auth::id();
        $comment = new FileComment();
        $comment->user_id = $user_id;
        $comment->file_id = $file_id;
        $comment->content = $content;
        $comment->save();

        return [
            'code' => ResponseCode::成功,
            'msg' => 'success'
        ];

    }
}
