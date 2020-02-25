<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <title>白猫考研-忘记密码</title>

</head>
<body style="font-size: 12px;">
<div id="app">
    <div data-v-7d27be13="" class="main">
        <div data-v-7d27be13="" class="login_box">
            <img data-v-7d27be13="" src="images/logo.png" class="login_logo">
            <h3>忘记密码</h3>
            <h5>通过注册手机号取回密码</h5>
            <form id="sendsms_form" class="form-horizontal" role="form" onsubmit="return sendSms()">

                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <input type="text" class="form-control" id="input_mobile"
                               placeholder="请输入注册手机号">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <button id="btn-smscode" type="submit" class="btn btn-primary btn-block">提交</button>
                    </div>
                </div>
            </form>

            <form id="submit_form" class="form-horizontal" role="form" style="display: none">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-8">
                        <input type="text" class="form-control" id="input_code"
                               placeholder="短信验证码">
                    </div>

                    <div class="col-sm-2" style="padding: 0">
                        <button id="btn-smscode" type="button" class="btn btn-primary">
                            重发
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <input type="password" class="form-control" id="input_password"
                               placeholder="请输入6-16位密码，不能有空格">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <button type="button" class="btn btn-primary btn-block" onclick="sendReset()">提交</button>
                    </div>
                </div>
            </form>

            <form id="finish_form" class="form-horizontal" role="form" style="display: none" >
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-8">
                        设置密码完成，请重新登录
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>

<style>
    body {
        box-sizing: border-box;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background-color: #f5f5f5;
        margin: 0;
        display: block;
    }

    .login_box {
        width: 380px;
        height: 340px;
        background: #fff;
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -170px 0 0 -190px;
        border-radius: 10px;
        box-shadow: 2px 2px 15px;
    }

    .login_box h3 {
        max-width: 70%;
        margin: 5px 28px;
        display: block;
        vertical-align: middle;
        border: 0;
        height: auto;
    }

    .login_box h5 {
        max-width: 70%;
        margin: 5px 28px;
        margin-bottom: 20px;
        display: block;
        vertical-align: middle;
        border: 0;
        font-size: 12px;
        color: #b5b9bc;
        height: auto;
    }

    .login_box img {
        max-width: 70%;
        margin: 28px auto;
        display: block;
        vertical-align: middle;
        border: 0;
        height: auto;
    }
</style>
<script>

//    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
//    });

    function sendSms() {
        var mobile = $("#input_mobile").val();
        $.ajax({
            url: "/forgot/sms",
            method: "POST",
            data: {
                mobile: mobile
            },
            dataType: "json",
            success: function (res) {
                if (res.code != 200) {

                    return
                }
                $("#sendsms_form").css('display', 'none')
                $("#submit_form").css('display', 'block')
            },
            error: function (req, status, error) {
            }
        })
        return false
    }

    function sendReset() {
        console.log("reset")
        var mobile = $("#input_mobile").val()
        var code = $("#input_code").val()
        var password = $("#input_password").val()
        $.ajax({
            url: "/forgot/reset",
            method: "POST",
            data: {
                mobile: mobile,
                code: code,
                password: password
            },
            dataType: "json",
            success: function (res) {
                if (res.code != 200) {
                    console.log("遇到一个问题，code:" + res.code)
                    return
                }
                $("#submit_form").css('display', 'none')
                $("#finish_form").css('display', 'block')
            },
            error: function (req, status, error) {
            }
        })
    }
</script>
</html>