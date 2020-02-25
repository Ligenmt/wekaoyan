@include("layout.header")
<body>
<!-- Custom styles for this template -->
<link href="/css/common.css" rel="stylesheet">
<link href="/css/top.css" rel="stylesheet">
<link href="/css/shuoshuo.css" rel="stylesheet">
<script type="text/javascript"
        src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
@include("layout.top")

<div class="container">
    <div class="row">
        @include("layout.sidebar")

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main_container">
           真题
            <p>
                若
                <math xmlns="http://www.w3.org/1998/Math/MathML">
                    <mi>a</mi><mo>&#x2260;</mo><mn>0</mn>
                </math>,
                则
                <math xmlns="http://www.w3.org/1998/Math/MathML">
                    <mi>a</mi><msup><mi>x</mi><mn>2</mn></msup>
                    <mo>+</mo> <mi>b</mi><mi>x</mi>
                    <mo>+</mo> <mi>c</mi> <mo>=</mo> <mn>0</mn>
                </math>
                有两个解，分别为
            </p>
            <p>
                <math xmlns="http://www.w3.org/1998/Math/MathML" display="block">
                    <mi>x</mi> <mo>=</mo>
                    <mrow>
                        <mfrac>
                            <mrow>
                                <mo>&#x2212;</mo>
                                <mi>b</mi>
                                <mo>&#x00B1;</mo>
                                <msqrt>
                                    <msup><mi>b</mi><mn>2</mn></msup>
                                    <mo>&#x2212;</mo>
                                    <mn>4</mn><mi>a</mi><mi>c</mi>
                                </msqrt>
                            </mrow>
                            <mrow> <mn>2</mn><mi>a</mi> </mrow>
                        </mfrac>
                    </mrow>
                    <mtext>.</mtext>
                </math>
            </p>

        </div>
    </div>
</div>
<script>

    $(document).ready(function () {

    })

    function subItemOver(obj) {
        obj.getElementsByClassName("comm_opration")[0].style.display = "block";
    }

    function subItemOut(obj) {
        obj.getElementsByClassName("comm_opration")[0].style.display = "none";
    }

    function showReplyBox(obj, postid) {
        $("#shuoshuo_" + postid).find(".comm_reply").toggle();
    }

    function showReplyCommentBox(obj) {
        var d = obj.parentNode.parentNode.getElementsByClassName("comm_sub_reply_box")[0].style.display;
        if (d == "block") {
            obj.parentNode.parentNode.getElementsByClassName("comm_sub_reply_box")[0].style.display = "none"
        } else {
            obj.parentNode.parentNode.getElementsByClassName("comm_sub_reply_box")[0].style.display = "block"
        }
    }

    function replySubHandler(obj, pid, id) {

        if (checkLogin()) {
            $("#login").click()
            return
        }
        var content = obj.parentNode.parentNode.getElementsByTagName("textarea")[0].value
        if (content.length == 0) {
            //TODO 为空提示
            return;
        }
        var data = {
            content: content,
            parent_id: pid
        }
        $.ajax({
            url: "/shuoshuo/postcomment/" + id,
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

    function praiseHandler(obj, id) {

        if (checkLogin()) {
            $("#login").click()
            return
        }
        var data = {
            id: id
        }
        $.ajax({
            url: "/shuoshuo/postupvote/" + id,
            method: "POST",
            data: data,
            dataType: "json",
            success: function (result) {
                if (result.code != 200) {
                    alert(result.msg)
                    return
                }
                if (result.upvote == true) {
                    var p1 = obj.getElementsByTagName("p")[0]
                    p1.innerText = '取消'
                    var p2 = obj.getElementsByTagName("p")[1]
                    p2.innerText = parseInt(p2.innerText) + 1

                } else {
                    var p1 = obj.getElementsByTagName("p")[0]
                    p1.innerText = '点赞'
                    var p2 = obj.getElementsByTagName("p")[1]
                    p2.innerText = parseInt(p2.innerText) - 1
                }

            }
        })
    }

    function replyHandler(obj, id) {

        if (checkLogin()) {
            $("#login").click()
            return
        }

        var content = $(obj).parents(".comm_reply_box").find("textarea").val();
        if (content.length == 0) {
            return;
        }
        var data = {
            content: content,
        }
        $.ajax({
            url: "/shuoshuo/postcomment/" + id,
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
