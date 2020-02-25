@include("layout.header")
<!-- Custom styles for this template -->
<link href="/css/common.css" rel="stylesheet">
<link href="/css/top.css" rel="stylesheet">
<link href="/css/examdata.css" rel="stylesheet">
<body>

@include("layout.top")

<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
                <h4 class="modal-title" id="uploadModalLabel">
                    上传(大小不可超过500M)
                </h4>
            </div>
            <div class="modal-body">
                <form role="form" action="/upload" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" name="uploadfile">
                    <input type="hidden" name="type" id="type" value="1">
                    <button id="btn-login" type="submit" class="btn btn-primary btn-lg" style="margin-top: 5px">
                        提交
                    </button>
                </form>
            </div>
            <div class="alert alert-danger" style="display: none"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="container">
    <div class="row">
        @include("layout.sidebar")

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main_container" id="file-tab">
            <ul class="nav nav-tabs doc-tab">
                <li><a href="/examdata/zhenti" {{-- onclick="chtab('1')"--}}>专业课真题</a></li>
                <li class="active"><a href="/examdata/data" {{--onclick="chtab('-1')" --}}>专业课资料</a></li>
                <div class="right " style="float: right; margin: 0 5px 0 5px; line-height: 44px">
                    @if(\Auth::check())
                    <button id="uploadbtn" type="button" class="btn btn-link" data-toggle="modal"
                            data-target="#upload-modal" value="1">上传资料
                    </button>
                    @else
                    <button disabled="disabled" id="uploadbtn" type="button" class="btn btn-link" data-toggle="modal"
                            data-target="#upload-modal" value="1">登陆后可上传资料
                    </button>
                    @endif
                </div>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="zhenti">
                    <div class="content_list">
                        <div class="content_title" style="text-align: center">
                            <div style="width: 44%">标题</div>
                            <div style="width: 16%">上传者</div>
                            <div style="width: 16%">上传时间</div>
                            <div style="width: 8%">下载次数</div>
                            <div style="width: 16%">操作</div>
                        </div>
                        <ul class="exam">
                            @foreach($files as $file)
                                <li>
                                    {{--<div class="i1"><input type="checkbox"></div>--}}
                                    <div style="width: 44%" class="i2" title="{{$file->filename}}">{{ $file->filename }}</div>
                                    <div style="width: 16%" class="i4">{{ $file->user->name }}</div>
                                    <div style="width: 16%" class="i3">{{ $file->updated_at->diffForHumans() }}</div>
                                    <div style="width: 8%" class="i5">{{ $file->downloads+$file->downloads_virtual }}</div>
                                    <div style="width: 8%" class="i6"><a href="javascript:downloadFile('{{ $file->id }}');">下载</a></div>
                                    <div style="width: 8%" class="i6"><a data-toggle="modal" data-target="#comment-modal-{{ $file->id }}" href="#">评论:{{ $file->filecomments_count }}</a></div>
                                </li>

                                <div class="modal fade" id="comment-modal-{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">×
                                                </button>
                                                <h4 class="modal-title" id="loginModalLabel">
                                                    评论
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <ul>
                                                    @foreach($file->filecomments as $filecomment)
                                                    <li>
                                                        {{ $filecomment->user->name }}:
                                                        {{ $filecomment->content }}
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="alert alert-danger" style="display: none"></div>
                                            @if(\Auth::check())
                                            <div class="modal-footer">
                                                <form role="form">
                                                    <div class="form-group">
                                                        <input id="file_comment_{{ $file->id }}" type="text" name="mobile" class="form-control"
                                                               placeholder="输入评论(20个字以内)">
                                                    </div>
                                                </form>
                                                <div class="pull-right">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        取消
                                                    </button>
                                                    <button onclick="comment('{{ $file->id }}')" type="button" class="btn btn-primary">
                                                        评论
                                                    </button>
                                                </div>
                                            </div>
                                            @endif
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            @endforeach
                        </ul>
                        {{ $files->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    


    function GetQueryString(name)
    {
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if(r!=null)return  unescape(r[2]); return null;
    }

    function downloadFile(id) {
        window.open('/download/' + id)
    }

    function comment(id) {

        var content = $("#file_comment_" + id).val()
        var data = {
            id: id,
            content: content,
        }

        $.ajax({
            url: "/examdata/postcomment/",
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
