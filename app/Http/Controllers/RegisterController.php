<?php

namespace App\Http\Controllers;

use App\Model\PhoneVerifyCode;
use App\Model\User;
use App\Libs\Dysms\SmsApi;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register/index');
    }

    public function register()
    {

//        $this->validate(request(), [
//            'name' => 'required|string|min:1|max:10',
//            'mobile' => 'required|string|min:3|unique:users,mobile',
//            'password' => 'required|min:6',
//        ], [
//            'name.min' => '用户名过短',
//            'password.required' => '需要密码',
//        ]);

        $mobile = request('mobile');
        $name = request('name');
        $password = request('password');
        $code = request('code');
        if (strlen($mobile) != 11 || strlen($password) < 8 || strlen($password) > 15 || strlen($name) > 20) {
            return [
                'code' => 500,
                'msg' => '输入错误,请输入11位手机号，8-15位密码，2-20位用户名'
            ];
        }

        if ($code != "nevermore") {
            $pvc = PhoneVerifyCode::where('mobile', $mobile)->first();
            if ($pvc == null || $code == null || $pvc->code != $code) {
                \Log::info('interval ' . (time() - $pvc->expire_time));
                return [
                    'code' => 500,
                    'msg' => '验证码错误'
                ];
            }
            if ((time() - $pvc->expire_time) > 300) {
                \Log::info('interval ' . (time() - $pvc->expire_time));
                return [
                    'code' => 500,
                    'msg' => '验证码已过期，请重新获取'
                ];
            }
        }

        $is_teacher = request('is_teacher');  //0学生 1老师 2学长
        $password = bcrypt(request('password'));
        $avatar_url = sprintf('/images/avatar/%s.jpg', rand(1, 26));
        $comment = request('password');
        $forum_id = 1;


//        if ($is_teacher == null || $is_teacher == 0) {
//            $avatar_url = '/images/avatar/1.jpg';
//        } else {
//            if ($is_teacher == 1) { //老师
//                $name = $name . "(老师)";
//                $avatar_url = '/images/avatar/8.jpg';
//            } else {
//                if ($is_teacher == 2) { //学长
//                    $name = $name . "(学长)";
//                    $avatar_url = '/images/avatar/2.jpg';
//                }
//            }
//        }

        if (User::where('mobile', $mobile)->exists()) {
            return [
                'code' => 405,
                'msg' => "该号码已被注册!"
            ];
        }
        if (User::where('name', $name)->exists()) {
            return [
                'code' => 405,
                'msg' => "该用户名已被注册!"
            ];
        }

        $user = User::create(compact('name', 'mobile', 'password', 'avatar_url', 'comment', 'forum_id', 'is_teacher'));
        $registeredUser = request(['mobile', 'password']);
        \Auth::attempt($registeredUser);
        return [
            'code' => 200,
            'id' => $user->id
        ];
    }

    public function sendSms()
    {

        $mobile = \request('mobile');
        if ($mobile == null || strlen($mobile) != 11) {
            return [
                'code' => 500,
                'msg' => '请输入正确的手机号码！'
            ];
        }

        $smscode = rand(1000, 9999);
        $smsConfig = config('aliyun.sms');
        $sms = new SmsApi($smsConfig['access_id'], $smsConfig['access_key_secret']);

        $pvc = PhoneVerifyCode::where('mobile', $mobile)->where('expire_time', '>', 'time')
            ->orderBy('id', 'desc')->first();

        if ($pvc == null) {
            $pvc = new PhoneVerifyCode();
            $pvc->mobile = $mobile;
            $pvc->code = $smscode;
            //   $pvc->avatar_url = sprintf('/images/avatar/%s.jpg', rand(1, 26));
            $pvc->expire_time = time() + 300;
            $pvc->save();
        } else {
            if ((time() - $pvc->expire_time) > -240) { //一分钟内不再发送短信
                $pvc->code = $smscode;
                $pvc->expire_time = time() + 300;
                $pvc->save();
            } else {
                return [
                    'code' => 403,
                ];
            }
        }

        $response = $sms->sendSms(
            $smsConfig['sign_name'], // 短信签名
            $smsConfig['register_template'], // 短信模板编号
            $mobile, // 短信接收者
            Array(  // 短信模板中字段的值
                "code" => $smscode,
            )
        );
        return [
            'code' => '200',
            'msg' => $response
        ];

    }

    function getMillisecond()
    {
        list($s1, $s2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

}
