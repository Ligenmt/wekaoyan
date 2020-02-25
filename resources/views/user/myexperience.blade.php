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
                <li><a href="/user/{{ $user->id }}/shuoshuo">我的说说{{ $user->shuoshuos_count }}</a></li>
                <li class="active"><a href="/user/{{ $user->id }}/experience">我的文章{{ $user->experiences_count }}</a></li>
                <li><a href="/user/{{ $user->id }}/file">我的资料{{ $user->files_count }}</a></li>
                <li><a href="/user/{{ $user->id }}/question">我的提问{{ $user->questions_count }}</a></li>
                <li><a href="/user/{{ $user->id }}/answer">我的回答{{ $user->answers_count }}</a></li>
                @if($user->is_teacher)
                    <li><a href="/user/{{ $user->id }}/focusforum">我的板块</a></li>
                @endif
            </ul>
            <div id="tabcontent" class="content">
                <div class="" id="myexperience">
                    <div class="exp_box">
                        <ul>
                            @foreach($experiences as $experience)
                                <li id="">
                                    <div class="content_title" onclick="showExperience('{{ $experience->id }}');">{{ $experience->title }}</div>

                                    {{--<div class="content_summary">  {!!  str_limit($experience->content, 50, '...') !!}</div>--}}
                                    <div class="comment">
                                        <div>
                                            <div class="comment_ico">
                                                <img src="/images/praise.png">
                                            </div>
                                            <div class="comment_des" style="color:#00c226;">点赞</div>
                                            <div class="comment_num" style="color:#00c226;">{{ $experience->experienceupvotes_count }}</div>
                                        </div>
                                        <div tyle="cursor:pointer;">
                                            <div class="comment_ico">
                                                <img src="/images/reply.png">
                                            </div>
                                            <div class="comment_des">评论</div>
                                            <div class="comment_num">{{ $experience->experiencecomments_count }}</div>
                                        </div>
                                        {{--<div tyle="cursor:pointer;">--}}
                                            {{--<div class="comment_ico"><img src="/images/share.png"></div>--}}
                                            {{--<div class="comment_des">分享</div>--}}
                                            {{--<div class="comment_num">0</div>--}}
                                        {{--</div>--}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
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


