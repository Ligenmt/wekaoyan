@include("layout.header")
<!-- Custom styles for this template -->
<link href="/css/common.css" rel="stylesheet">
<link href="/css/top.css" rel="stylesheet">
<link href="/css/question-index.css" rel="stylesheet">
<body>

@include("layout.top")

<div class="container">
    <div class="row">
        @include("layout.sidebar")

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main_container">
            <div class="content_list">
                @if(\Auth::user())
                    <div class="list_title">
                        <div class="publish">
                            <a href="/question/post">我要提问</a>
                        </div>
                    </div>
                @endif
                @if(count($questions) > 0)
                    <ul class="postul">
                        @foreach($questions as $key=>$question)
                            @if($question->user != null)
                            <li name="shuoshuo_{{$key}}" id="shuoshuo_{{$key}}">
                                <div class="comm_head">
                                    <div class="comm_avatar" style="position: relative">
                                        <a target="_blank" href="/user/{{$question->user->id}}">
                                            <img src="{{ $question->user->fullAvatarUrl }}" style="border-radius:50%;width: 50px;">
                                            @if($question->user->is_teacher == 1)
                                                <span title="老师" class="notification-vip">T</span>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="comm_user_name" style="margin-top: 10px">
                                        <a style="margin-left: 10px; " target="_blank" href="/user/{{$question->user->id}}">
                                       {{ $question->user->name }}
                                        </a>
                                    </div>

                                    <div class="comm_info" style="margin-left: 50px;">
                                        @if($question->forum)
                                            {{ $question->forum->name }}
                                            @else
                                            未知版块
                                        @endif
                                        <div class="comm_title" onclick="show('{{ $question->id }}');">
                                            {{ $question->title }}
                                        </div>
                                        <div class="comm_evaluate" onclick="show('{{ $question->id }}');">
                                            <div class="comm_replay">
                                                <img src="/images/reply.png">
                                                <p>{{ $question->answers_count }}个回答</p>

                                            </div>
                                            {{--<div class="comm_praise">--}}
                                            {{--<img src="/images/praise.png">--}}
                                            {{--<p>关注</p>--}}
                                            {{--<p>1</p>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>

                                </div>

                            </li>
                            @endif
                        @endforeach
                    </ul>
                    {{ $questions->render() }}
                @else
                    暂无提问..
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    function show(id) {
        window.location.href = '/question/' + id
    }
</script>
</body>
</html>
