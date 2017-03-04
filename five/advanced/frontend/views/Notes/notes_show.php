<!DOCTYPE html>
<html lang="zh-cn" id="b">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title></title>
    <link rel="stylesheet" href="css/pintuer.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/jquery.js"></script>
    <script src="js/pintuer.js"></script>
</head>
<body>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 课程资源列表</strong></div>
    <div class="padding border-bottom">
        <button type="button" class="button border-yellow" onclick="window.location.href='?r=notes/notes_ad'">
            <span class="icon-plus-square-o"></span>
            添加笔记
        </button>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th width="20%">笔记标题</th>
            <th width="20%">分类</th>
            <th width="20%">老师</th>
            <th width="20%">内容</th>
            <th width="20%">操作</th>
        </tr>
        <?php foreach($userInfo as $key=>$v):?>
        <tr zid="<?php echo $v['notes_id']?>">
            <td><?php echo $v['notes_tittle']?></td>
            <td><?php echo $v['type_name']?></td>
            <td><?php echo $v['teacher_name']?></td>
            <td><?php echo $v['notes_assess']?></td>
            <td>
                <div class="button-group">
                    <a class="button border-red" name="del" href="javascript:void(0)"> 删除</a>
                </div>
            </td>
        </tr>
        <tr>
            <?php endforeach;?>
        <tr align="center">
            <td colspan="5"><?php
                echo LinkPager::widget([
                    'pagination' => $page,

                    'nextPageLabel'=>'下一页'

                ]);?></td>
        </tr>
    </table>
</div>
</body>
</html>
<script>
    $(function(){
      $("a[name='del']").click(function(){
         var notes_id=$(this).parents('tr').attr('zid');
          $.ajax({
              url:"?r=notes/notes_del",
              type:"POST",
              data:{notes_id:notes_id},
              success:function(data){
              if(data==1)
              {
                  location.href="?r=notes/notes_show";
              }
              }
          });
      });
    });
</script>