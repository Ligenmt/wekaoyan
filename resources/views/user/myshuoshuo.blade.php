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
                <li><a href="/user/{{ $user->id }}/basic">基本资料</a></li>
                <li class="active"><a href="/user/{{ $user->id }}/shuoshuo">我的说说{{ $user->shuoshuos_count }}</a></li>
                <li><a href="/user/{{ $user->id }}/experience">我的文章{{ $user->experiences_count }}</a></li>
                <li><a href="/user/{{ $user->id }}/file">我的资料{{ $user->files_count }}</a></li>
                <li><a href="/user/{{ $user->id }}/question">我的提问{{ $user->questions_count }}</a></li>
                <li><a href="/user/{{ $user->id }}/answer">我的回答{{ $user->answers_count }}</a></li>
                @if($user->is_teacher)
                <li><a href="/user/{{ $user->id }}/focusforum">我的板块</a></li>
                @endif
            </ul>
            <div id="tabcontent" class="content">
                <div class="" id="myshuoshuo">
                    <div class="comm_box">
                        <ul>
                            @foreach($shuoshuos as $key=>$shuoshuo)
                                <li name="comm_7" id="shuoshuo_{{$shuoshuo->id}}" class="">
                                    <div class="comm_head">
                                        <div class="comm_info">
                                            <div class="comm_title" onclick="showShuoshuo('{{$key}}', '{{ $shuoshuo->id }}');">{{ $shuoshuo->content }}</div>
                                            <div class="comm_evaluate" onclick="showShuoshuo('{{$key}}', '{{ $shuoshuo->id }}');">
                                                <div class="comm_replay" >
                                                    <img src="/images/reply.png">
                                                    <p>评论</p><p>{{ $shuoshuo->shuoshuocomments_count }}</p>
                                                </div>
                                                <div class="comm_praise">
                                                    <img src="/images/praise.png">
                                                    <p>点赞</p><p>{{ $shuoshuo->shuoshuoupvotes_count }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="comm_time">{{ $shuoshuo->created_at }}</div>
                                    </div>
                                    <div class="comm_reply" style="display:none;">
                                        <ul>
                                            @foreach($shuoshuo->shuoshuocomments as $comment)
                                                <li class="reply_4">
                                                    <div class="comm_user_item" onmousemove="subItemOver(this)" onmouseout="subItemOut(this)">
                                                        <div class="comm_user_reply">
                                                            <div class="comm_user_name">

                                                                @if($comment->parent_id)
                                                                    <a target="_blank" href="/user/{{$comment->user->id}}">{{ $comment->user->name }}</a>
                                                                    回复了
                                                                    <a target="_blank" href="/user/{{$comment->parent->user->id}}">{{ $comment->parent->user->name }}:</a>
                                                                @else
                                                                    <a target="_blank" href="/user/{{$comment->user->id}}">{{ $comment->user->name }}:</a>
                                                                @endif

                                                            </div>

                                                            <div class="comm_user_reply_content">{{ $comment->content }}</div>
                                                        </div>
                                                        <div class="comm_opration" onclick="showReplyCommentBox(this)" style="display: none;">
                                                            <div class="comm_opration_img">
                                                                <img src="/images/reply.png">
                                                            </div>
                                                            <p><a href="javascript:;" onclick="showSubReplyBox(this,'4');">回复</a></p>
                                                        </div>
                                                    </div>
                                                    <div class="comm_sub_reply_box" style="display:none;">
                                                        <textarea></textarea>
                                                        <div class="comm_submit">
                                                            <a href="javscript:;" onclick="replySubHandler(this,'{{ $comment->id }}','{{ $shuoshuo->id }}');">回复</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="comm_reply_box">
                                            <textarea></textarea>
                                            <div class="comm_submit">
                                                <a href="javascript:;" onclick="javascript:replyHandler(this,'{{ $shuoshuo->id }}');">评论</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{--<div class="tab-pane" id="myexperience">--}}
                    {{--<div class="exp_box">--}}
                        {{--<ul>--}}
                            {{--@foreach($experiences as $experience)--}}
                                {{--<li id="">--}}
                                    {{--<div class="content_title" onclick="showExperience('{{ $experience->id }}');">{{ $experience->title }}</div>--}}
                                    {{--<div class="content_user">--}}
                                        {{--<div class="user_avatar">--}}
                                            {{--<a href="javascript:;" onclick="javascript:;">--}}
                                                {{--<img src="{{ $user->fullAvatarUrl }}" style="border-radius: 50%">--}}
                                            {{--</a>--}}
                                        {{--</div>--}}
                                        {{--<div class="user_name">--}}
                                            {{--<a href="javascript:;" onclick="javascript:;">{{ $user->name }}</a>--}}
                                        {{--</div>--}}
                                        {{--<div class="update_time">{{ $experience->created_at }}</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="content_summary">  {!!  str_limit($experience->content, 50, '...') !!}</div>--}}
                                    {{--<div class="comment">--}}
                                        {{--<div>--}}
                                            {{--<div class="comment_ico">--}}
                                                {{--<img src="/images/praise.png">--}}
                                            {{--</div>--}}
                                            {{--<div class="comment_des" style="color:#00c226;">点赞</div>--}}
                                            {{--<div class="comment_num" style="color:#00c226;">{{ $experience->experienceupvotes_count }}</div>--}}
                                        {{--</div>--}}
                                        {{--<div tyle="cursor:pointer;">--}}
                                            {{--<div class="comment_ico">--}}
                                                {{--<img src="/images/reply.png">--}}
                                            {{--</div>--}}
                                            {{--<div class="comment_des">评论</div>--}}
                                            {{--<div class="comment_num">{{ $experience->experiencecomments_count }}</div>--}}
                                        {{--</div>--}}
                                        {{--<div tyle="cursor:pointer;">--}}
                                            {{--<div class="comment_ico"><img src="/images/share.png"></div>--}}
                                            {{--<div class="comment_des">分享</div>--}}
                                            {{--<div class="comment_num">0</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="tab-pane" id="myuploads">--}}
                    {{--<div class="comm_box">--}}
                        {{--<ul>--}}
                            {{--@foreach($files as $file)--}}
                                {{--<li name="comm_7" id="comm_7" class="">--}}
                                    {{--<div class="comm_head">--}}
                                        {{--<div class="comm_avatar">--}}
                                            {{--<img src="{{ $user->fullAvatarUrl }}" style="border-radius: 50%">--}}
                                        {{--</div>--}}
                                        {{--<div class="comm_info">--}}
                                            {{--<div class="comm_user">{{ $question->user->name }}--}}
                                            {{--</div>--}}
                                            {{--<div class="comm_title">{{ $file->filename }}</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="comm_time">{{ $file->created_at }}</div>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="tab-pane fade" id="myquestion">--}}
                    {{--<div class="comm_box">--}}
                        {{--<ul>--}}
                            {{--@foreach($questions as $question)--}}
                                {{--<li name="comm_7" id="comm_7" class="">--}}
                                    {{--<div class="comm_head">--}}
                                        {{--<div class="comm_avatar">--}}
                                            {{--<img src="{{ $user->fullAvatarUrl }}" style="border-radius: 50%">--}}
                                        {{--</div>--}}
                                        {{--<div class="comm_info">--}}
                                            {{--<div class="comm_user">{{ $question->user->name }}--}}
                                            {{--</div>--}}
                                            {{--<div class="comm_title" onclick="showQuestion('{{ $question->id }}')">{{ $question->title }}</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="comm_time">{{ $question->created_at }}</div>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="tab-pane" id="myanswer">--}}
                    {{--<div class="exp_box">--}}
                        {{--<ul>--}}
                            {{--@foreach($answers as $answer)--}}
                                {{--@if($answer->question != null)--}}
                                {{--<li id="">--}}
                                    {{--<div class="content_title" onclick="showQuestion('{{ $answer->question->id }}');">{{ $answer->question->title }}</div>--}}
                                    {{--<div class="content_summary">  {!!  str_limit($answer->content, 30, '...') !!}</div>--}}
                                    {{--<div class="comment">--}}
                                        {{--<div>--}}
                                            {{--<div class="comment_ico">--}}
                                                {{--<img src="/images/praise.png">--}}
                                            {{--</div>--}}
                                            {{--<div class="comment_num" style="color:#00c226;">{{ $answer->upvotes }}</div>--}}
                                            {{--<div class="comment_des" style="color:#00c226;">赞同</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                                {{--@endif--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--@if($user->is_teacher)--}}
                {{--<div class="tab-pane" id="myfocusforum">--}}
                    {{--<div class="comm_box">--}}
                        {{--<ul>--}}
                            {{--@foreach($teacher_focus_forums as $teacher_focus_forum)--}}
                                {{--<li name="comm_7" id="comm_7" class="">--}}
                                    {{--<div class="comm_head">--}}
                                        {{--<div class="comm_info" onclick="toForum('{{ $teacher_focus_forum->forum_id }}')">--}}
                                            {{--<div class="comm_title">{{ $teacher_focus_forum->forum->name }}</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="comm_time">{{ $teacher_focus_forum->created_at }}</div>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--@endif--}}
            </div>

        </div>
    </div>
</div>

<script>

//    $(document).ready(function(){
//        var h = window.location.hash.replace("#", "");
//        if(h != null) {
//            $(".comm_box").css("opacity", "0.2")
//            console.log($("#" + h))
//            $("#" + h).css("opacity", "1 !important")
//        }
//
//    });

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


