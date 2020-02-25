@include("layout.header")
<!-- Custom styles for this template -->
<link href="/css/common.css" rel="stylesheet">
<link href="/css/top.css" rel="stylesheet">
<link href="/css/userspace.css" rel="stylesheet">

<body>
<style>
    .main_container {
        background: white;
    }

</style>
@include("layout.top")

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main_container">
            <ul id="myTab" class="nav nav-tabs">
                <li class="active"><a href="/user/{{ $user->id }}/basic">基本资料</a></li>
                <li><a href="/user/{{ $user->id }}/shuoshuo">我的说说{{ $user->shuoshuos_count }}</a></li>
                <li><a href="/user/{{ $user->id }}/experience">我的文章{{ $user->experiences_count }}</a></li>
                <li><a href="/user/{{ $user->id }}/file">我的资料{{ $user->files_count }}</a></li>
                <li><a href="/user/{{ $user->id }}/question">我的提问{{ $user->questions_count }}</a></li>
                <li><a href="/user/{{ $user->id }}/answer">我的回答{{ $user->answers_count }}</a></li>
                @if($user->is_teacher)
                    <li><a href="/user/{{ $user->id }}/focusforum">我的板块</a></li>
                @endif
            </ul>
            <div id="myTabContent" class="content">
                <div class="" id="basic">
                    <div class="contact_box">
                        <div class="user_info">
                            <div class="user_avatar" title="修改头像" style="position: relative">
                                <img src="{{ $user->fullAvatarUrl }}" style="border-radius: 50%">
                                @if($user->is_teacher == 1)
                                    <span title="老师" class="notification-vip">T</span>
                                @endif
                                <div class="avatar_box" style="display:none;">
                                </div>
                            </div>

                            <div title="修改昵称" class="user_name contact_value" spellcheck="false">{{ $user->name }}</div>
                            <div class="change_ico">
                                @if(\Auth::check() && \Auth::id() == $user->id)
                                {{--<div class="modify">--}}
                                    {{--<a href="javascript:;" onclick="javascript:showsave(this);">修改</a>--}}
                                {{--</div>--}}
                                {{--<div class="modify_save" style="display:none;">--}}
                                    {{--<a href="javascript:;" onclick="javascript:changenickname(this);">保存</a>--}}
                                    {{--<a href="javascript:;" onclick="javascript:cancelchange(this,0,true);">取消</a>--}}
                                {{--</div>--}}
                                @endif
                            </div>
                        </div>
                        <div class="user_contact">
                            <div class="contact_item">
                                <div class="contact">手机号</div>
                                <div title="修改手机号(其他用户可见，修改不修改登录手机账号)" class="contact_value" spellcheck="false">{{ $user->mobile }}</div>
                            </div>
                            <div class="contact_item">
                                <div class="contact">邮箱</div>
                                <div title="修改邮箱" class="contact_value" spellcheck="false">{{ $user->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        if(location.hash) {
            $('a[href=' + location.hash + ']').tab('show');
        }
        $(document.body).on("click", "a[data-toggle]", function(event) {
            location.hash = this.getAttribute("href");
        });
    });
    $(window).on('popstate', function() {
        var anchor = location.hash || $("a[data-toggle=tab]").first().attr("href");
        $('a[href=' + anchor + ']').tab('show');
    });

    function showExperience(id) {
        self.location = ('/experience/' + id)
    }
    function showQuestion(id) {
        self.location = ('/question/' + id)
    }
    function showShuoshuo(index, id) {
       // window.open('/shuoshuo/' + id)
        var b = $(".comm_reply").eq(index).css('display')
        if (b == 'block') {
            $(".comm_reply").eq(index).css('display', 'none')
        } else {
            $(".comm_reply").eq(index).css('display', 'block')
        }
    }
    function toForum(id) {
        fetch("/changeforum/" + id, {
            method: 'GET',
            credentials: "include"
        }).then(function(response){
                if(response.status!==200){
                    console.log("存在一个问题，状态码为："+ response.status);
                    return;
                }
                //检查响应文本
            self.location = ('/shuoshuo')
            }
        ).catch(function (error) {
            console.log(error)
        })
    }

    function subItemOver(obj) {
        obj.getElementsByClassName("comm_opration")[0].style.display="block";
    }

    function subItemOut(obj) {
        obj.getElementsByClassName("comm_opration")[0].style.display="none";
    }

//    function showReplyBox(obj, postid){
//        $("#shuoshuo_"+postid).find(".comm_reply").toggle();
//    }

    function showReplyCommentBox(obj) {
        var d = obj.parentNode.parentNode.getElementsByClassName("comm_sub_reply_box")[0].style.display;
        if (d == "block")  {
            obj.parentNode.parentNode.getElementsByClassName("comm_sub_reply_box")[0].style.display = "none"
        } else {
            obj.parentNode.parentNode.getElementsByClassName("comm_sub_reply_box")[0].style.display = "block"
        }
    }

    function replySubHandler(obj, pid, id) {
        var content = obj.parentNode.parentNode.getElementsByTagName("textarea")[0].value
        if (content.length==0)
        {
            //TODO 为空提示
            return;
        }
        var data = {
            content: content,
            parent_id: pid
        }
        $.ajax({
            url: "/shuoshuo/postcomment/" + id,
            method: "POST",
            data: data,
            dataType: "json",
            success: function (result) {
                if (result.code != 200) {
                    alert(result.msg)
                    return
                }
                //TODO 暂时先刷新
                window.location.reload()
            }
        })
    }

    function replyHandler(obj, id) {
        var content = $(obj).parents(".comm_reply_box").find("textarea").val();
        if (content.length==0)
        {
            return;
        }
        var data = {
            content: content,
        }
        $.ajax({
            url: "/shuoshuo/postcomment/" + id,
            method: "POST",
            data: data,
            dataType: "json",
            success: function (result) {
                if (result.code != 200) {
                    alert(result.msg)
                    return
                }
                //TODO 暂时先刷新
                window.location.reload()
            }
        })

    }
</script>
</body>
</html>


