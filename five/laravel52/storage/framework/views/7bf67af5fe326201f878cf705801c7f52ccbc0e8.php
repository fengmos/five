
<html ng-app="ionicApp">
  <head>
        <meta charset="UTF-8">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title>首页</title>
    <link href="<?php echo e(asset('style/css/ionic.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/share.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/index.css')); ?>" rel="stylesheet"/>
     <script src="<?php echo e(asset('style/js/ionic.bundle.min.js')); ?>"></script>
     <script src="<?php echo e(asset('js/jquery-1.8.0.min.js')); ?>"></script>
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
    <style type="text/css">
    .slider {
      height: 24%;
    }
   .slider-slide {
      color: #000; 
      text-align: center; 
      font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; font-weight: 300; }
    .a {
      background-image: url(style/img/lun1.jpg);
      background-size: 100% 100% ;
    }

    .b {
      background-image: url(style/img/lun2.jpg);
      background-size: 100% 100% ;
    }

    .c {
      background-image: url(style/img/lun3.jpg);
      background-size: 100% 100% ;
    }
        .box{ 
      height:100%; 
    } 
    .box h3{
      position:relative; top:50%; transform:translateY(-50%); 
    }
    </style>
  </head>
<body>
<!--顶部-->
 <div class="bar bar-header bar-positive item-input-inset ">
            <a class=" button button-clear icon ion-location"></a><span id="city"></span>&nbsp;
                <label class="item-input-wrapper ">
                    
                    <input type="search" id="search" placeholder="最热/类型/关键字">
                    <a class="icon ion-ios-search  placeholder-icon" id="sea" ></a>
                </label>
                
        
         
    </div>
  <div id="div1">
<!--内容-->
 <ion-view title="Home" hide-nav-bar="true">
  <ion-scroll  direction="y" scrollbar-y="false" style="width: 100%; height: 100%">
