@include("layout.header")
<!-- Custom styles for this template -->
<link href="/css/common.css" rel="stylesheet">
<link href="/css/top.css" rel="stylesheet">
<link href="/css/postshuoshuo.css" rel="stylesheet">
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
                    <div class="edit_word">回答问题</div>
                    <div class="edit_turnback"><a href="/question/{{ $forum->id }}">返回</a></div>
                </div>
                <form role="form" method="post" action="/question/dopost/{{ $forum->id }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="问题标题">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" name="content" placeholder="问题描述"></textarea>
                    </div>
                    @if(count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    <div class="content_opration">
                        <div class="content_btn">
                            <input class="edit_publish" type="submit" value="发表">
                        </div>
                        {{--<div class="edit_draft"><a href="javascript:;" onclick="javascript:saveDraft();">保存草稿</a></div>--}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/js/top.js"></script>
</body>
</html>
