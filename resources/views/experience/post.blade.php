@include("layout.header")
<!-- Custom styles for this template -->
<link href="/css/common.css" rel="stylesheet">
<link href="/css/top.css" rel="stylesheet">
<link href="/css/postshuoshuo.css" rel="stylesheet">
<link href="/css/experience.css" rel="stylesheet">
<body>
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
                    <div class="edit_word">发表经验</div>
                    <div class="edit_turnback"><a href="/experience">返回</a></div>
                </div>
                <form role="form" method="post" action="/experience/dopost">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="title">标题</label>
                        <input type="text" class="form-control" name="title" id="experience_title" placeholder="输入标题">
                    </div>
                    <div class="form-group">
                        <textarea id="content" name="content" style="display:none"></textarea>
                        <div id="editor" name="content" style="height: 300px;">
                            {{--<p>--}}
                            {{--@if(!empty($post)){!! $post->content !!}@endif--}}
                            {{--</p>--}}
                        </div>
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
                            <input class="edit_publish" type="submit" id="public_experience" value="发表">
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
{{--<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>--}}
{{--<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
<link href="/css/wangEditor.min.css" rel="stylesheet">
<script src="/js/wangEditor.min.js"></script>
<script>
    $(document).ready(function () {
        var E = window.wangEditor;
        var editor = new E('#editor');
        editor.customConfig.uploadImgServer = '/upload/image';  // 上传图片到服务器
        editor.customConfig.uploadImgHeaders = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };
        editor.customConfig.uploadFileName = 'wangEditorImg';
        // 将图片大小限制为 10M
        editor.customConfig.uploadImgMaxSize = 10 * 1024 * 1024;
        // 限制一次最多上传 5 张图片
        editor.customConfig.uploadImgMaxLength = 5;
        // 隐藏“网络图片”tab
        editor.customConfig.showLinkImg = false;
        editor.customConfig.zIndex = 1;
        editor.customConfig.menus = [
            'head',  // 标题
            'bold',  // 粗体
            'italic',  // 斜体
            'underline',  // 下划线
            'strikeThrough',  // 删除线
            'foreColor',  // 文字颜色
            'backColor',  // 背景颜色
            'link',  // 插入链接
            'list',  // 列表
            'justify',  // 对齐方式
            'quote',  // 引用
            'emoticon',  // 表情
            'image',  // 插入图片
            'table',  // 表格
//                'video',  // 插入视频
            'code',  // 插入代码
            'undo',  // 撤销
            'redo'  // 重复
        ];
        var content = $('#content')
        editor.customConfig.onchange = function (html) {
            content.val(html)
        }
        editor.create();
        content.val(editor.txt.html())

//        $("#public_experience").click(function () {
//            var title = $("#experience_title").val()
//            var content = editor.txt.html();
//            var data = {
//                title: title,
//                content: content,
//            }
//            fetch("/experience/dopost", {
//                method: 'POST',
//                data: data,
//                credentials: "include"
//            }).then(function(response){
//                if(response.status!==200){
//                    console.log("存在一个问题，状态码为："+ response.status);
//                    return;
//                }
//                //检查响应文本
//                response.json().then(function(result){
//                    // console.log(result);
//                });
//                }
//            ).catch(function (error) {
//                console.log(error)
//            })
//        })


    })

</script>
</body>
</html>