<div style=" margin-bottom:110px;">
   
    <div>
    <table width="100%" border="1" cellpadding="1" cellspacing="1" style="margin-top:50px;">
    <tr>
       <td >
         <a href="<?php echo e(URL('course')); ?>" style="color:black; text-decoration:none;">
            <div style="margin:10px auto;width:40px;height:40px;border-radius:40px;overflow:hidden;">
                <img src="<?php echo e(asset('style/img/01.png')); ?>" style="margin:0;width:100%;height:100%;">
            </div>
            <p style="font-size:11px; text-align:center" >精选课程</p>
         </a>
       </td>
       <td >
       <a href="<?php echo e(URL('selected')); ?>" style="color:black; text-decoration:none;">
            <div style="margin:10px auto;width:40px;height:40px;border-radius:40px;overflow:hidden;">
                <img src="<?php echo e(asset('style/img/02.png')); ?>" style="margin:0;width:100%;height:100%;">
            </div>
            <p style="font-size:11px; text-align:center">免费课程</p>
          </a> 
       </td>
      <td >
      <a href="<?php echo e(URL('recommend')); ?>" style="color:black; text-decoration:none;">
            <div style="margin:10px auto;width:40px;height:40px;border-radius:40px;overflow:hidden;">
                <img src="<?php echo e(asset('style/img/03.png')); ?>" style="margin:0;width:100%;height:100%;">
            </div>
            <p style="font-size:11px; text-align:center">收费课程</p>
        </a>
      </td>
      <td>
      <a href="<?php echo e(URL('question')); ?>" style="color:black; text-decoration:none;">
            <div style="margin:10px auto;width:40px;height:40px;border-radius:40px;overflow:hidden;">
                <img src="<?php echo e(asset('style/img/05.jpg')); ?>" style="margin:0;width:100%;height:100%;">
            </div>
            <p style="font-size:11px; text-align:center">问答</p>
        </a> 
      </td>
      <td>
      <a href="<?php echo e(URL('notes')); ?>" style="color:black; text-decoration:none;">
            <div style="margin:10px auto;width:40px;height:40px;border-radius:40px;overflow:hidden;">
                <img src="<?php echo e(asset('style/img/06.jpg')); ?>" style="margin:0;width:100%;height:100%;">
            </div>
            <p style="font-size:11px; text-align:center">笔记</p>
        </a> 
      </td>
       <td>
      <a href="<?php echo e(URL('morer')); ?>" style="color:black; text-decoration:none;">
            <div style="margin:10px auto;width:40px;height:40px;border-radius:40px;overflow:hidden;">
                <img src="<?php echo e(asset('style/img/04.png')); ?>" style="margin:0;width:100%;height:100%;">
            </div>
            <p style="font-size:11px; text-align:center">更多</p>
        </a> 
      </td>
      </tr>
     
     
    </table>   
      
       <div ng-app="ionicApp" animation="slide-left-right-ios7" ng-controller="SlideController">

  <ion-slide-box active-slide="myActiveSlide"  does-continue="true" slide-interval='4000' slide-page="true">
    <ion-slide>
      <div class="box a"><h3></h3></div>
    </ion-slide>
    <ion-slide>
      <div class="box b"><h3></h3></div>
    </ion-slide>
    <ion-slide>
      <div class="box c"><h3></h3></div>
    </ion-slide>
    
  </ion-slide-box>
    </div>

    <p></p>

        <div>
            <p style="background-color:#99BBFF  ">精选课程</p>
            <?php foreach ($res as $key => $value) {?>


            <div class="NewsList">
                <ul class="clearfix classul">
                    <li>
                        <div class="bord">
                            <div class="lt">
                                <a href="<?php echo e(url('cont')); ?>?cur_id=<?php echo $value['cur_id']?>" title=""><img src="http://admin.duzejun.cn/<?php echo $value['cur_img'] ?>" height="50px;" width='50px;' alt=""/></a>
                            </div>
                            <div class="rt">
                                <a href="#" title="">
                                    <div class="rt1">
                                        <h3><?php echo $value['cur_name'] ?></h3>
                                        <p><?php echo mb_substr($value['cur_describe'],0,20,"UTF-8") ?>......</p>

                                    </div>
                                </a>
                                <?php if ($value['cur_price']==0){?>
                                <div class="rt2">
                                    <p class="green"><i class="f15 mr5">&yen;</i><i class="f20">免费</i></p>

                                </div>
                                <?php }else{ ?>
                                <div class="rt2">
                                    <p class="orange"><i class="f15 mr5">&yen;</i><i class="f20"><?php echo $value['cur_price']?></i></p>

                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <?php }?>
        </div>

        <div>
         <p style="background-color:#99BBFF  ">免费课程</p>
        <?php foreach ($re as $key => $value) {?>
          
        
              <div class="NewsList">
                 <ul class="clearfix classul">    
                     <li>
                    <div class="bord">
                        <div class="lt">
                            <a href="<?php echo e(url('cont')); ?>?cur_id=<?php echo $value['cur_id']?>" title=""><img src="http://admin.duzejun.cn/<?php echo $value['cur_img'] ?>" height="50px;" width='50px;' alt=""/></a>
                        </div>
                        <div class="rt">
                            <a href="#" title="">
                                <div class="rt1">
                                    <h3><?php echo $value['cur_name'] ?></h3>
                                    <p><?php echo mb_substr($value['cur_describe'],0,20,"UTF-8") ?>......</p>
                                   <!--  <p>武汉武昌区中北路 | 详细地图</p> -->
                                    <!-- <a href="javascript:void(0)027-86730762"><p>027-86730762</p></a> -->
                               </div>
                            </a>
                           <?php if ($value['cur_price']==0){?>
                            <div class="rt2">
                                 <p class="green"><i class="f15 mr5">&yen;</i><i class="f20">免费</i></p>
                             
                           </div>
                           <?php }else{ ?>
                              <div class="rt2">
                                <p class="orange"><i class="f15 mr5">&yen;</i><i class="f20"><?php echo $value['cur_price']?></i></p>
                             
                           </div>
                          <?php }?>
                        </div>
                      </div>
                   </li>
                 </ul>
                 
                 
  </div>
  <?php }?>
      </div>

        <div>
            <p style="background-color:#99BBFF  ">付费课程</p>
            <?php foreach ($str as $key => $value) {?>
            <div class="NewsList">
                <ul class="clearfix classul">
                    <li>
                        <div class="bord">
                            <div class="lt">
                                <a href="<?php echo e(url('cont')); ?>?cur_id=<?php echo $value['cur_id']?>" title=""><img src="http://admin.duzejun.cn/<?php echo $value['cur_img'] ?>" height="50px;" width='50px;' alt=""/></a>
                            </div>
                            <div class="rt">
                                <a href="#" title="">
                                    <div class="rt1">
                                        <h3><?php echo $value['cur_name'] ?></h3>
                                        <p><?php echo mb_substr($value['cur_describe'],0,20,"UTF-8") ?>......</p>
                                        <!--  <p>武汉武昌区中北路 | 详细地图</p> -->
                                        <!-- <a href="javascript:void(0)027-86730762"><p>027-86730762</p></a> -->
                                    </div>
                                </a>
                                <?php if ($value['cur_price']==0){?>
                                <div class="rt2">
                                    <p class="green"><i class="f15 mr5">&yen;</i><i class="f20"><span style='color:green'>免费</span></i></p>

                                </div>
                                <?php }else{ ?>
                                <div class="rt2">
                                    <p class="orange"><i class="f15 mr5">&yen;</i><i class="f20"><?php echo $value['cur_price']?></i></p>

                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </li>
                </ul>


            </div>
            <?php }?>
        </div>

      
    </div>

    </div>
    <div style="height:50px;width:100%;clear:all"></div>
     </ion-scroll>
    </ion-view>
   </div>  
    <?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </body>
</html>
<script>
 $(function(){
     $.ajax({
   type: "GET",
   url: "<?php echo e(URL('city_info')); ?>",
  // data: "name=John&location=Boston",
   dataType:"json",
   success: function(msg){
     $("#city").html(msg.result.att);
   }
  });
   //搜索
  $("#sea").click(function(){
    var search=$('#search').val();
    //alert(search);
    $.get("<?php echo e(URL('search')); ?>",{"search":search},function(msg){
        var str='';
      console.log(msg);
         for(var i=0;i<msg.length;i++){
              str+="<div class='NewsList'><ul class='clearfix classul'><li><div class='bord'><div class='lt'><a href='<?php echo e(URL('cont')); ?>?cur_id="+msg[i]['cur_id']+"'><img src=http://admin.duzejun.cn/"+msg[i]['cur_img']+" height='50px;' width='50px;' /></a></div><div class='rt'><a href='#' ><div class='rt1'><h3>"+msg[i]['cur_name']+"</h3><p>"+msg[i]['cur_describe'].substr(0,20)+"......</p></div></a><div class='rt2'><p class='orange'><i class='f15 mr5'>&yen;</i><i class='f20'>"+msg[i]['cur_price']+"</i></p></div></div></div></li></ul></div>";
       }
        $("#div1").html(str);
    },'json')
   })
 })
</script>
