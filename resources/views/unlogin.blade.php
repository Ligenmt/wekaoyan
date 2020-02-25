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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>

    <
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
        @include("layout.sidebar")

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main_container">
            <div>您尚未登录!</div>
        </div>
    </div>
</div>
</body>
</html>
