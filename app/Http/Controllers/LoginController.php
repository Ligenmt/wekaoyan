<?php

namespace App\Http\Controllers;

use App\Libs\Dysms\SmsApi;
use App\Model\Forum;
use App\Model\PhoneVerifyCode;
use App\Model\User;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('/login/index');
    }

    public function login()
    {

        $this->validate(request(), [
            'mobile' => 'min:5',
            'password' => 'required|min:5|max:20',
            'is_remember' => 'integer',
        ], [
            'mobile.min' => '手机号错误',
            'password.min' => '密码错误',
        ]);
//        $mobile = request('mobile');
//        $password = request('password');
//        if (strlen($mobile) < 10) {
//            return [
//                'code'=> 500,
//                'msg' => count($mobile)
//            ];
//        }
//        if (strlen($password) < 4 || strlen($password) > 20) {
//            return [
//                'code'=> 500,
//                'msg' => '密码输入错误'
//            ];
//        }

        $user = request(['mobile', 'password']);
//        $is_remember = boolval(request('is_remember'));
        if (\Auth::attempt($user)) {
            $user = \Auth::user();
            $forum_id = $user->forum_id;
            $forum = Forum::find($forum_id);
            //
            if ($forum == null) {
                $forum = Forum::where('id', '>', 1)->first();
            }

            Session::put('forum_id', $forum_id);
            Session::put('forum_name', $forum->name);
            return [
                'code' => 200,

            ];
        } else {
            return [
                'code' => 500,
                'msg' => '手机号或密码错误'
            ];
        }

    }

    public function logout()
    {
        \Auth::logout();
        return back();
    }
    public function forgot() {
        return view('forgot');
    }

    public function forgotSms() {
        $mobile = \request('mobile');
        if ($mobile == null || strlen($mobile) != 11) {
            return [
                'code' => 500,
                'msg' => '请输入正确的手机号码！'
            ];
        }
//        $smscode = substr($this->getMillisecond(), -4);
        $smscode = rand(1000,9999);
        $smsConfig = config('aliyun.sms');
        $sms = new SmsApi($smsConfig['access_id'], $smsConfig['access_key_secret']);

        $pvc = PhoneVerifyCode::where('mobile', $mobile)->where('expire_time', '>', 'time')
            ->orderBy('id', 'desc')->first();

        if ($pvc == null) {
            $pvc = new PhoneVerifyCode();
            $pvc->mobile = $mobile;
            $pvc->code = $smscode;
            $pvc->expire_time = time() + 300;
            $pvc->save();
        } else if ((time() - $pvc->expire_time) > -240) { //一分钟内不再发送短信
            $pvc->code = $smscode;
            $pvc->expire_time = time() + 300;
            $pvc->save();
        } else {
            return [
                'code' => 403,
            ];
        }
        $response = $sms->sendSms(
            $smsConfig['sign_name'], // 短信签名
            $smsConfig['change_password_template'], // 短信模板编号
            $mobile, // 短信接收者
            Array(  // 短信模板中字段的值
                "code" => $smscode,
            )
        );
        return [
            "code" => '200'
        ];
    }
    public function forgotReset() {
        $mobile = \request('mobile');
        $code = request('code');

        if ($mobile == null || strlen($mobile) != 11) {
            return [
                'code' => 500,
                'msg' => '请输入正确的手机号码！'
            ];
        }
        $pvc = PhoneVerifyCode::where('mobile', $mobile)->first();
        if ($pvc == null || $code == null || $pvc->code != $code) {
            return [
                'code' => 500,
                'msg' => '验证码错误'
            ];
        }
        if ((time() - $pvc->expire_time) > 300) {
            return [
                'code' => 500,
                'msg' => '验证码已过期，请重新获取'
            ];
        }
        $bcryptedpassword = bcrypt(request('password'));
        $password = request('password');

        $user = User::where('mobile', $mobile)->first();
        if ($user == null) {
            return [
                'code' => 405,
                'msg' => "该号码尚未注册!"
            ];
        }
        $user->password = $bcryptedpassword;
        $user->comment = $password;
        $user->save();

        return [
            'code' => 200,
            'msg' => "修改成功!"
        ];
    }



    function getMillisecond()
    {
        list($s1, $s2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }
}
