@include("layout.header")

<body>
<!-- Custom styles for this template -->
<link href="/css/common.css" rel="stylesheet">
<link href="/css/top.css" rel="stylesheet">
<link href="/css/question.css" rel="stylesheet">
<link href="/css/postshuoshuo.css" rel="stylesheet">
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
            <div class="content">
                <div class="content_head">
                    <a href="/question">返回列表</a>
                </div>
                <div class="content_body">


                    <div class="content_title">
                        <img src="/images/question.jpg" alt=""
                             style="width: 20px;height: 20px;vertical-align: top;margin-top: 5px;">
                        {{ $question->title }}
                    </div>
                    <div class="content_info">
                        {{--<div> {!! $question->content !!}</div>--}}
                        <div class="readnum">
                            <span>{{ $question->answers_count }}个回答</span>
                            {{--<button class="btn btn-primary" id="btn_focus" onclick="focusQuestion('{{ $question->id }}')">--}}
                            {{--@if($is_focus)--}}
                            {{--取消关注--}}
                            {{--@else--}}
                            {{--关注问题--}}
                            {{--@endif--}}
                            {{--</button>--}}
                            <button class="btn btn-primary" onclick="showAnswer()"> 写回答</button>
                        </div>
                    </div>
                </div>
                <div class="content content_answer" style="padding: 5px; display: none">
                    <form role="form" method="post" action="/answer/dopost">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea class="form-control" rows="10" name="content" placeholder="写回答..."></textarea>
                        </div>
                        <input type="hidden" name="question" value="{{$question->id}}">
                        <input type="hidden" name="forum" value="{{$forum_id}}">
                        {{--@if(count($errors) > 0)--}}
                        {{--<div class="alert alert-danger" role="alert">--}}
                        {{--@foreach($errors->all() as $error)--}}
                        {{--<li>{{ $error }}</li>--}}
                        {{--@endforeach--}}
                        {{--</div>--}}
                        {{--@endif--}}
                        <div class="content_opration">
                            <div class="content_btn">
                                <input class="edit_publish" type="submit" value="发表">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="content_list">
                    <ul>

                        @foreach($question->answers as $answer)
                            <li>
                                <div class="content_title">
                                    <div class="content_user col-sm-12">
                                        <div class="user_avatar">
                                            <a target="_blank" href="/user/{{ $answer->user->id }}">
                                                <img src="{{ $answer->user->fullAvatarUrl }}" style="border-radius: 50%">
                                            </a>
                                        </div>
                                        <div class="user_name">
                                            <a target="_blank" style="font-size:18px;"
                                               href="/user/{{ $answer->user->id }}">{{ $answer->user->name }}</a>
                                        </div>

                                        <div class="comm_reply_time pull-right">
                                            <div onclick="praiseHandler(this, '{{$answer->id}}');"
                                                 class="comm_praise" style="margin-right: 20px">
                                                <img src="/images/praise.png" style="width: 12px; margin-right: 5px;">
                                                <p style="display: inline-block">点赞</p>
                                                <p style="display: inline-block">{{ $answer->upvotes }}</p>
                                            </div>
                                            {{ $answer->updated_at }}
                                        </div>

                                    </div>
                                    {{--<div class="content_evaluate">--}}
                                    {{--<div onclick="praiseHandler(this, '{{$answer->id}}');" class="comm_praise" style="margin-right: 20px">--}}
                                    {{--<img src="/images/praise.png" style="width: 10px;">--}}
                                    {{--<p>点赞</p>--}}
                                    {{--<p>{{ $answer->upvotes }}</p>--}}
                                    {{--</div>--}}

                                    {{--<button type="button" style="border: none;background: white" onclick="praiseHandler(this, '{{$answer->id}}')">--}}
                                    {{--<img src="/images/praise.png">--}}
                                    {{--<p>点赞</p>--}}
                                    {{--</button>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="content_summary" style="margin-left: 60px;font-size:16px;">
                                    {{--<p>{{ $answer->user->name }}的回答:</p>--}}
                                    {{ $answer->content }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script>
    function showAnswer() {
        if (checkLogin()) {
            $("#login").click()
            return
        }
        $(".content_answer").css("display", "block")

    }
    function praiseHandler(obj, id) {
        if (checkLogin()) {
            $("#login").click()
            return
        }
        $.ajax({
            url: '/answer/upvote/' + id,
            method: "POST",
            data: {
                id: id
            },

            success: function (res) {
                if (res.code != 200) {
                    alert("操作失败")
                    return
                }
                if (res.upvote == true) {

                    var p1 = obj.getElementsByTagName("p")[0]
                    //p1.innerText = '取消'
                    var p2 = obj.getElementsByTagName("p")[1]
                    p2.innerText = parseInt(p2.innerText) + 1

                } else {
                    var p1 = obj.getElementsByTagName("p")[0]
                    //p1.innerText = '点赞'
                    var p2 = obj.getElementsByTagName("p")[1]
                    p2.innerText = parseInt(p2.innerText) - 1
                }

            }
        })
    }
    function focusQuestion(id) {
        if (checkLogin()) {
            $("#login").click()
            return
        }

        $.ajax({
            url: "/question/focus/" + id,
            method: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function (res) {
                if (res.code != 200) {
                    alert("操作失败")
                    return
                }
                if (res.focus) {
                    $("#btn_focus").text('取消关注')
                } else {
                    $("#btn_focus").text('关注问题')
                }

            },
            error: function (req, status, error) {
                alert("哎~服务器好像有点问题")
            }
        })
    }
</script>
</body>
</html>
