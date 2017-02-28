<html ng-app="ionicApp">
<head>
        <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title>精选课程</title>

    <link href="{{asset('style/css/ionic.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/share.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/index.css')}}" rel="stylesheet"/>
    <script src="{{asset('js/all.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/layer.js')}}"></script>
    <script src="{{asset('style/js/ionic.bundle.min.js')}}"></script>
    <script src="{{asset('js/jquery-1.8.0.min.js')}}"></script>
     <script type="text/javascript">

    angular.module('ionicApp', ['ionic'])

    .controller('SlideController', function($scope) {
      
      $scope.myActiveSlide = 0;
      
    });
    
    
    </script>
    <style type="text/css">
    .lei {
        position: relative;
        display: inline-block;
        width: 100%;

    }

    .classify_list {
        display: block;
        float: left;
        width: 24.7%;
        text-align: center;
        cursor: pointer;
        height: 40px;

    }

    .classify_list span {
        display: inline-block;
        width: 100%;
        height: 40px;
        line-height: 40px;
    }

    .classify_list .firstspan {
        border-right: 1px solid #c0c0c0;
        border-left: 1px solid #c0c0c0;
    }
    .list_ul {
        position: relative;
        left: 0;
        text-align: left;
        z-index: 10;
        background-color: #f2f2f2;
        display: none;
    }
    .list_ul li ,.list_ul li span{
        height: 35px;
        line-height:35px;
        padding-left: 5px;
        border-bottom: 0.05rem solid #dadada;
    }

    .sta {
        background: #fff;
    }

    .lastUL {
        width: 300%;
        padding: 0 0.5rem;
        background-color: #fff;
        position: absolute;
        top: 0;
        left: 100%;
        display: none;
    }

    .classify_list:nth-child(2) .list_ul li span {
        border-right: none;
        border-left: none;
    }

    .classify_list:nth-child(3) .list_ul li span {
        border-right: none;
        border-left: none;
    }

    .list_ul li a {
        display: inline-block;
        width: 100%;
        text-align: left;
    }

    .showlist {
        display: block;
    }

</style>
</head>
<body>
<!--精选课程-->

<!--顶部-->
<div class="bar bar-header bar-positive  " >
  <a class="button button-clear icon ion-ios-arrow-left" href="#" onClick="javascript:history.back(-1);"></a>
     <h1 class="title">意见反馈</h1>
   
   </div>
<!--内容-->   

   <ion-view title="Home" hide-nav-bar="true">
   <ion-scroll  direction="y" scrollbar-y="false" style="width: 100%; height: 100%">
   
             <div style="width:70px;height:70px;"></div>
       <div class="list list-inset">
              <label class="item item-input">
              <i class="icon ion-android-person positive"></i>
                <input type="text" placeholder="联系邮箱" id="email">
              </label>
              <label class="item item-input">
              <i class="icon ion-ios-unlocked-outline positive"></i>
                <textarea name="" id="feedBack" cols="30" rows="5" placeholder="反馈意见"></textarea>
              </label>
              <label class="item item-checkbox">
                <span id="errorInfo" style="color:red;"></span>
                   <input type="button" value="提交" id="but" style="width:70px;float:right;background:#00E3E3;color:#fff;
">
            </label>
              
          </div>
    
     </ion-scroll>
    </ion-view>
    <!-- 底部-->
     @include('master')


</body> 
</html>
<script type="text/javascript" src="{{asset('style/js/jquery.js')}}"></script>
<script type="text/javascript">
   $(function(){
      $("#but").click(function(){
        var email = $("#email").val();
        var feedBack = $("#feedBack").val();
        var _token = "{{ csrf_token() }}";
        var emailRules =/^([a-zA-Z0-9_\.\-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if(email == '')
        {
             $("#errorInfo").html("邮箱不能为空");
             return false;
        }else if(!emailRules.test(email))
         {
            $("#errorInfo").html("请输入正确的邮箱");
            return false;
         }else if(feedBack == '')
        {
            $("#errorInfo").html("请输入您的反馈意见");
            return false;
        }else if(feedBack.length<10)
        {
            $("#errorInfo").html("请输入不少于10个字的反馈意见");
            return false;
        }else
        {
            $.ajax({
               type: "POST",
               url: "{{URL('sub_feed')}}",
               data: {email:email,feedBack:feedBack,_token:_token},
               success: function(msg){
                   if(msg == 1)
                   {
                      $("#errorInfo").css("color","green");
                      $("#errorInfo").html("谢谢您的意见反馈,文明用语");
                   }else
                   {
                     $("#errorInfo").html("服务器错误");
                   }
               }
            });
        }
      })
   })
</script>

