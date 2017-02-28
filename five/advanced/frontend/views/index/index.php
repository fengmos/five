<?php
 use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>后台管理中心</title>
    <link rel="stylesheet" href="<?=Yii::$app->request->baseUrl?>/css/pintuer.css">
    <link rel="stylesheet" href="<?=Yii::$app->request->baseUrl?>/css/admin.css">
    <script src="<?=Yii::$app->request->baseUrl?>/js/jquery.js"></script>
</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
  <div class="logo margin-big-left fadein-top">
    <h1><img src="images/y.jpg" class="radius-circle rotate-hover" height="50" alt="" />后台管理中心</h1>
  </div>
  <div class="head-l"><a class="button button-little bg-green" href="" target="_blank"><span class="icon-home"></span> 前台首页</a> &nbsp;&nbsp;<a href="##" class="button button-little bg-blue"><span class="icon-wrench"></span> 清除缓存</a> &nbsp;&nbsp;<a class="button button-little bg-red" href="<?=Url::toRoute(['login/login_out'])?>"><span class="icon-power-off"></span> 退出登录</a> </div>
</div>

<div class="leftnav">
  <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>

    <?php
    $session = \Yii::$app->session;
    //取出存入的session值
    $powers = $session->get('power');
    $powe=unserialize($powers);
    foreach ($powe as $key=>$val):?>
            <?php if($val['pid']==0){ ?>
                <h2><span class="icon-check-square-o"></span><?php echo $val['power_name'] ?></h2>
            <?php } ?>
                <ul style="display:none">
                    <?php
                    if(!empty($val['children'])){
                        foreach($val['children'] as $k=>$v){ ?>
                            <li><a href="?r=<?php echo $v['controller']?>/<?php echo $v['action']?>" target="right"><span class="icon-caret-right"></span><?php echo $v['power_name']  ?></a></li>
                        <?php }?>
                    <?php }?>
                </ul>
    <?php endforeach;?>
</div>

<script type="text/javascript">
$(function(){
  $(".leftnav h2").click(function(){
    $(this).next().slideToggle(200);
    $(this).toggleClass("on");
  })
  $(".leftnav ul li a").click(function(){
      $("#a_leader_txt").text($(this).text());
      $(".leftnav ul li a").removeClass("on");
    $(this).addClass("on");
  })
});
</script>
<ul class="bread">
  <li><a href="<?=Url::toRoute(['index/index'])?>" target="right" class="icon-home"> 首页</a></li>
  <li><a href="##" id="a_leader_txt">网站信息</a></li>
  <li><b>当前语言：</b><span style="color:red;">中文</php></span>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;切换语言：<a href="##">中文</a> &nbsp;&nbsp;<a href="##">英文</a> </li>
</ul>
<div class="admin">
  <iframe scrolling="auto" rameborder="0" src="<?=Url::toRoute(['index/info'])?>" name="right" width="100%" height="100%"></iframe>
</div>
<div style="text-align:center;">
<p>来源:<a href="http://www.mycodes.net/" target="_blank">源码之家</a></p>
</div>
</body>
</html>