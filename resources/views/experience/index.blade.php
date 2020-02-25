@include("layout.header")
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
            <div class="content_list">
                @if(\Auth::user())
                <div class="list_title">
                    <div class="publish">
                        <a href="/experience/post">发表经验</a>
                    </div>
                </div>
                @endif
                @if(count($experiences) > 0)
                <ul>
                    @foreach($experiences as $experience)
                    <li>
                        <div class="content_title" onclick="showExperience('{{ $experience->id }}');">{{ $experience->title }}</div>
                        <div class="content_user">
                            <div class="user_avatar">
                                <a target="_blank" href="/user/{{ $experience->user->id }}">
                                    <img src="{{ $experience->user->fullAvatarUrl }}" style="border-radius: 50%">
                                    @if($experience->user->is_teacher == 1)
                                        <span title="老师" class="notification-vip">T</span>
                                    @endif
                                </a>
                            </div>
                            <div class="user_name">
                                <a target="_blank" href="/user/{{ $experience->user->id }}">{{ $experience->user->name }}</a>
                            </div>
                            <div class="update_time">{{ $experience->updated_at }}</div>
                        </div>
                        {{--<div class="content_summary">--}}
                            {{--{!!  str_limit($experience->content, 70, '...') !!}--}}
                        {{--</div>--}}
                        <div class="comment">
                            <div onclick="javascript:upvoteHandler('{{ $experience->id }}');">
                                <div class="comment_ico">
                                    <img src="/images/praise.png">
                                </div>
                                <div class="comment_des" style="color:#00c226;">点赞</div>
                                <div class="comment_num" style="color:#00c226;">{{ $experience->experienceupvotes_count }}</div>
                            </div>
                            <div tyle="cursor:pointer;">
                                <div class="comment_ico"><img src="/images/reply.png"></div>
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
                {{ $experiences->render() }}
                @else
                暂无经验帖！需要您的贡献
                @endif
            </div>

        </div>
    </div>
</div>
<script>
    function showExperience(id) {
        window.location.href = '/experience/' + id
    }

    function upvoteHandler(id) {
        
    }
</script>
</body>
</html>
