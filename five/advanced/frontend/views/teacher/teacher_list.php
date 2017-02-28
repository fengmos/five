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
  <div class="panel-head"><strong class="icon-reorder"> 教师列表</strong></div>
  <div class="padding border-bottom">  
  <a class="button border-yellow" href="?r=teacher/teacher_add_html"><span class="icon-plus-square-o"></span> 添加教师</a>
  </div> 
  <table class="table table-hover text-center">
    <tr>
      <th>讲师名称</th>  
      <th>个人头像</th>
      <th>任职时长</th>
      <th>直播地址</th>
      <th>讲师简介</th>  
      <th width="250">操作</th>
    </tr>
   <?php foreach ($info as $key => $value): ?>
    <tr>
      <td><?php echo $value['teacher_name']?></td> 
      <td><a href="#"><img src="upload/<?php echo $value['teacher_img']?>" width='100' height='50'  alt=""></a></td>  
      <td><?php echo $value['teacher_years']?></td>  
      <td><?php echo $value['teacher_address']?></td>
      <td style="width:40%;"><?php echo $value['teacher_desc']?></td>
      <td>
      <div class="button-group" id="<?php echo $value['teacher_id']?>">
         <a class="button border-main" href="javascript:void(0)" ><span class="icon-edit"></span> 查看</a>
       <a class="button border-red" href="javascript:void(0)" id="dels"><span class="icon-trash-o"></span> 删除</a>
      </div>
      </td>
    </tr> 
    <?php endforeach ?>
      <tr>
    <td colspan="4" align="center">
   
  </table>
</div>
<script>
     $(document).on("click","#dels",function(){
       if(confirm("您确定要删除吗?")){
           var _this = $(this);
           var id = _this.parent().attr('id');
           $.ajax({
           type: "GET",
           url: "?r=teacher/delete_teacher",
           data: {id:id},
           success: function(msg){
               if(msg==1)
               {
                 _this.parent().parent().parent().remove();
               }
           }
        })
      }
    })
</script>

</body></html>