<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>404-对不起！您访问的页面不存在</title>
    <style type="text/css">
        body {
            margin: 0;
            color: #222;
            font: 16px/1.7 'Helvetica Neue', Helvetica, Arial, Sans-serif;
            background: #eff2f5;
        }

        img {
            border: none;
            width: 80%;
            height: 80%;
        }

        a {
            text-decoration: none;
            color: #105cb6;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            margin: 169px auto 0;
            width: 404px;
        }

        .error-wide {
            width: 500px;
        }

        @media (max-width: 500px) {
            .error {
                width: 98%;
            }
        }

        .error .header {
            overflow: hidden;
            font-size: 1.8em;
            line-height: 1.2;
            margin: 0 0 .33em .33em;
        }

        .error .header img {
            vertical-align: text-bottom;
        }

        .error .header .mute {
            color: #999;
            font-size: .5em;
        }

        .error hr {
            margin: 1.3em 0;
        }

        .error p {
            margin: 0 0 1.7em;
            color: #999;
        }

        .error p:last-child {
            margin-bottom: 0;
        }

        .error strong {
            font-size: 1.1em;
            color: #000;
        }

        .error .content {
            padding: 2em 1.25em;
            border: 1px solid #babbbc;
            border-radius: 5px;
            background: #f7f7f7;
            text-align: center;
        }

        .error .content .single {
            margin: 3em 0;
            font-size: 1.1em;
            color: #666;
        }
    </style>
    </head>
<body>
<div class="page">
    <div class="error">
        <h1 class="header">
            <a href="/" class="logo">
                <img src="/images/logo.png" alt="白猫考研">
            </a>
            - 404
        </h1>
        <div class="content">
            <p>
                <strong>你似乎来到了没有知识存在的荒原...</strong>
            </p>
            {{--<p>来源链接是否正确？用户、话题或问题是否存在？</p>--}}
            <hr>
            <p>
                <a href="/">返回首页</a>
                <span>或者</span>
                <a href="javascript:history.go(-1)" id="js-history-back">返回上页</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>