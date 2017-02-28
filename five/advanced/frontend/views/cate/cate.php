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
  <div class="panel-head"><strong class="icon-reorder"> 内容列表</strong></div>
  <div class="padding border-bottom">
    <button type="button" class="button border-yellow" onclick="window.location.href='?r=cate/addcate'">
        <span class="icon-plus-square-o"></span>
        添加分类
    </button>
  </div>
  <table class="table table-hover text-center">
    <tr>
      <th width="5%">ID</th>
      <th width="15%">名称</th>
      <th width="15%">图标</th>
      <th width="10%">是否显示</th>
      <th width="15%">操作</th>
    </tr>
      <?php foreach($data as $key=>$val){ ?>
    <tr class="tr_d" parent_id="<?php echo $val['parent_id']?>" node_id="<?php echo $val['type_id']?>" <?php if($val['parent_id']!=0){?> style="display:none" <?php }?> >
      <td><?php echo $val['type_id']?></td>
      <td style="text-align:left; padding-left:20px;" width="20%" >
          <?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$val['flag'])?>
          <a href="javascript:void(0)" onclick="displayData(this);" alt="打开">[+]</a>
          <?php echo $val['type_name']?>
      </td>
        <td><img src="<?php echo $val['type_img']?>" width="50" alt=""/></td>
      <td ids="<?php echo $val['type_id']?>">
          <?php if($val['type_is_show']==1){?>
              <span class="is_show" style="cursor:pointer">显示</span>
          <?php }else{ ?>
              <span class="is_show" style="cursor:pointer">不显示</span>
          <?php }?>
      </td>
      <td>
          <div class="button-group">
              <a class="button border-main" href="<?=Url::toRoute(['cate/cateedit'])?>&tid=<?php echo $val['type_id']?>">
                  <span class="icon-edit"></span> 修改
              </a>
              <a class="button border-red" href="javascript:void(0)" onclick="return del(<?php echo $val['type_id']?>,this)">
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
            url: "?r=cate/detele",
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
    $(document).ready(function(){
        $(".is_show").click(function(){
            var _this=$(this);
            var showhtml=_this.html();
            var tid=_this.parents('td').attr('ids');
            if(showhtml=="显示"){
                var is_show=0;
            }else{
                var is_show=1;
            }
            $.ajax({
                type: "POST",
                url: "?r=cate/showupdate",
                data: {tid:tid,is_show:is_show},
                dataType:"json",
                success: function(msg){
                    if(msg.code==1000){
                        if(is_show==0){
                            _this.html("不显示");
                        }else{
                            _this.html("显示");
                        }
                    }else{
                        alert(msg.arr)
                    }
                }
            });
        })
    });

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