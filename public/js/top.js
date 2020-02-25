// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// })

function StringBuffer() {
    this.__strings__ = new Array();
}
StringBuffer.prototype.append = function (str) {
    this.__strings__.push(str);
    return this;    //方便链式操作
}
StringBuffer.prototype.toString = function () {
    return this.__strings__.join("");
}

$("#register").click(function () {
    $(".alert-danger").css("display", "none")
    $("#reg-mobile").val('')
    $("#reg-password").val('')
    $("#reg-name").val('')
})

$("#login").click(function () {
    $(".alert-danger").css("display", "none")
    $("#login-mobile").val('')
    $("#login-password").val('')
})


$("#forum").click(function () {

    h = setTimeout(function () {
        $("#select-forum").select2("open")
    }, 500);

})


var smsflag = false
$("#btn-smscode").click(function () {

    if (smsflag) {
        return
    }

    $(".alert-sms").css('display', 'none')
    var mobile = $("#reg-mobile").val()
    if (!(/^1[0-9]{10}$/.test(mobile))) {
        $(".alert-sms").text('请输入正确的手机号码！')
        $(".alert-sms").css('display', 'block')
        return
    }

    $.ajax({
        url: "/register/sms",
        method: "POST",
        data: {
            mobile: mobile
        },
        dataType: "json",
        success: function (res) {
            // if (res.code != 200) {
            //     console.log('遇到问题，code:' + res.code)
            //     return
            // }
            smsflag = true
            var time = 60;
            var h;
            h = setInterval(function () {
                $("#btn-smscode").css('cursor', 'not-allowed')
                if (time < 10) {
                    time = '0' + time;
                }
                $("#btn-smscode").text(time)
                time--;
                if (time < 0) {
                    clearInterval(h);
                    smsflag = false;
                    $("#btn-smscode").text('验证')
                    $("#btn-smscode").css('cursor', 'pointer')
                }
            }, 1000);
        },
        error: function (req, status, error) {

        }
    })
})

$("#btn-register").click(function (event) {
    $(".alert-danger-bottom").css("display", "none")
    $("#btn-register").text('注册中..')
    var mobile = $("#reg-mobile").val()
    var password = $("#reg-password").val()
    var name = $("#reg-name").val()
    var code = $("#reg-smscode").val()
    var isteacher = $("input[name='teacher']:checked").val();


    if (mobile == undefined || mobile.length == 0) {
        $(".alert-danger-bottom").text("请输入正确的手机号！")
        $(".alert-success").css("display", "none")
        $(".alert-danger-bottom").css("display", "block")
        $("#btn-register").text('注册')
        return
    }

    if (name == undefined || name.length == 0) {
        $(".alert-danger-bottom").text("请输入昵称！")
        $(".alert-success").css("display", "none")
        $(".alert-danger-bottom").css("display", "block")
        $("#btn-register").text('注册')
        return
    }

    if (password === undefined || password.length == 0) {
        $(".alert-danger-bottom").text("请输入密码！")
        $(".alert-success").css("display", "none")
        $(".alert-danger-bottom").css("display", "block")
        $("#btn-register").text('注册')
        return
    }
    if (code == undefined || code.length == 0) {
        $(".alert-danger-bottom").text("请输入验证码！")
        $(".alert-success").css("display", "none")
        $(".alert-danger-bottom").css("display", "block")
        $("#btn-register").text('注册')
        return
    }

    if (isteacher == undefined) {
        $(".alert-danger-bottom").text("请选择您的身份！")
        $(".alert-success").css("display", "none")
        $(".alert-danger-bottom").css("display", "block")
        $("#btn-register").text('注册')
        return
    }

    var data = {
        mobile: mobile,
        name: name,
        password: password,
        code: code,
        is_teacher: isteacher
    }
    $.ajax({
        url: "/register/",
        method: "POST",
        data: data,
        dataType: "json",
        success: function (res) {
            if (res.code != 200) {
                $(".alert-danger-bottom").text(res.msg)
                $(".alert-success").css("display", "none")
                $(".alert-danger-bottom").css("display", "block")
                $("#btn-register").text('注册')
                return
            }
            $(".alert-success").text('注册成功')
            $(".alert-danger-bottom").css("display", "none")
            $(".alert-success").css("display", "block")
            // $('#register-modal').modal('hide')
            $("#reg-mobile").val('')
            $("#reg-password").val('')
            $("#reg-name").val('')
            // location.reload()
            location.replace('/')
        },
        error: function (req, status, error) {
            $(".alert-danger-bottom").text("手机号或密码输入错误")
            $(".alert-success").css("display", "none")
            $(".alert-danger-bottom").css("display", "block")
            $("#btn-register").text('注册')
        }
    })
})
$("#btn-login").click(function (event) {
    $(".alert-danger").css("display", "none")
    $("#btn-login").text('登录中..')
    var mobile = $("#login-mobile").val()
    var password = $("#login-password").val()
    var data = {
        mobile: mobile,
        password: password
    }
    $.ajax({
        url: "/login",
        method: "POST",
        data: data,
        dataType: "json",
        success: function (res) {
            if (res.code != 200) {
                $(".alert-danger").text(res.msg)
                $(".alert-danger").css("display", "block")
                $("#btn-login").text('登录')
                return
            }
            $('#login-modal').modal('hide')
            // console.log('login finish')
            location.replace('/')
            //location.reload(true)

        },
        error: function (req, status, error) {
            //console.log(status)
            $(".alert-danger").text("手机号或密码错误")
            $(".alert-success").css("display", "none")
            $(".alert-danger").css("display", "block")
            $("#btn-login").text('登录')
        }
    })
})


$("#bell").click(function () {
    var d = $("#bell").attr("aria-expanded")
    if (d === undefined || d == "false") {
        $.ajax({
            url: "/loadnotif",
            method: "GET",
            success: function (response) {
                if (response.code != 200) {
                    console.log("存在一个问题，状态码为：" + response.code);
                    return;
                }
                console.log(response.data)
                document.getElementById("notification_content").innerHTML = response.data;

            },
            error: function (req, status, error) {
                console.log(error)
            }
        })
    }
})

$("#btn-forgot").click(function () {
    window.open('/forgot')
})

function checkLogin() {
    var au = $("#auth_user").attr("value")
    return (au === undefined)
}

function switchForum(id) {
    loadingStart()
    $.ajax({
        url: "/changeforum/" + id,
        method: "GET",
        success: function (response) {
            if (response.code != 200) {
                console.log("存在一个问题，状态码为：" + response.code);
                loadingEnd()
                return;
            }
            // location.reload()
            loadingEnd()
            window.location.href = "/index"
        },
        error: function (req, status, error) {
            console.log(error)
            loadingEnd()
        }
    })

}

function focusForum(id) {
    $.ajax({
        url: "/forum/focus/" + id,
        method: "GET",
        success: function (response) {
            if (response.code != 200) {
                console.log("存在一个问题，状态码为：" + response.code);
                return;
            }
            if (response.focus) {
                // alert("关注成功!");
                $("#focusforum").text("取消关注此论坛")
            } else {
                // alert("取消关注!");
                $("#focusforum").text("关注此论坛")
            }
        },
        error: function (req, status, error) {
            console.log(error)
        }
    })
}

function loadingStart() {
    $(".fullscreen-shadow").css('display', 'block')
}

function loadingEnd() {
    $(".fullscreen-shadow").css('display', 'none')
}
