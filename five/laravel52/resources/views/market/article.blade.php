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
    </style>
</head>
<body>
<!--精选课程-->

<!--顶部-->
<div class="bar bar-header bar-positive  " >
    <a class="button button-clear icon ion-ios-arrow-left"  onclick="history.go(-1);"></a>
    <h1 class="title">课程列表</h1>

</div>
<!--内容-->
<ion-view title="Home" hide-nav-bar="true">
    <ion-scroll  direction="y" scrollbar-y="false" style="width: 100%; height: 100%">
<section>
    <div class="nxqalbum" style="margin-top: 45px;">
        <img src="http://admin.duzejun.cn/<?=$curone['cur_img']?>" data-original="" class="nxqtopimg sw_loading" />
        <div style="position: absolute;width: 100%;height: 40px;bottom:0;left: 0;background: rgba(0,0,0,0.5)">
            <div class="imgInto" style="color: #f6fdfd">
                <p><?=$curone['cur_name']?></p>
                <p>电话：027-86730762</p>
            </div>
        </div>
    </div>
</section>
<section class="bg1">
    <div class="InsDetails">
        <div class="InsD_title">
            <div class="clearfix">
                <h3 class="f18 lh25"><?=$curone['cur_name']?></h3>
                <a href="javascript:void(0)" class="share lh25"><i></i>分享</a>
            </div>
            <p class="gray2"><?=$curone['cur_describe']?></p>
        </div>
        <div class="InsD_table">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="width: 80px" class="gray2">价格</td>
                    <td class="orange"><i class="f18">&yen;</i><i class="ml5 f22"><?=$curone['cur_price']?></i></td>
                </tr>
                <tr>
                    <td class="gray2" >讲课老师</td>
                    <td class="f14 gray1">
                        <a href="javascript:void(0)/jigou/185785" class="gray1" target="_blank">
                            <?=$curone['teacher_name']?>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td class="gray2">人气</td>
                    <td>
                        <i class="star icon_color"></i>
                        <i class="star icon_color"></i>
                        <i class="star icon_color"></i>
                        <i class="star icon_color"></i>
                        <i class="star icon_color"></i>
                        <span class="red">5.0分</span>
                    </td>

                </tr>
                <tr>
                    <td class="gray2">联系电话</td>
                    <td class="gray1">
                        <a href="javascript:void(0)">
                            <b class="f14">027-86730762</b>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</section>
        <section class="bg1 mt10" style="margin-top: 0;border-top: none">
            <div class="InsDetails3" style="border-top: none;font-size: 15px;background-color: #f9fde1">
                <?=$kejie['cur_name']?>:
                <?php foreach($kejie['pp'] as $key=>$val){?>
                    <dl style="text-align: left">
                        <dt>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;
                            ☟&nbsp;<?=$val['chapter']?>
                        </dt>
                    </dl>
                    <?php foreach($val['pp'] as $k=>$v){?>
                         <dd>
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <?php  if($curone['cur_price']!=0){ ?>
                             <a ids="<?=$v['id']?>" class="bfang">
                                 <?=$v['file_name']?>
                             </a>
                             <?php }else{ ?>
                             <a href="{{URL('bfang')}}?fid=<?=$v['id']?>&cur_id=<?=$curone['cur_id']?>" ids="<?=$v['id']?>" class="bfang">
                                 <?=$v['file_name']?>
                             </a>
                             <?php }?>
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
<div class="botlayer">
    {{--<div class="icophoDiv">--}}
        <?php if($curone['cur_price']!=0){?>
        <div class="bk_fix_bottom">
            <div class="bk_half_area">
                <button class="weui_btn weui_btn_primary"  style="font-size: 15px" id="addCart" onclick="_toCharge(<?=$kejie['cur_id']?>);">加入购物车</button>
            </div>
            <div class="bk_half_area">
                <button class="weui_btn weui_btn_default" style="font-size: 15px" id="look" >查看</button>
            </div>
        </div>
        <?php }else{ ?>
        <div class="bk_fix_bottom" style="text-align: center">
            <div class="bk_half_area">
                <button class="weui_btn weui_btn_primary" onclick="togobegen();" style="background-color: #0063dc">开始学习</button>
            </div>
        </div>
        <?php }?>
    {{--</div>--}}
    <div class="clear"></div>
</div>
<!-- 底部-->
{{--@include('master')--}}
<script src="{{asset('js/swipe.min.js')}}" charset="utf-8"></script>
<script src="{{asset('js/book.js')}}" charset="utf-8"></script>
<script type="text/javascript" src="{{asset('style/layer/layer.js')}}"></script>
<script>
$(function(){

    var id = "<?=$kejie['cur_id']?>";
    $.ajax({
   type: "GET",
   url: "{{URL('select_cart')}}",
   data: {id:id},
   success: function(msg){
       if(msg == 1)
       {
            $("#addCart").html('您已加入购物车');
            $("#addCart").css('background','#d0d0d0');
            $("#addCart").css('color','#000');
            $("#addCart").attr("disabled", true);
       }else
       {
          $("#addCart").attr("disabled", false);
       }
   }
});
    $("#look").click(function(){
        location.href="{{URL('mycart')}}";
    })
})
    function togobegen(){
        var bfang=$('.bfang').attr('ids');
        var cur_id="<?=$curone['cur_id']?>";
//        alert(bfang)
       location.href = '/bfang?fid='+bfang+'&cur_id='+cur_id;
    }

    
    //加入购物车
    function _toCharge(id){
        var user_session = "<?=$session->get('nickname');?>";
          if(user_session == '')
          {
            alert('请登录');
            location.href="{{URL('login')}}";
            return false;
          }else
          {
            
            $.post("{{URL('addcart')}}",{'_token':'{{csrf_token()}}','id':id},function(data){
                if(data.status == 0){
    //                location.href = location.href;
                     $("#addCart").html('已加入购物车');
                     $("#addCart").css('background','red');
                     $("#addCart").css('color','#000');
                     $("#addCart").attr("disabled", true);
                }
            });
          }
     
    }
    //查看购物车
    function _onDelete(){
        location.href = '/mycart';
    }
</script>
</body>
</html>

