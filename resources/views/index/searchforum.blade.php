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
    <link rel="stylesheet" href="/bower_components/select2/dist/css/select2.min.css">

    <title>白猫考研-选择学校</title>

</head>
<body style="font-size: 12px;">
<div id="app">
    <div data-v-7d27be13="" class="main">
        <div style="text-align: center">
            <img src="/images/2018.jpg" style="width: 500px;margin-top:20px;"/>
        </div>
        <div data-v-7d27be13="" class="login_box">
            <img src="images/logo.png" class="login_logo">
            <h3>选择你要报考的学校专业</h3>
            {{--<h5>通过注册手机号取回密码</h5>--}}
            <div class="modal-footer major-tab">
                <select style="width: 90%" class="form-control select2" id="select-forum">
                    <option value="0">请选择</option>
                    @foreach($forums as $forum)
                        <option value="{{$forum->id}}" @if($forum->id == $targetForumId) selected @endif>
                            {{ $forum->name }}
                        </option>
                    @endforeach
                </select>
            </div>
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
        background-color: #E0EEEE;
        margin: 0;
        display: block;
    }

    .login_box {
        width: 380px;
        height: 240px;
        background: #fff;
        position: absolute;
        /*top: 50%;*/
        top: 500px;
        left: 50%;
        margin: -170px 0 0 -190px;
        border-radius: 5px;
        box-shadow: 2px 2px 5px rgba(0,0,0,.1);
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
<script src="/bower_components/select2/dist/js/select2.min.js"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $(document).ready(function () {
        $(".select2").select2({language: "zh-CN"});
        $('.select2').change(
            function () {
                var forumId = $('#select-forum').val();
                if (forumId > 0) {
                    switchForum(forumId);
                }
            });
    });
    function switchForum(id) {
        $.ajax({
            url: "/changeforum/" + id,
            method: "GET",
            success: function (response) {
                if (response.code != 200) {
                    console.log("存在一个问题，状态码为：" + response.code);
                    return;
                }
                // location.reload()
                window.location.href = "/index"
            },
            error: function (req, status, error) {
                console.log(error)
            }
        })

    }
</script>
</html>