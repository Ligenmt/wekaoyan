@include("layout.header")
<body>
<link href="/css/common.css" rel="stylesheet">
<link href="/css/top.css" rel="stylesheet">
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
                    <div class="edit_word">发表说说</div>
                    <div class="edit_turnback"><a href="/shuoshuo">返回</a></div>
                </div>
                <form role="form" method="post" action="/shuoshuo/dopost">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea class="form-control" rows="3" name="content"></textarea>
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
                        @if(\Auth::check() && \Auth::user()->is_teacher == true)
                        <div class="edit_draft"><a href="javascript:;" onclick="batchPost();">批量发布</a></div>
                        @endif
                    </div>
                    <div id="focusedforums" class="content content_answer" style="padding: 5px; display: none">
                        <label for="name">已关注的板块</label>
                        <div id="focusedforumslist">

                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
<script>
    function batchPost() {
        fetch("/forum/focus", {
            method: 'GET',
            credentials: "include"
        }).then(function(response){
                if(!response.ok){
                    console.log("存在一个问题，状态码为："+ response.status);
                    return;
                }
                response.json().then(function(result) {
                    //检查响应文本
                    console.log(result)
                    document.getElementById("focusedforumslist").innerHTML= result.tffs
                    $("#focusedforums").css("display", "block")
                })


            }
        ).catch(function (error) {
            console.log(error)
        })
    }
</script>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
{{--<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>--}}
{{--<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
{{--<script src="/js/top.js"></script>--}}
</body>
</html>
