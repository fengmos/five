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
    </style>
</head>
<body>
<!--精选课程-->

<!--顶部-->
<div class="bar bar-header bar-positive  " >
    <a class="button button-clear icon ion-ios-arrow-left"  onclick="history.go(-1);"></a>
    <h1 class="title"><?=$onetv['file_name']?></h1>

</div>
<!--内容-->
<ion-view title="Home" hide-nav-bar="true">
    <ion-scroll  direction="y" scrollbar-y="false" style="width: 100%; height: 100%">
<section>
    <div class="nxqalbum"style="margin-top: 30px;">
        <video id="myVideo" width="300" height="220" controls poster="./style/001.jpg">
            <source src="http://admin.duzejun.cn<?=$onetv['url']?>" type="video/mp4">
        </video>
    </div>
</section>
<section class="bg1">

</section>
        <section class="bg1 mt10" style="margin-top: 0;border-top: none">
            <div>

            </div>
            <div class="InsDetails3" style="border-top: none;font-size: 15px;">
                <div style="font-size: 18px;">
                    <?=$kejie['cur_name']?>:
                        <br/>
                    课程提纲
                </div>
                    <?php foreach($kejie['pp'] as $key=>$val){?>
                <dl style="text-align: left">
                    <dt style="font-size: 16px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;
                        ☟<?=$val['chapter']?>
                    </dt>
                </dl>
                <?php foreach($val['pp'] as $k=>$v){?>
                <dd>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{URL('bfang')}}?fid=<?=$v['id']?>&cur_id=<?=$curone['cur_id']?>" ids="<?=$v['id']?>" class="bfang"><?=$v['file_name']?></a>
                </dd>
                <?php }?>
                <?php }?>
            </div>
        </section>

<section class="indexMore bgf6  clearfix">
    <div>
        <a href="javascript:void(0)" class="more_r more" id="back-to-top">回到顶部<i></i></a>
    </div>
</section>
    </ion-scroll>
</ion-view>
{{--<div class="botlayer">--}}
    {{--<div class="clear"></div>--}}
{{--</div>--}}
<!-- 底部-->
@include('master')
<script src="{{asset('js/swipe.min.js')}}" charset="utf-8"></script>
<script src="{{asset('js/book.js')}}" charset="utf-8"></script>
<script>
    var myVideo = document.getElementById('myVideo')//获取video元素
            ,tol = 0 //总时长
            ;
    myVideo.addEventListener("loadedmetadata", function(){
        tol = myVideo.duration;//获取总时长
    });
    //播放
    function play(){
        myVideo.play();
    }
    //暂停
    function pause(){
        myVideo.pause();
    }
    //播放时间点更新时
    myVideo.addEventListener("timeupdate", function(){
        var currentTime = myVideo.currentTime;//获取当前播放时间
        console.log(currentTime);//在调试器中打印
    });
    //设置播放点
    function playBySeconds(num){
        myVideo.currentTime = num;
    }
    //音量改变时
    myVideo.addEventListener("volumechange", function(){
        var volume = myVideo.volume;//获取当前音量
        console.log(volume);//在调试器中打印
    });
    //设置音量
    function setVol(num){
        myVideo.volume = num;
    }
</script>
</body>
</html>

