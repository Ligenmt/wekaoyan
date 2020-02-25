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
                <form role="form" action="/upload" method="post" enctype="multipart/form-data"
                      onsubmit="return checkType()">
                    {{ csrf_field() }}
                    <input type="file" name="uploadfile">
                    <input type="hidden" name="type" id="type">
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

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main_container">
            <ul class="nav nav-tabs doc-tab">
                <li><a href="#zhenti" data-toggle="tab" onclick="chtab('1')">专业课真题</a></li>
                <li><a href="#data" data-toggle="tab" onclick="chtab('-1')">专业课资料</a></li>
                @if(\Auth::user())
                    <div class="right " style="float: right; margin: 0 5px 0 5px; line-height: 44px">
                        <button id="uploadbtn" type="button" class="btn btn-link" data-toggle="modal"
                                data-target="#upload-modal" value="1">上传真题
                        </button>
                    </div>
                @endif
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="zhenti">
                    <div class="content_list">
                        <div class="content_title" style="text-align: center">
                            <div style="width: 50%">标题</div>
                            <div style="width: 16%">上传者</div>
                            <div style="width: 16%">上传时间</div>
                            <div style="width: 8%">下载次数</div>
                        </div>
                        <ul class="exam">
                            @foreach($filesZhenti as $file)
                                <li>
                                    {{--<div class="i1"><input type="checkbox"></div>--}}
                                    <div class="i2" title="{{$file->filename}}">{{ $file->filename }}</div>
                                    <div class="i4">{{ $file->user->name }}</div>
                                    <div class="i3">{{ $file->updated_at->diffForHumans() }}</div>
                                    <div class="i5">{{ $file->downloads+$file->downloads_virtual }}</div>
                                    <div class="i6"><a href="javascript:downloadFile('{{ $file->id }}');">下载</a></div>
                                    {{--<div class="i7"><a href="javascript:deleteFile();">删除</a></div>--}}
                                </li>
                            @endforeach
                        </ul>
                        {{ $filesZhenti->render() }}
                    </div>
                </div>
                <div class="tab-pane fade" id="data">
                    <div class="tab-pane fade in active" id="zhenti">
                        <div class="content_list">
                            <div class="content_title">
                                <div style="width: 50%">标题</div>
                                <div style="width: 16%">上传者</div>
                                <div style="width: 16%">上传时间</div>
                                <div style="width: 8%">下载次数</div>
                            </div>
                            <ul class="exam">
                                @foreach($filesData as $file)
                                    <li>
                                        {{--<div class="i1"><input type="checkbox"></div>--}}
                                        <div class="i2">{{ $file->filename }}</div>
                                        <div class="i4">{{ $file->user->name }}</div>
                                        <div class="i3">{{ $file->updated_at->diffForHumans() }}</div>
                                        <div class="i5">{{ $file->downloads }}</div>
                                        <div class="i6"><a href="javascript:downloadFile('{{ $file->id }}');">下载</a>
                                        </div>
                                        {{--<div class="i7"><a href="javascript:deleteFile();">删除</a></div>--}}
                                    </li>
                                @endforeach
                            </ul>
                            {{ $filesData->render() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>

    function GetQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null)return unescape(r[2]);
        return null;
    }

    $(document).ready(function () {
        var zhenti = GetQueryString("zhenti")
        var data = GetQueryString("data")
        if (data != null) {
            //$('.doc-tab li:last').addClass('active')
            $('.doc-tab a:last').tab('show')
        } else {
            $('.doc-tab li:first').addClass('active')
        }

    });

    function downloadFile(id) {
        window.open('/download/' + id)
    }

    function chtab(i) {
        if (i > 0) {

            $("#uploadbtn").text('上传真题')
            $("#uploadbtn").attr('value', '1')
        } else {
            $("#uploadbtn").text('上传资料')
            $("#uploadbtn").attr('value', '-1')
        }
    }

    function checkType() {
        if ($("#uploadbtn").attr('value') == 1) {
            $("#type").val('0')
        } else {
            $("#type").val('1')
        }
    }
</script>
</body>
</html>
