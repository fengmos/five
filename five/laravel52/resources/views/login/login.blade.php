
<!DOCTYPE html>
<head>
<title>登录</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no,width=device-width,height=device-height">
<link rel="stylesheet" type="text/css" href="{{asset('style/css/ionic.css')}}">  
 <!-- <link rel="stylesheet" type="text/css" href="ionic.min.css">  -->
	<style>
		.box{
			margin-left: 100px;
			line-height: 30px;
			width: 300px;
		}
	</style>
</head>
<body>
<div class="scroll-content padding" id="index_login">

			<div class="list list-borderless">
				<div class="item item-thumbnail-left item-positive">
				<img src="{{asset('style/img/1a.png')}}" style="margin:0;width:100%;height:100%;border-radius:50px;overflow:hidden;">
				<h1 class="light">login</h1>
			</div>
			</div>
	<form action="{{URL('checklogin')}}" method="post">
		{{csrf_field()}}
		  <div class="list list-inset">
			  <label class="item item-input">
			  <i class="icon ion-android-person positive"></i>
				<input type="text" placeholder="手机号" name="tel">
			  </label>
			  <label class="item item-input">
			  <i class="icon ion-ios-unlocked-outline positive"></i>
				<input type="password" placeholder="密码" name="pwd">
			  </label>
			  <label class="item item-checkbox">
				<label class="checkbox">
					<input type="checkbox" checked>
				</label>
				记住密码
			</label>
		  </div>
	  <button class="button button-block button-positive" type="submit">登陆 </button>
	</form>
	   <a class="button button-block button-positive" href="{{URL('regist')}}">注册 </a>
	<div class="info" style="margin-left: 140px;">
		@if(session('errors'))
			<p style="font-size: 16px; color:red;" id="errorInfo">{{session('errors')}}</p>
		@endif
	</div>
	<div style="float: left;margin-left: 80px;margin-top: 30px">
		<a href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=101371415&redirect_uri=http://xiaodu.duzejun.cn/&state=test&display=mobile">
			<img src="{{asset('style/img/qq222.png')}}">
		</a>
	</div>
	<div style="margin-left: 80px;float: left;margin-top: 30px">
	<a href="https://api.weibo.com/oauth2/authorize?client_id=61581137&redirect_uri=http://home.duzejun.cn/weibo&display=mobile"><img src="{{asset('style/img/weibo.png')}}" alt=""></a>
</div>
	</div>
</body>
</html>
<script src="{{asset('style/js/jquery.js')}}"></script>