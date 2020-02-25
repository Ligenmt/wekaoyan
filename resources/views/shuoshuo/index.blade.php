@include("layout.header")
<body>
<!-- Custom styles for this template -->
<link href="/css/common.css" rel="stylesheet">
<link href="/css/top.css" rel="stylesheet">
<link href="/css/shuoshuo.css" rel="stylesheet">
<style>
    .main_container {
        background: white;
    }

</style>
@include("layout.top")

<div class="container">
    <div class="row">
        @include("layout.sidebar")

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main_container">
            <div class="content_list">
                @if(\Auth::user())
                    <div class="list_title">
                        <div class="publish">
                            <a href="/shuoshuo/post">发表说说</a>
                        </div>
                    </div>
                @endif
                @if(count($shuoshuos) > 0)
                    <ul class="postul">
                        @foreach($shuoshuos as $key=>$shuoshuo)
                            <li name="shuoshuo_{{$key}}" id="shuoshuo_{{$key}}">
                                <div class="comm_head">
                                    <div class="comm_avatar">
                                        <a target="_blank" href="/user/{{$shuoshuo->user->id}}">
                                            <img src="{{ $shuoshuo->user->fullAvatarUrl }}" style="border-radius: 50%">
                                            @if($shuoshuo->user->is_teacher == 1)
                                                <span title="老师" class="notification-vip">T</span>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="comm_info">
                                        <div class="comm_user">
                                            <a target="_blank"
                                               href="/user/{{$shuoshuo->user->id}}">{{ $shuoshuo->user->name }}</a>
                                        </div>
                                        <div class="comm_title"
                                             onclick="javascript:showCommDetail(4);">{{ $shuoshuo->content }}</div>
                                        <div class="comm_evaluate">
                                            <div onclick="javascript:showReplyBox(this,'{{$key}}');"
                                                 class="comm_replay">
                                                <img src="/images/reply.png">
                                                <p>评论</p>
                                                <p>{{ $shuoshuo->shuoshuocomments_count }}</p>
                                            </div>
                                            <div onclick="javascript:praiseHandler(this, '{{ $shuoshuo->id }}');"
                                                 class="comm_praise">
                                                <img src="/images/praise.png">
                                                @if($shuoshuo->upvote(\Auth::id())->exists())
                                                    <p>取消</p>
                                                @else
                                                    <p>点赞</p>
                                                @endif
                                                <p>{{ $shuoshuo->shuoshuoupvotes_count }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comm_time">{{\Carbon\Carbon::parse($shuoshuo->updated_at)->diffForHumans()}}</div>
                                </div>
                                <div class="comm_reply" style="display:block;">
                                    <ul>
                                        @foreach($shuoshuo->shuoshuocomments as $comment)
                                            <li class="reply_4">
                                                <div class="comm_user_item" onmousemove="subItemOver(this)"
                                                     onmouseout="subItemOut(this)">
                                                    <div class="comm_user_reply">
                                                        <div class="comm_user_name">
                                                            @if($comment->parent_id)
                                                                <a target="_blank"
                                                                   href="/user/{{$comment->user->id}}">{{ $comment->user->name }}</a>
                                                                回复了
                                                                <a target="_blank"
                                                                   href="/user/{{$comment->parent->user->id}}">{{ $comment->parent->user->name }}
                                                                    :</a>
                                                            @else
                                                                <a target="_blank"
                                                                   href="/user/{{$comment->user->id}}">{{ $comment->user->name }}
                                                                    :</a>
                                                            @endif
                                                        </div>
                                                        <div class="comm_user_reply_content">{{ $comment->content }}</div>

                                                    </div>
                                                    <div class="comm_reply_time">{{ $comment->updated_at }}</div>
                                                    <div class="comm_opration" onclick="showReplyCommentBox(this)"
                                                         style="display: none;">
                                                        <div class="comm_opration_img">
                                                            <img src="/images/reply.png">
                                                        </div>
                                                        {{--<p><a href="javascript:;" onclick="showSubReplyBox(this,'4');">回复</a></p>--}}
                                                    </div>
                                                </div>
                                                <div class="comm_sub_reply_box" style="display:none;">
                                                    <textarea></textarea>
                                                    <div class="comm_submit">
                                                        <a href="javscript:;"
                                                           onclick="replySubHandler(this,'{{ $comment->id }}','{{ $shuoshuo->id }}');">回复</a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="comm_reply_box">
                                        <textarea></textarea>
                                        <div class="comm_submit">
                                            <a href="javascript:;"
                                               onclick="javascript:replyHandler(this,'{{ $shuoshuo->id }}');">评论</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    {{ $shuoshuos->render() }}
                @else
                    暂无研友在交流..
                @endif
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {

    })

    function subItemOver(obj) {
        obj.getElementsByClassName("comm_opration")[0].style.display = "block";
    }

    function subItemOut(obj) {
        obj.getElementsByClassName("comm_opration")[0].style.display = "none";
    }

    function showReplyBox(obj, postid) {
        $("#shuoshuo_" + postid).find(".comm_reply").toggle();
    }

    function showReplyCommentBox(obj) {
        var d = obj.parentNode.parentNode.getElementsByClassName("comm_sub_reply_box")[0].style.display;
        if (d == "block") {
            obj.parentNode.parentNode.getElementsByClassName("comm_sub_reply_box")[0].style.display = "none"
        } else {
            obj.parentNode.parentNode.getElementsByClassName("comm_sub_reply_box")[0].style.display = "block"
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

    function praiseHandler(obj, id) {

        if (checkLogin()) {
            $("#login").click()
            return
        }
        var data = {
            id: id
        }
        $.ajax({
            url: "/shuoshuo/postupvote/" + id,
            method: "POST",
            data: data,
            dataType: "json",
            success: function (result) {
                if (result.code != 200) {
                    alert(result.msg)
                    return
                }
                if (result.upvote == true) {
                    var p1 = obj.getElementsByTagName("p")[0]
                    p1.innerText = '取消'
                    var p2 = obj.getElementsByTagName("p")[1]
                    p2.innerText = parseInt(p2.innerText) + 1

                } else {
                    var p1 = obj.getElementsByTagName("p")[0]
                    p1.innerText = '点赞'
                    var p2 = obj.getElementsByTagName("p")[1]
                    p2.innerText = parseInt(p2.innerText) - 1
                }

            }
        })
    }

    function replyHandler(obj, id) {

        if (checkLogin()) {
            $("#login").click()
            return
        }

        var content = $(obj).parents(".comm_reply_box").find("textarea").val();
        if (content.length == 0) {
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
