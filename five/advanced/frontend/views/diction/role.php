<?php    use yii\helpers\Url;?>
<!DOCTYPE html>
<html lang="zh-cn">
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
<div class="panel admin-panel">
  <div class="panel-head"><strong class="icon-reorder"> 角色列表</strong></div>
  <div class="padding border-bottom">
    <button type="button" class="button border-yellow" onclick="window.location.href='?r=diction/addrole'">
        <span class="icon-plus-square-o"></span>
        添加角色
    </button>
  </div>
  <table class="table table-hover text-center">
    <tr>
      <th width="5%">ID</th>
      <th width="15%">角色名称</th>
      <th width="10%">角色符权</th>
      <th width="10%">操作</th>
    </tr>
    <tr>
        <?php foreach ($role as $k=>$v):?>
      <tr>
          <td><?=$v['role_id']?></td>
          <td><?=$v['role_name']?></td>
          <td>
              <div class="table-fun">
                  <a href="?r=diction/rolepower&id=<?=$v['role_id']?>">附权</a>
              </div>
          </td>
          <td>
          <div class="button-group">
              <a class="button border-main" href="<?=Url::toRoute(['cate/cateedit'])?>&id=<?=$v['role_id']?>">
                  <span class="icon-edit"></span> 修改
              </a>
              <a class="button border-red" href="javascript:void(0)" onclick="return del(<?=$v['role_id']?>,this)">
                  <span class="icon-trash-o"></span> 删除
              </a>
          </div>
      </td>
    </tr>
      <?php endforeach;?>
  </table>
</div>
<script type="text/javascript">
function del(id,obj){
    var _this=$(obj);
	if(confirm("您确定要删除吗?")){
        $.ajax({
            type: "POST",
            url: "?r=diction/roledetele",
            data: {id:id},
            dataType:"json",
            success: function(msg){
                //alert(msg)
                if(msg.code==1000){
                    _this.parents('tr').remove();
                }else{
                    alert(msg.arr);
                }
            }
        });
	}
}
</script>
</body>
</html>