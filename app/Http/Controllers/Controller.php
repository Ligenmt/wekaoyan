<?php

namespace App\Http\Controllers;

use App\Model\Notification;
use App\Model\UserOperateLog;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Knowledge\CLog;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $returnData;
    protected $user;
    protected $userId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->userId = Auth::id();
            return $next($request);
        });

        CLog::with('log')->addInfo('userId:' . $this->userId);

        $this->returnData = [
            'code' => 1,
            'msg' => '操作失败',
            'data' => new \stdClass(),
        ];

        $this->logRequest();
        // 标记通知已读
        $queryString = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
        if (!empty($queryString)) {
            $queryArray = explode('&', $queryString);
            foreach ($queryArray as $item) {
                if (strpos($item, 'read_notification_id=') !== false) {
                    $notificationId = ltrim($item, 'read_notification_id=');
                    if ($notificationId) {
                        Notification::where('id', $notificationId)->update(['is_read' => 1]);
                    }
                    break;
                }
            }
        }

    }

    /**
     * @comment 操作日志
     * @author zzp
     * @date 2017-12-03
     */
    protected function logRequest()
    {
//        TODO userId
        $route = request()->route();
        $data = [
            'user_id' => !empty($this->user) ? $this->user->id : 0,
            'ip' => getClientIp(),
            'uri' => $route->getCompiled()->getStaticPrefix(),
            'get_params' => json_encode($_GET),
            'post_params' => json_encode($_POST),
            'ua' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
        ];
        UserOperateLog::create($data);
    }

    /**
     * @comment 标记为 成功
     * @param $message
     * User: zzp
     * Date: 2017-11-25
     */
    protected function markSuccess($message = '操作成功')
    {
        $this->returnData['code'] = 200;
        $this->returnData['msg'] = $message;
    }

    /**
     * @comment 标记为 失败
     * @param $code
     * @param string $message
     * User: zzp
     * Date: 2017-11-25
     */
    protected function markFailed($code, $message = '')
    {
        $this->returnData['code'] = $code;
        if ($message) {
            $this->returnData['msg'] = $message;
        }
    }
}
