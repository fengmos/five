<?php
use Symfony\Component\HttpFoundation\Session\Session;
$session = new Session();
?>
<html ng-app="ionicApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title>精选课程</title>

    <link href="{{asset('style/css/ionic.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/share.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/index.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('css/weui.css')}}">
    <link rel="stylesheet" href="{{asset('css/book.css')}}">
    <link rel="stylesheet" href="{{asset('css/swipe.css')}}">

    <script src="{{asset('js/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('js/all.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/layer.js')}}"></script>
    <script src="{{asset('style/js/ionic.bundle.min.js')}}"></script>
    <script type="text/javascript">
        angular.module('ionicApp', ['ionic'])
                .controller('SlideController', function($scope) {
                    $scope.myActiveSlide = 0;
                });
    </script>
    <style>
        a{
            text-decoration:none;
        }

        #aa{
            width: 23px; height: 23px;
            float: left;
        }
        td{
            height: 35px;
        }
    </style>
</head>
<body>
<!--精选课程-->

<!--顶部-->
<div class="bar bar-header bar-positive  " >
    <a class="button button-clear icon ion-ios-arrow-left"  onclick="history.go(-1);"></a>
    <h1 class="title">教师信息</h1>

</div>
<!--内容-->
<center>
<ion-view title="Home" hide-nav-bar="true">
    <ion-scroll  direction="y" scrollbar-y="false" style="width: 100%; height: 100%">
        <section>
            <div class="nxqalbum" style="margin-top: 45px;">
                <img src="<?=$data['teacher_img']?>" data-original="" class="nxqtopimg sw_loading" />
                <input type="hidden" id="teacher_id"value="<?php echo $data['teacher_id']?>">
                {{--http://admin.duzejun.cn/--}}
            </div>
        </section>

        <section class="bg1">

            <div class="InsDetails">
                <div class="InsD_title">
                    <div class="clearfix">
                        <h3 class="f18 lh25"><?=$data['teacher_name']?>教师</h3>
                        <a href="javascript:void(0)" class="share lh25"><i></i>分享</a>
                    </div>
                    <p class="gray2"><?=$data['teacher_name']?>儿</p>
                </div>
                <div class="InsD_table">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width: 80px" class="gray2">工作时间</td>
                            <td class="orange"><?=$data['teacher_years']?></td>
                        </tr>
                        <tr>
                            <td class="gray2" >讲课老师</td>
                            <td class="f14 gray1">
                                {{--<a href="{{url('detamils')}}?id={{$id}}" class="gray1" target="_blank">--}}
                                    <?=$data['teacher_name']?>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="gray2 zanimg" align="center">人气</td>
                            <td >

                                <font  id="num">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data['teacher_num']?>个人为他点过赞</font>
                                {{--<input type="button" id="aa" onclick="fun()" value="点赞"/>--}}
                                <img src="image/timg.png" width="30px" height="30px" onclick="fun()"value="点赞"id="aa">

                            </td>

                        </tr>
                        <tr>
                            <td class="gray2">教师介绍</td>
                            <td class="gray1">
                                <a href="javascript:void(0)">
                                    <b class="f14"><?php echo $data['teacher_desc']?></b>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </section>

        <section class="bg1 mt10" style="margin-top: 0;border-top: none">

        </section>


        <section class="indexMore bgf6  clearfix">
            <div>
                <a href="javascript:void(0)" class="more_r more" id="back-to-top">回到顶部<i></i></a>
            </div>
        </section>
    </ion-scroll>
</ion-view>
</center>
<!-- 底部-->
</body>
</html>

<script>
function fun(){

    var num_dom= $('#num');
    var num=$('#num').val();
    var teacher_id=$('#teacher_id').val();
//    alert(num);

    $.ajax({
        type: "get",
        url: "{{URL('check')}}",
        data: "name="+num+"&teacher_id="+teacher_id,
        success: function(res){
            if(res==2)
            {
                alert('您还没有登陆');
            }else if(res==0)
            {
                alert('对不起，您只能为您喜欢的老师投票一次');
            }else
            {
                num_dom.attr('value',res)
            }

        }
    });
}


</script>