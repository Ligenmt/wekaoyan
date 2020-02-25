{{--<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>--}}
{{--<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
{{--<script src="https://cdn.bootcss.com/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>--}}
<link href="/css/top.css" rel="stylesheet">
<link href="/css/custom.css" rel="stylesheet">

<div class="top">
    <div class="top-content">
        <div class="logo">
            <a href="/search">
                <img src="/images/logo.png">
            </a>
        </div>

        <div id="forum" class="forum" data-toggle="modal" data-target="#switch-modal">
            <span style="font-size:18px;font-weight:700;">{{ $forum_name }}</span><span
                    style="font-size:14px;color:#006eff;"> 点我切换</span>
        </div>
        @if(\Auth::check() && \Auth::user()->is_teacher)
            @if($teacher_focus)
                <div class="forum">
                    <a id="focusforum" href="javascript:;" onclick="focusForum('{{ $forum_id }}')">
                        取消关注此论坛</a>
                </div>
            @else
                <div class="forum">
                    <a id="focusforum" href="javascript:;" onclick="focusForum('{{ $forum_id }}')">
                        关注此论坛</a>
                </div>
            @endif

        @endif
        @if(\Auth::user())
            <div id="auth_user" value="1" style="display: none"></div>
            <div class="member">
                <div class="bell dropdown">
                    <div class="dropdown-toggle" data-toggle="dropdown" id="bell">
                        <img src="/images/bell_grey.png">
                        @if($nofi_count > 0)
                            <span class="notification-count">{{ $nofi_count }}</span>
                        @endif
                    </div>

                    <div id="notifications" class="dropdown-menu notification-list" role="menu"
                         style="font-size: small">
                        <div id="notification_content"></div>
                        @if($nofi_count > 0)
                            <div style="width:100%;margin: 1rem 1rem 0 0;padding-right: 1rem;">
                                <div style="float: right;">
                                    <a href="/clear_notifications?user_id={{ \Auth::user()->id }}"
                                       style="align:right;text-decoration: none;color: #666;">全部标记已读</a>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="avatar">
                    <a target="_blank" href="/user/{{ \Auth::user()->id }}">
                        <img src="{{ \Auth::user()->fullAvatarUrl }}" style="border-radius: 50%">
                        @if(\Auth::user()->is_teacher == 1)
                        <span title="老师" class="notification-vip">T</span>
                        @endif
                    </a>
                </div>
                <div class="username">
                    <a target="_blank" href="/user/{{ \Auth::user()->id }}">{{ \Auth::user()->name }}</a>
                </div>
                <div class="quit">
                    <a href="/logout">退出</a>
                </div>
            </div>
        @else
            <div id="auth_user" style="display: none"></div>
            <div class="anonymous">
                <p id="register" data-toggle="modal" data-target="#register-modal">注册</p>
                <p>·</p>
                <p id="login" data-toggle="modal" data-target="#login-modal">登录</p>
            </div>
        @endif
    </div>

    <!-- 注册Modal -->
    <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                    <h4 class="modal-title" id="registerModalLabel">
                        注册
                        {{--<p id="change-password" data-toggle="modal" data-target="#switch-modal">忘记密码?</p>--}}
                        {{--<a href="#" style="font-size: 14px;" data-target="#change-password-modal">忘记密码？</a>--}}
                    </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <input id="reg-mobile" type="text" name="mobile" class="form-control"
                                       placeholder="请输入您的手机号">
                            </div>
                            <div class="col-sm-2">
                                <button id="btn-smscode" type="button" class="btn btn-primary">
                                    验证
                                </button>
                            </div>
                        </div>
                        <div class="alert alert-danger alert-danger-sms" style="display: none; padding: 0;"></div>
                        <div class="form-group">
                            {{--<label for="name" class="control-label">姓名</label>--}}
                            <div class="col-sm-12">
                                <input id="reg-name" type="text" name="name" class="form-control" placeholder="请输入用户名">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input id="reg-password" type="password" name="password" class="form-control"
                                       placeholder="请输入密码">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input id="reg-smscode" type="text" name="smscode" class="form-control"
                                       placeholder="请输入短信验证码">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <label class="radio-inline">
                                    <input type="radio" name="teacher" id="is_student" value="0">我是学生
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="teacher" id="is_senior" value="2">我是学长
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="teacher" id="is_teacher" value="1">我是老师
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="alert alert-danger alert-danger-bottom" style="display: none"></div>
                <div class="alert alert-success" style="display: none"></div>
                <div class="modal-footer">
                    <button id="btn-register" type="button" class="btn btn-primary btn-lg">
                        注册
                    </button>
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">
                        取消
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- 登录Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                    <h4 class="modal-title" id="loginModalLabel">
                        登录
                    </h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label for="mobile" class="control-label">手机号</label>
                            <input id="login-mobile" type="text" name="mobile" class="form-control"
                                   placeholder="请输入手机号">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">密码</label>
                            <input id="login-password" type="password" name="psssword" class="form-control"
                                   placeholder="请输入密码">
                        </div>
                    </form>
                </div>
                <div class="alert alert-danger" style="display: none"></div>
                <div class="modal-footer">
                    <button id="btn-forgot" type="button" class="btn btn-default">
                        忘记密码
                    </button>
                    <div class="pull-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            取消
                        </button>
                        <button id="btn-login" type="button" class="btn btn-primary">
                            登录
                        </button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- 切换Modal -->
    <div class="modal fade" id="switch-modal" role="dialog" aria-labelledby="switchModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                    <h4 class="modal-title" id="switchModalLabel">
                        切换论坛
                    </h4>
                </div>
                <div class="modal-footer major-tab">

                    <select style="width: 100%" class="form-control select2" id="select-forum">
                        <option value="0">请选择</option>
                        @foreach($forums as $forum)
                            <option value="{{$forum->id}}" @if($forum_id == $forum->id) selected @endif>
                                {{--<a onclick="switchForum('{{$forum->id}}')"--}}
                                {{--href="javascript:;">{{ $forum->name }}</a>--}}
                                {{ $forum->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
<div class="fullscreen-shadow">
    <div class="loading-spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
</div>
</body>

<script src="/bower_components/select2/dist/js/select2.min.js"></script>
<script src="/js/top.js"></script>

<script>
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
</script>

