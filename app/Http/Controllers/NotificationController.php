<?php
/**
 * Created by PhpStorm.
 * User: ligen
 * Date: 2017/9/7
 * Time: 17:21
 */

namespace App\Http\Controllers;

use App\Http\Constants\NotificationType;
use App\Model\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class NotificationController extends Controller
{
    public function unreadNotif()
    {
        $user = \Auth::user();
        if ($user == null) {
            return [
                'code' => '401',
            ];
        }

        $notifications = Notification::whereRaw('user_id = ? and is_read = false', $user->id)
            ->where('counteruser_id', '<>', $user->id)
            ->with(['counteruser', 'shuoshuo', 'experience', 'question'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $finalText = '';
        if (count($notifications) == 0) {
            $finalText = '<div class="notif-empty">暂无提醒!</div>';
        }

        foreach ($notifications as $notification) {
            $type = $notification->type;
            switch ($type) {
                case NotificationType::回答问题:  // 回答问题
                    $finalText .= ('<div class="notification-item"><a target="_blank" href="/user/' . $notification->counteruser->id . '">' . $notification->counteruser->name . '</a>回答了')
                        . '<a href="/question/' . $notification->question_id . "?read_notification_id=" . $notification->id . '">' . getShareContent($notification->question->content) . '</a></div>';
                    break;
                case NotificationType::答案点赞: // 答案点赞
                    $finalText .= ('<div class="notification-item"><a target="_blank" href="/user/' . $notification->counteruser->id . '">' . $notification->counteruser->name . '</a>赞同了你在')
                        . '<a href="/question/' . $notification->question_id . "?read_notification_id=" . $notification->id . '">' . $notification->question->title . '</a> 下的回答</div>';
                    break;
                case NotificationType::说说评论: // 说说评论
                    $finalText .= ('<div class="notification-item"><a target="_blank" href="/user/' . $notification->counteruser->id . '">' . $notification->counteruser->name . '</a>评论了你的<a target="_blank" href="/user/' . $user->id . '/shuoshuo#shuoshuo_' . $notification->shuoshuo_id . '">说说</a>'). '</div>';
                    break;
                case NotificationType::说说点赞: // 说说点赞
                    $finalText .= ('<div class="notification-item"><a target="_blank" href="/user/' . $notification->counteruser->id . '">' . $notification->counteruser->name . '</a>点赞了你的<a target="_blank" href="/user/' . $user->id . '/shuoshuo#shuoshuo_' . $notification->shuoshuo_id . '">说说</a>'). '</div>';
                    \Log::info('final text:' . $finalText);
                    break;
                case NotificationType::文章点赞: // 文章点赞
                    $finalText .= ('<div class="notification-item"><a target="_blank" href="/user/' . $notification->counteruser->id . '">' . $notification->counteruser->name . '</a>赞同了你的文章')
                        . '<a href="/experience/' . $notification->experience_id . "?read_notification_id=" . $notification->id . '">' . $notification->experience->title . '</a></div>';
                    break;
                case NotificationType::文章评论: // 文章评论
                    $finalText .= ('<div class="notification-item"><a target="_blank" href="/user/' . $notification->counteruser->id . '">' . $notification->counteruser->name . '</a>评论了你的文章')
                        . '<a href="/experience/' . $notification->experience_id . "?read_notification_id=" . $notification->id . '">' . $notification->experience->title . '</a></div>';
                    break;
                case NotificationType::回复说说评论: // 回复说说评论
                    $finalText .= ('<div class="notification-item"><a target="_blank" href="/user/' . $notification->counteruser->id . '">' . $notification->counteruser->name . '</a>回复了你在说说') . '<a href="/shuoshuo/' . $notification->shuoshuo->id . "?read_notification_id=" . $notification->id . '">' . $notification->shuoshuo->content . '</a>中的评论</div>';
                    break;
                case NotificationType::关注板块提问:
                    $finalText .= ('<div class="notification-item"><a target="_blank" href="/user/' . $notification->counteruser->id . '">' . $notification->counteruser->name . '</a>提了一个问题 ')
                        . '<a href="/question/' . $notification->question_id . "?read_notification_id=" . $notification->id . '">' . $notification->question->content . '</a></div>';
                    break;
            }
        }
        // 点击后消息设置为已读
        $bool = DB::update('update notifications set is_read = true where user_id = ? ', [$user->id]);

        if ($notifications == null) {
            return [
                'code' => '301',
            ];
        } else {
//            $allNotifications = '<div style="width:100%;margin: 1rem 1rem 0 0;padding-right: 1rem;"><div style="float: right;">'
//                . '<a href="/clear_notifications?user_id=' . $user->id
//                . '" style="align:right;text-decoration: none;color: #666;">全部标记已读</a></div></div>';
//            $finalText .= $allNotifications;
            return [
                'code' => '200',
                'data' => $finalText,
//                 'read' => $bool
            ];
        }
    }

    public function notifications()
    {
    }

    public function clear(Request $request)
    {
        $userId = intval($request->input('user_id', 0));
        $rediretUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        if (!empty($userId)) {
            Notification::where('user_id', $userId)->where('is_read', 0)->update(['is_read' => 1]);
        }

        if (empty($rediretUrl)) {
            return redirect('/');
        } else {
            return redirect($rediretUrl);
        }
    }
}
