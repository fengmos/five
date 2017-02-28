<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>网站信息</title>  
    <link rel="stylesheet" href="css/pintuer.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/jquery.js"></script>

    <script src="js/pintuer.js"></script>  
</head>
<body>
<div class="panel admin-panel">
  <div class="panel-head"><strong class="icon-reorder"> 直播列表</strong></div>
  <div class="padding border-bottom">  
  <a class="button border-yellow" href="?r=teacher/ye"><span class="icon-plus-square-o"></span> 添加直播</a>
  </div> 
  <table class="table table-hover text-center">
    <tr>
      <th width="5%">ID</th>     
      <th>直播名称</th>  
      <th>图片</th>
      <th>开始时间</th>  
      <th>结束时间</th>  
      <th>课程</th> 
      <th width="250">操作</th>
    </tr>
   <?php foreach ($rel as $key => $value): ?>
    <tr>
      <td><?php echo $value['id']?></td>
      <td><?php echo $value['title']?></td>      
      <td><a href="#"><img src="<?php echo $value['photo']?>" width='100' height='50'  alt=""></a></td>  
      <td><?php echo $value['begintime']?></td>  
      <td><?php echo $value['endtime']?></td>
      <td><?php echo $value['course']?></td>    
      <td>
      <div class="button-group">
      <a type="button" class="button border-main" href="#"><span class="icon-edit"></span>修改</a>
       <a class="button border-red" href="javascript:void(0)" id="dels" onclick="return del(<?php echo $value['id']?>)"><span class="icon-trash-o"></span> 删除</a>
      </div>
      </td>
    </tr> 
    <?php endforeach ?>
      <tr>
    <td colspan="4" align="center">
      <?php
    echo LinkPager::widget([
        'pagination'=>$pages,
    ]);
    ?>
 
  </table>
</div>
<script>
function del(id){
   
	if(confirm("您确定要删除吗?")){

    $.get('?r=teacher/delete',{'id':id},function(smg){
         if(smg==1){
                $("#dels").parent().parent().parent().remove();
         }
   })	   
	}
}
</script>

</body></html>