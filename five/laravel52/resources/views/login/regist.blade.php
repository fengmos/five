<!DOCTYPE html>

<head>

<title>注册</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no,width=device-width,height=device-height">
    <link rel="stylesheet" type="text/css" href="{{asset('style/css/ionic.css')}}">
 <!-- <link rel="stylesheet" type="text/css" href="ionic.min.css">  -->
</head>
<body>
<div class="scroll-content padding" id="index_login">
	<form action="{{URL('add')}}" method="post" id="form">
			<div class="list list-borderless">
				<div class="item item-image">
					<img src="{{asset('style/img/1a.png')}}" style="background-size: 100% 100% ;">
				</div>
			</div>
		  <div class="list list-inset">
			  <label class="item item-input">
				<input type="text" placeholder="请输入手机号" id="username" name="tel">
			  </label>
			  {{csrf_field()}}
			  <label class="item item-input" style="margin-top: 20px;">
				  <input type="text" placeholder="输入验证码" id="code">
				  {{--<a href="javascript:void(0);" style="text-decoration: none;color:#0080FF;" id="btn">点击发送验证码</a>--}}
				  <input type="button" value="点击获取验证码" id="btn" style="width:50px;display:block;border: none;margin-left: 80px;font-size: 16px;">
			  </label>
			  <label class="item item-input" style="margin-top: 20px;">
				<input type="password" placeholder="密码" id="password" name="pwd">
			  </label>
		  </div>
	   <button class="button button-block button-royal" href="#index_regist" type="submit">注册 </button>
		<input type="hidden" value="" id="error">
	</form>
	<div class="info" style="margin-left: 140px;">
		   <p style="font-size: 16px; color:red;" id="errorInfo"></p>
	</div>
</div>

</body>
</html>
<script src="{{asset('style/js/jquery.js')}}"></script>
<script>
	$(document).on('blur','#code',function () {
		var code = $(this).val();
        $.ajax({
            type: "get",
            url: "{{URL('contrast')}}",
            data: {code:code},
            success: function(msg){
               if(msg == 1){
                   $("#error").val(1);
                   $("#errorInfo").html("验证码正确");
                   return true
			   }else {
                   $("#errorInfo").html("验证码不正确");
                   $("#error").val(0);
                   return false;
			   }
            }
        });
    })
    $(document).ready(function(){
        $("#btn").click(function(){
            var a=time(this);
			var tel = $('#username').val();
            if(tel == ''){
                $("#errorInfo").html("请输入手机号");
                return false;
			}else if(!(/^1(3|4|5|7|8)\d{9}$/.test(tel))){
                $("#errorInfo").html("请输入正确的手机号");
                return false;
			}else {
                $("#errorInfo").html("");
                $.ajax({
                    type: "get",
                    url: "{{URL('only')}}",
                    data: {tel:tel},
                    success: function(msg){
                        if(msg == 1){
                            $("#errorInfo").html("该手机号已被注册");
                            return false;
                        }else{
                            a;
                            $.ajax({
                                type: "get",
                                url: "{{URL('short')}}",
                                data: {tel:tel},
                                success: function(msg){
                                    if(msg == 1){
                                        $("#errorInfo").html("短信已经发送");
                                    }
                                }
                            });
						}
                    }
                });
			}
        })
    })

    var wait=60;
    function time(o) {
        if (wait == 0) {
            o.removeAttribute("disabled");
            o.value="免费获取验证码";
            wait = 60;
        } else {
            o.setAttribute("disabled", true);
            o.value="重新发送(" + wait + ")";
            wait--;
            setTimeout(function() {
                    time(o)
                },
                1000)
        }
    }
</script>
<script>
    $("#form").submit(function(){
        var username = $("#username").val();
        var pwd = $("#password").val();
        var error = $('#error').val();
        if(username == '' || pwd == '')
        {
            $("#errorInfo").html("请填写完整");
            return false;
        }else if(!(/^1(3|4|5|7|8)\d{9}$/.test(username))){
            $("#errorInfo").html("请输入正确的手机号");
            return false;
        }else if(!(/^[a-zA-Z]\w{4,10}$/.test(pwd))){
            $("#errorInfo").html("字母开头 长度在6~18之间");
            return false;
		}//else if(error == 0){
//            $("#errorInfo").html("验证码不正确");
//            return false;
//		}

    })

	$(function(){
          $("#username").blur(function(){
			  var username = $(this).val();
              if(username == ''){
                   $("#errorInfo").fadeIn("slow",function () {
                       $(this).html("请输入用户名");
                   })
			  }
		  })
        $("#password").blur(function(){
            var password = $(this).val();
            if(password == ''){
                $("#errorInfo").html("请输入密码");
                return false;
            }else {
                return true;
			}
        })
	})
</script>