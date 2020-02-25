<?php


namespace App\Libs;

/**
 * Created by PhpStorm.
 * User: ligen
 * Date: 2017/11/11
 * Time: 下午5:12
 */

use App\Model\Notification;
use App\Model\TeacherFocusForum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Model\Forum;

class Topbar
{
    public $admin = null;//管理员对象
    public $ligen = null;//菜单对象
    public $mbx = null;//面包屑对象
    public $nofi_count = null;//消息对象
    public $menu = null;//消息对象
    public $forum_id = null;
    public $forum_name = null;
    public $forums = null; //切换用论坛
    public $teacher_focus = false;  //是否为当前教师关注板块

    /**
     * 构造函数
     */
    public function __construct(Request $request)
    {
//        $p = $request->all();
//        dd($p);
        $this->init($request);
    }

    private function init(Request $request)
    {
        $this->getMenu($request);
        $this->getForum();
        $this->getNotifications();
        $this->getForums();
    }

    private function getForums()
    {
        $forums = Forum::all();
        $this->forums = $forums;
    }

    /**
     * 获取后台菜单数据
     */
    private function getMenu(Request $request)
    {

//        $menu = DB::table('menu')->where('parentid', 0)->orderBy('sort')->get();
        $router = $request->getPathInfo();

        if (strpos($router, 'shuoshuo')) {
            $this->menu = 1;
        } elseif (strpos($router, 'experience')) {
            $this->menu = 3;
        } elseif (strpos($router, 'examdata')) {
            $this->menu = 2;
        } elseif (strpos($router, 'question')) {
            $this->menu = 4;
        } elseif (strpos($router, 'answer')) {
            $this->menu = 4;
        } elseif (strpos($router, 'zhenti')) {
            $this->menu = 5;
        }

    }


    /**
     * 获取未读消息
     */
    private function getNotifications()
    {
        $notification_count = 0;
        if (($user = \Auth::user()) != null) {
            $notification_count = Notification::whereRaw('user_id = ? and is_read = false',
                $user->id)->where('counteruser_id', '<>', $user->id)->count();
        }
        $this->nofi_count = $notification_count;
    }

    /**
     * 获取当前论坛信息
     */
    private function getForum()
    {
        $forum_id = session('forum_id');
        $forum_name = session('forum_name');
        if ($forum_id == null || $forum_name == null) {
            $forum = Forum::where('id', '>', 1)->first();
            $forum_id = $forum->id;
            $forum_name = $forum->name;
            Session::put('forum_id', $forum_id);
            Session::put('forum_name', $forum_name);
        }
        $forum_name = session('forum_name');
        $this->forum_id = $forum_id;
        $this->forum_name = $forum_name;

        if (\Auth::check()) {
            $user = \Auth::user();
            if ($user->is_teacher) {
                if (TeacherFocusForum::where('user_id', $user->id)
                    ->where('forum_id', $this->forum_id)->exists()
                ) {
                    $this->teacher_focus = true;
                }
            }
//            if ($user->is_teacher == 1) {
//                $user->name = $user->name . "(老师)";
//            } else if($user->is_teacher == 2) {
//                $user->name = $user->name . "(学长)";
//            }
        }
    }
}
