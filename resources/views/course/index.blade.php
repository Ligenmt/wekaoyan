
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>白猫考研</title>

    <!-- Bootstrap core CSS -->
    {{--<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">--}}
    <link href="/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="/css/common.css" rel="stylesheet">
    <link href="/css/top.css" rel="stylesheet">
    <link href="/css/course.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>


    <![endif]-->
</head>

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
        <div id="sidebar" class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
            <ul class="nav nav-pills nav-stacked nav-kaoyan">
                <li><a href="/shuoshuo/{{ $major->id }}">研友交流</a></li>
                <li><a href="/examdata/{{ $major->id }}">真题资料</a></li>
                <li><a href="/experience/{{ $major->id }}">经验帖</a></li>
                <li><a href="/scoreline/{{ $major->id }}">分数线</a></li>
                <li class="active"><a href="/course/{{ $major->id }}">专业课介绍</a></li>
                <li><a href="/lecture/{{ $major->id }}">学长讲座</a></li>
                <li><a href="/senior/{{ $major->id }}">学长请进</a></li>
                @if(\Auth::user())
                    <li><a href="/usercenter">个人中心</a></li>
                @else
                    <li class="disabled"><a href="##">个人中心</a></li>
                @endif
            </ul>
        </div>

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main_container">
            <ul id="tab" class="nav nav-tabs">
                <li class="active"><a href="#book" data-toggle="tab">参考用书</a></li>
                <li><a href="#question" data-toggle="tab">参考题型</a></li>
                <li><a href="#method" data-toggle="tab">复习方法</a></li>
                <li><a href="#index" data-toggle="tab">相关专业目录</a></li>
                <li><a href="#score" data-toggle="tab">理念分数线</a></li>
            </ul>
            <div id="tabcontent" class="tab-content">
                <div class="tab-pane fade in active" id="book">
                    <div class="item_body">
                        <ul>
                            <li name="data1" id="data1">
                                <div class="item_title">参考用书</div>
                                <div class="item_content">

                                </div>
                            </li>
                            <li name="data2" id="data2">
                                <div class="item_title">考试题型</div>
                                <div class="item_content">
                                </div>
                            </li>
                            <li name="data3" id="data3">
                                <div class="item_title">复习方法</div>
                                <div class="item_content">

                                </div>
                            </li>
                            <li name="data4" id="data4">
                                <div class="item_title">相关专业目录</div>
                                <div class="item_content">

                                </div>
                            </li>
                            <li name="data5" id="data5">
                                <div class="item_title">历年分数线</div>
                                <div class="item_content">

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="question">
                </div>
                <div class="tab-pane fade" id="method">
                </div>
                <div class="tab-pane fade" id="index">
                </div>
                <div class="tab-pane fade" id="score">
                    <p>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
