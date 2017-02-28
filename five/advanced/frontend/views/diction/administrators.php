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
    <div class="panel-head"><strong class="icon-reorder"> 管理员列表</strong></div>
    <div class="padding border-bottom">
        <button type="button" class="button border-yellow" onclick="window.location.href='?r=diction/addadmin'">
            <span class="icon-plus-square-o"></span>
            添加管理员
        </button>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th width="5%">ID</th>
            <th width="15%">名称</th>
            <th width="15%">头像</th>
            <th width="10%">电话</th>
            <th width="10%">最后登录时间</th>
            <th width="10%">最后登录IP</th>
            <th width="20%">操作</th>
        </tr>
        <?php foreach($data as $key=>$val){?>
        <tr>
            <td><?=$val['admin_id']?></td>
            <td><?=$val['admin_name']?></td>
            <td><img src="<?=$val['admin_img']?>" width="50px" alt=""/></td>
            <td><?=$val['admin_tel']?></td>
            <td><?php echo date('Y-m-d H:i:s',$val['admin_time'])?></td>
            <td><?=$val['admin_ip']?></td>
            <td>
                <div class="button-group">
                    <a class="button border-main" href="<?=Url::toRoute(['diction/adminupdate'])?>&aid=<?php echo $val['admin_id']?>">
                        <span class="icon-edit"></span> 修改
                    </a>
                    <a class="button border-red" href="javascript:void(0)" onclick="return del(<?php echo $val['admin_id']?>,this)">
                        <span class="icon-trash-o"></span> 删除
                    </a>
                </div>
            </td>
        </tr>
        <?php }?>
    </table>
</div>
<script type="text/javascript">
    function del(id,obj){
        var _this=$(obj);
        if(confirm("您确定要删除吗?")){
            $.ajax({
                type: "POST",
                url: "?r=diction/admindetele",
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