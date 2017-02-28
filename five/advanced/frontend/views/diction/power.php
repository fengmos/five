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
    <div class="panel-head"><strong class="icon-reorder"> 节点列表</strong></div>
    <div class="padding border-bottom">
        <button type="button" class="button border-yellow" onclick="window.location.href='?r=diction/addpower'">
            <span class="icon-plus-square-o"></span>
            添加节点
        </button>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th width="10%">编号</th>
            <th width="30%">节点名称</th>
            <th width="10%">控制器</th>
            <th width="10%">方法</th>
            <th width="15%">操作</th>
        </tr>
        <?php foreach ($power as $k=>$v):?>
        <tr class="tr_d" parent_id="<?php echo $v['pid']?>" node_id="<?php echo $v['power_id']?>" <?php if($v['pid']!=0){?> style="display:none" <?php }?> >
            <td><?=$v['power_id']?></td>
            <td style="text-align:left; padding-left:20px;" width="20%" >
                <?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$v['flag']);?>
                <a href="javascript:void(0)" onclick="displayData(this);" alt="打开">[+]</a>
                <?php echo $v['power_name']?>
            </td>
            <td><?=$v['controller']?></td>
            <td><?=$v['action']?></td>
            <td>
            <td>
                <div class="button-group">
                    <a class="button border-main" href="<?=Url::toRoute(['diction/powerupdate'])?>&id=<?php echo $v['power_id']?>">
                        <span class="icon-edit"></span> 修改
                    </a>
                    <a class="button border-red" href="javascript:void(0)" onclick="return del(<?php echo $v['power_id']?>,this)">
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
                url: "?r=diction/powerdetele",
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
  ///////////////////////////////////
    function displayData(_self)
    {
        if(_self.alt == "关闭")
        {
            jqshow($(_self).parent().parent().attr('node_id'), 'hide');
            $(_self).html('[+]');
            _self.alt = '打开';
        }
        else
        {
            jqshow($(_self).parent().parent().attr('node_id'), 'show');
            $(_self).html('[-]');
            _self.alt = '关闭';
        }
    }
    function jqshow(id,isshow) {
        var obj = $("table tr[parent_id='"+id+"']");
        if (obj.length>0)
        {
            obj.each(function(i) {
                jqshow($(this).attr('node_id'), isshow);
            });
            if (isshow=='hide')
            {
                obj.hide();
            }
            else
            {
                obj.show();
            }
        }
    }
</script>
</body>
</html>