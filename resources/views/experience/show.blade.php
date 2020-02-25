@include("layout.header")
<!-- Custom styles for this template -->
<link href="/css/common.css" rel="stylesheet">
<link href="/css/top.css" rel="stylesheet">
<link href="/css/experience.css" rel="stylesheet">
<body>
<style>
    .nav-kaoyan {
        font-size: 17px;

    }

    .main_container {
        background: white;
    }

</style>
@include("layout.top")

<div class="container">
    <div class="row">
        @include("layout.sidebar")

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main_container">
            <div class="content">
                <div class="content_head">
                    <a href="/experience">返回列表</a>
                </div>
                <div class="content_body">
                    <div class="content_title">{{ $experience->title }}</div>
                    <div class="content_info">
                        <div class="content_user">
                            <div class="user_avatar" style="position: relative">
                                <a href="/user/{{$experience->user->id}}">
                                    <img src="{{$experience->user->fullAvatarUrl}}" style="border-radius: 50%">
                                </a>
                                @if($experience->user->is_teacher == 1)
                                    <span title="老师" class="notification-vip">T</span>
                                @endif
                            </div>
                            <div class="user_name"><a
                                        href="/user/{{$experience->user->id}}">{{ $experience->user->name }}</a></div>
                            <div class="update_time">{{ $experience->updated_at }}</div>
                        </div>
                        <div class="readnum">阅读数：{{ $experience->count }}</div>
                    </div>

                    <div class="content_article">{!! $experienceContent->content !!}</div>
                    {{--<div class="content_article">{{ $experienceContent->content }}</div>--}}
                    <div class="opration">
                        <div class="opration_comment">
                            <div class="opration_reply">
                                <div class="opration_reply_ico"><img src="/images/reply.png"></div>
                                <div class="opration_reply_des">评论</div>
                                <div class="opration_reply_num">{{ $experience->experiencecomments_count }}</div>
                            </div>
                            <div style="cursor:pointer;" onclick="praiseHandler(this, '{{ $experience->id }}');"
                                 class="opration_praise">
                                <div class="opration_praise_ico"><img src="/images/praise.png"></div>
                                <div class="opration_praise_des">点赞</div>
                                <div class="opration_praise_num">{{ $experience->experienceupvotes_count }}</div>
                            </div>
                        </div>
                        {{--<div class="opration_share">--}}
                        {{--<div class="shareto">分享到：</div>--}}
                        {{--<div class="shareitem">--}}
                        {{--<div class="shareico">--}}
                        {{--<!--<img src="https://47.92.90.134/images/sharewx.png">-->--}}
                        {{--<!-- JiaThis Button BEGIN -->--}}
                        {{--<div class="jiathis_style">--}}
                        {{--<a class="jiathis_button_weixin"></a>--}}
                        {{--</div>--}}
                        {{--<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=2139573" charset="utf-8"></script>--}}
                        {{--<!-- JiaThis Button END -->--}}
                        {{--</div>--}}
                        {{--<div class="sharewords">朋友圈</div>--}}
                        {{--</div>--}}
                        {{--<div class="shareitem">--}}
                        {{--<div class="shareico">--}}
                        {{--<!--<img src="https://47.92.90.134/images/sharewb.png">-->--}}
                        {{--<!-- JiaThis Button BEGIN -->--}}
                        {{--<div class="jiathis_style">--}}
                        {{--<a class="jiathis_button_tsina"></a>--}}
                        {{--</div>--}}
                        {{--<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=2139573" charset="utf-8"></script>--}}
                        {{--<!-- JiaThis Button END -->--}}
                        {{--</div>--}}
                        {{--<div class="sharewords">微博</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="comm_reply">
                    <ul>
                        @foreach($experience->experiencecomments as $comment)
                            <li class="chosed">
                                <div class="comm_reply_part" onmousemove="subItemOver(this)"
                                     onmouseout="subItemOut(this)">
                                    <div class="comm_reply_head">
                                        <div class="comm_user_avatar">
                                            <img src="{{ $comment->user->fullAvatarUrl }}" style="border-radius: 50%">
                                        </div>
                                        <div class="comm_user_name">
                                            <a href="/user/{{$comment->user->id}}">{{ $comment->user->name }}</a>
                                            @if($comment->parent_id)
                                                回复
                                                <a href="/user/{{$comment->parent->user->id}}">{{ $comment->parent->user->name }}</a>
                                            @endif
                                        </div>
                                        <div class="comm_reply_time">{{ $comment->updated_at }}</div>
                                    </div>
                                    <div class="comm_reply_body">
                                        <div class="comm_reply_content">{{ $comment->content }}</div>
                                        <div class="comm_opration"
                                             onclick="showReplyCommentBox(this, '{{ $comment->id }}')"
                                             style="display: none;">
                                            <div class="comm_opration_img">
                                                <img src="/images/reply.png">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="sub_reply_{{ $comment->id }}" class="comm_sub_reply_box" style="display:none;">
                                    <textarea></textarea>
                                    <div class="comm_submit">
                                        <a href="javscript:;"
                                           onclick="replySubHandler(this,'{{ $comment->id }}','{{ $experience->id }}');">回复</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @if(\Auth::user())
                        <div class="exp_comm_reply_box">
                            <div class="user_avatar">
                                <img src="{{ \Auth::user()->fullAvatarUrl }}" style="border-radius: 50%">
                            </div>
                            <div class="reply_part">
                                <textarea></textarea>
                                <div class="comm_submit">
                                    <a href="javascript:;"
                                       onclick="javascript:replyHandler(this, '{{ $experience->id }}');">评论</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
{{--<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>--}}
{{--<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
{{--<script src="/js/top.js"></script>--}}
<script>
    $(function () {
        $('.content_article h1,.content_article h2,.content_article h3,.content_article h4,.content_article h5,.content_article p').css('text-align', 'justify');
        $('.content_article h1').css('font-weight', '400');
        $('.content_article h2').css('font-weight', '400');
        $('.content_article h3').css('font-weight', '400');
        $('.content_article h4').css('font-weight', '300');
        $('.content_article h5').css('font-weight', '400');
        $('.content_article p').css('font-weight', '400');
        $('.content_article h1,.content_article h2,.content_article h3,.content_article h4,.content_article h5').css('font-family', 'PingFang SC');

        $('.content_article h2').css('line-height', '4rem');
        $('.content_article h3').css('line-height', '3.2rem');
        $('.content_article h4').css('line-height', '2.8rem');
        $('.content_article h5').css('line-height', '2rem');
        $('.content_article p').css('line-height', '2.5rem');
        $('.content_article p').css('font-size', '1.5rem');
        $('.content_article p').css('margin-bottom', '2rem');
    });

    function replyHandler(obj, id) {
        var content = $(obj).parents(".reply_part").find("textarea").val();
        if (content.length == 0) {
            return
        }
        var data = {
            content: content,
        }
        $.ajax({
            url: "/experience/postcomment/" + id,
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

    function replySubHandler(obj, pid, id) {

        if (checkLogin()) {
            $("#login").click()
            return
        }
        var content = obj.parentNode.parentNode.getElementsByTagName("textarea")[0].value
        if (content.length == 0) {
            //TODO 为空提示
            return;
        }
        var data = {
            content: content,
            parent_id: pid
        }
        $.ajax({
            url: "/experience/postcomment/" + id,
            method: "POST",
            data: data,
            dataType: "json",
            success: function (result) {
                if (result.code != 200) {
                    console.log("遇到问题" + result.status)
                    return
                }
                //TODO 暂时先刷新
                window.location.reload()
            }
        })
    }

    function praiseHandler(obj, id) {

        if (checkLogin()) {
            $("#login").click()
            return
        }
        $.ajax({
            url: "/experience/postupvote/" + id,
            method: "POST",
            dataType: "json",
            success: function (result) {
                if (result.code != 200) {
                    alert(result.msg)
                    return
                }
                if (result.upvote == true) {
                    var d1 = obj.getElementsByClassName("opration_praise_num")[0]
                    d1.innerText = parseInt(d1.innerText) + 1

                } else {
                    var d1 = obj.getElementsByClassName("opration_praise_num")[0]
                    d1.innerText = parseInt(d1.innerText) - 1
                }
            }
        })
    }

    function subItemOver(obj) {
        obj.getElementsByClassName("comm_opration")[0].style.display = "block";
    }

    function subItemOut(obj) {
        obj.getElementsByClassName("comm_opration")[0].style.display = "none";
    }

    function showReplyCommentBox(obj, id) {
        var d = $("#sub_reply_" + id).css('display')
//        var d = document.getElementsByClassName("comm_sub_reply_box")[0].style.display;
        if (d == "block") {
            $("#sub_reply_" + id).css('display', 'none')
        } else {
            $("#sub_reply_" + id).css('display', 'block')
        }
    }

    function replySubHandler(obj, pid, id) {

        if (checkLogin()) {
            $("#login").click()
            return
        }
        var content = obj.parentNode.parentNode.getElementsByTagName("textarea")[0].value
        if (content.length == 0) {
            //TODO 为空提示
            return;
        }
        var data = {
            content: content,
            parent_id: pid
        }
        $.ajax({
            url: "/experience/postcomment/" + id,
            method: "POST",
            data: data,
            dataType: "json",
            success: function (result) {
                if (result.code != 200) {
                    alert(result.msg)
                    return
                }
                window.location.reload()
            }
        })
    }

</script>
</body>
</html>
