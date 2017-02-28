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
        #page ul li {
            float: left;}

    </style>
    {{--<link rel="stylesheet" href="http://g.alicdn.com/de/prismplayer/1.4.7/skins/default/index-min.css" />--}}
    {{--<link rel="stylesheet" href="http://g.alicdn.com/de/prismplayer/1.4.7/skins/default/index.css" />--}}
    {{--<script type="text/javascript" src="http://g.alicdn.com/de/prismplayer/1.4.7/prism.js"></script>--}}
    <link rel="stylesheet" href="http://g.alicdn.com/de/prismplayer/1.4.7/skins/default/index-min.css" />
    <script type="text/javascript" src="http://g.alicdn.com/de/prismplayer/1.4.7/prism-h5-min.js"></script>
</head>
<body>
<!--精选课程-->

<!--顶部-->
<div class="bar bar-header bar-positive  " >
    <a class="button button-clear icon ion-ios-arrow-left" onclick="history.go(-1);"></a>
    <h1 class="title">{{$data['title']}}</h1>

</div>
<!--内容-->

<ion-view title="Home" hide-nav-bar="true">
    <ion-scroll  direction="y" scrollbar-y="false" style="width: 100%; height: 100%">
        <div style="width:70px;height:70px;"></div>
        <div class="NewsList">
            <div id='J_prismPlayer' class='prism-player'></div>
        </div>
    </ion-scroll>
</ion-view>

<!-- 底部-->
@include('master')
{{--http://live.kjschool.net/app-name/StreamName.m3u8--}}
{{--<script type="text/javascript" src="http://g.alicdn.com/de/prismplayer/1.4.7/prism-h5-min.js"></script>--}}
<script>
    var player = new prismplayer({
        id: "J_prismPlayer", // 容器id
        source: "{{$data['url']}}",  // 视频url 支持互联网可直接访问的视频地址
        autoplay: true,      // 自动播放
        width: "100%",       // 播放器宽度
        height: "400px"      // 播放器高度
    });
</script>
</body>
</html>