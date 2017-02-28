<html ng-app="ionicApp">
<head>
        <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title>我的购买</title>

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
     <h1 class="title">我的收藏</h1>
   
   </div>
<!--内容-->   

   <ion-view title="Home" hide-nav-bar="true">
   <ion-scroll  direction="y" scrollbar-y="false" style="width: 100%; height: 100%">
   
             <div style="width:70px;height:70px;"></div>
              <div class="NewsList">
              @foreach($curs as $key => $val)
        <ul class="clearfix classul">    
                     <li>
                    <div class="bord">
                        <div class="lt">
                            <a href="{{URL('cont')}}?cur_id={{$val['cur_id']}}" title=""><img src="http://admin.duzejun.cn{{$val['cur_img']}}" height="50px;" width='50px;' alt=""/></a>
                        </div>
                        <div class="rt">
                            <a href="#" title="">
                                <div class="rt1">
                                    <h3>{{$val['cur_name']}}</h3>
                                    <a href="javascript:void(0)027-86730762"><p>{{$val['cur_addtime']}}</p></a>
                               </div>
                            </a>
                            <div class="rt2">
                                <p class="orange"><i class="f15 mr5">&yen;</i><i class="f20"><?php if($val['cur_price']==0){ echo "<span style='color:green;'>免费</span>";}else{echo $val['cur_price'];}?></i></p>
                                <p style="margin-top:10px;" id="{{$val['cur_id']}}"><a href="javascript:void(0)" id="del">删除</a></p>
                           </div>
                        </div>
                    </div>

            </li>
                 </ul>
                 
      @endforeach           
  </div>
    
     </ion-scroll>
    </ion-view>
    <!-- 底部-->
     @include('master')


</body> 
</html>
<script type="text/javascript" src="{{asset('style/js/jquery.js')}}"></script>
<script type="text/javascript">
   $(document).on("click","#del",function(){
            var _this = $(this);
             var id = $(this).parent().attr('id');
             $.ajax({
               type: "GET",
               url: "{{URL('del_collect')}}",
               data: {id:id},
               success: function(msg){
                   if(msg!=1)
                   {
                      _this.parents('ul').remove();
                   }
               }
            });
        });
</script>

