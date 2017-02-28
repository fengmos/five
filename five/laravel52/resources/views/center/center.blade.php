<?php
use Symfony\Component\HttpFoundation\Session\Session;
$session = new Session();
?>
<html ng-app="ionicApp">
<style>
  /*.login{text-align: center;margin-top: 200px;}*/
  .duoxue{background: #fff;border-radius: 60px;color:#8E8E8E;}
  body {font: normal 100% Helvetica, Arial, sans-serif;}
  h1 {font-size: 1.5em; }
  small {font-size: 0.875em;}

</style>
<head>
        <meta charset="UTF-8">
<!--     <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" /> 
    <title>我的信息</title>
    <link href="{{asset('style/css/ionic.min.css')}}" rel="stylesheet">
    <script src="{{asset('style/js/ionic.bundle.min.js')}}"></script>
     <script type="text/javascript">
    angular.module('ionicApp', ['ionic'])

    .controller('SlideController', function($scope) {
      
      $scope.myActiveSlide = 0;
      
    });
    
    
    </script>
</head>
<body>
<!--我的信息-->

<!--顶部-->
 <div class="bar bar-header bar-positive item-input-inset " >
     <h1 class="title">我的信息</h1>
      <a class="button button-clear icon ion-person-stalker"onclick="history.go(-1);"></a>
    </div>
<!--内容-->   
   <ion-view title="Home" hide-nav-bar="true">
   <ion-scroll  direction="y" scrollbar-y="false" style="width: 100%; height: 100%">
    <div style="display:none;" id="user_info">
             <div style="width:70px;height:70px;"></div>
              <div style="margin:10px auto;width:100px;height:100px;border-radius:50px;overflow:hidden;">
                    <img src="{{$arr['img']}}" style="margin:0;width:100%;height:100%;">
              </div>

                   <p style="text-align:center">昵称：{{$arr['nickname']}}</p>
              <div>

                 <ul class="list">
                  <li class="item  item-button-right icon ion-ios-person-outline">
                        <a class="button button-clear icon " href="{{URL('myinfo')}}" style="margin-right:150px;color:#000;">个人信息</a>
                    </li>
                    <li  class="item  item-button-right icon ion-ios-folder-outline">
                      <a class="button button-clear icon " href="{{URL('mycart')}}" style="margin-right:130px;color:#000;">我的购物车</a>
                    </li>
                     <li  class="item  item-button-right icon ion-ios-folder-outline">
                     <a class="button button-clear icon " href="{{URL('myorder')}}" style="margin-right:130px;color:#000;">已购买课程</a>
                    </li>
                    <li class="item item-button-right icon ion-ios-star-outline">
                      <a class="button button-clear icon " href="{{URL('personal')}}" style="margin-right:150px;color:#000;">我的收藏</a>
                    </li>
                     
                    <li class="item  item-button-right icon ion-ios-person-outline">
                  <a class="button button-clear icon " href="{{URL('feedback')}}" style="margin-right:150px;color:#000;">意见反馈</a>

                
        
              </div>
             
    </div>
     <div style="display:none;" id="user_login">
             <div style="width:70px;height:70px;"></div>
                  <a href="{{URL('login')}}"> <p style="text-align:center"><button class="duoxue" style="width:150px;height:50px;">登录多学网</button></p></a>
              <div>
              <div>

                 <ul class="list">
                  <li class="item  item-button-right icon ion-ios-person-outline">
                        <a class="button button-clear icon " href="{{URL('myinfo')}}" style="margin-right:150px;color:#000;">个人信息</a>
                    </li>
                    <li  class="item  item-button-right icon ion-ios-folder-outline">
                      <a class="button button-clear icon " href="{{URL('mycart')}}" style="margin-right:130px;color:#000;">我的购物车</a>
                    </li>
                     <li  class="item  item-button-right icon ion-ios-folder-outline">
                     <a class="button button-clear icon " href="{{URL('myorder')}}" style="margin-right:130px;color:#000;">已购买课程</a>
                    </li>
                    <li class="item item-button-right icon ion-ios-star-outline">
                      <a class="button button-clear icon " href="{{URL('personal')}}" style="margin-right:150px;color:#000;">我的收藏</a>
                    </li>
                     
                    <li class="item  item-button-right icon ion-ios-person-outline">
                  <a class="button button-clear icon " href="{{URL('feedback')}}" style="margin-right:150px;color:#000;">意见反馈</a>
                    </li>
                </ul>
              </div>
        </div>
      </div>
    <div style="height:50px;width:100%;clear:all"></div>
     </ion-scroll>
    </ion-view>
    <!-- 底部-->
     @include('master')


</body> 
</html>
<script ></script>
<script type="text/javascript" src="{{asset('style/js/jquery.js')}}"></script>
<script>
  $(function(){
     var user_session = "{{$session->get('nickname')}}";
    if(user_session == '')
    {
       $("#user_login").show();
       $("#user_info").hide();
    }else
    {
       $("#user_info").show();
       $("#user_login").hide();
    }
  })
</script>