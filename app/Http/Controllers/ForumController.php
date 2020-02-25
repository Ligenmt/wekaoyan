<?php
/**
 * Created by PhpStorm.
 * User: ligen
 * Date: 2017/9/4
 * Time: 14:50
 */

namespace App\Http\Controllers;

use App\Http\Constants\ResponseCode;
use \App\Model\Forum;
use App\Model\TeacherFocusForum;
use \App\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ForumController extends Controller
{
    public function forums()
    {
        $forums = Forum::all();
        return [
            "code" => 200,
            "forums" => $forums
        ];
    }

    public function changeForumPost()
    {
        $forum_id = request('id');
        $forum = Forum::find($forum_id);
        Session::put('forum_id', $forum_id);
        Session::put('forum_name', $forum->name);
        return [
            "code" => 200,
            "msg" => "success"
        ];
    }

    public function changeForumGet($forum_id)
    {
        $forum = Forum::find($forum_id);
        Session::put('forum_id', $forum_id);
        Session::put('forum_name', $forum->name);
        $user = \Auth::user();
        if ($user != null) {
            User::where('id', $user->id)
                ->update(['forum_id' => $forum_id]);
        }

        return [
            "code" => 200,
            "msg" => "success"
        ];
    }

    public function forum($sname)
    {
        $name = urldecode($sname);
        $forum = Forum::where('name', $name)->first();
        if ($forum == null) {
            return [
                "code" => 301,
                "msg" => "wrong params"
            ];
        }
        $user = \Auth::user();
        if ($user) {
            $bool = DB::update('update users set forum_id= ? where id= ? ', [$forum->id, $user->id]);
        }
        return [
            "code" => 200,
            "forum" => $forum
        ];
    }

    public function focusforum($forum_id)
    {
        $user = \Auth::user();
        if ($user == null) {
            return [
                'code' => ResponseCode::未登录
            ];
        }
        if ($user->is_teacher == false) {
            return [
                'code' => ResponseCode::无此权限
            ];
        }
        $forum = Forum::find($forum_id);
        if ($forum == null) {
            return [
                'code' => '404',
                'msg' => '操作错误，无效的论坛'
            ];
        }

        if (TeacherFocusForum::where('user_id', $user->id)->where('forum_id', $forum_id)->exists()) {
            TeacherFocusForum::where('user_id', $user->id)->where('forum_id', $forum_id)->delete();
            return [
                'code' => ResponseCode::成功,
                'focus' => false,
                'msg' => '取消关注!'
            ];
        }
        $tff = new TeacherFocusForum();
        $tff->user_id = $user->id;
        $tff->forum_id = $forum_id;
        $tff->save();
        return [
            'code' => ResponseCode::成功,
            'focus' => true,
            'msg' => '关注成功!'
        ];
    }

    public function allfocusforum()
    {
        $user = \Auth::user();
        if ($user == null) {
            return [
                'code' => ResponseCode::未登录
            ];
        }
        if ($user->is_teacher == false) {
            return [
                'code' => ResponseCode::无此权限
            ];
        }
        $tffs = TeacherFocusForum::where('user_id', $user->id)
            ->with(['forum'])
            ->get();
        $finalText = '';
        foreach ($tffs as $tff) {
            $finalText .= '<div class="checkbox">
                                <label><input type="checkbox" name="focuses[]" value="' . $tff->forum_id . '">' . $tff->forum->name . '</label>
                            </div>';
        }


        return [
            'code' => ResponseCode::成功,
            'tffs' => $finalText
        ];
    }
}
