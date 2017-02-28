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
    <div class="panel-head"><strong class="icon-reorder"> 角色符权</strong></div>
    <div class="padding border-bottom">
        <div class="public-content-header">
            <h3>角色附权</h3>
        </div>
        <div class="public-content-cont">
            <form action="?r=diction/rolepower"  method="post" onsubmit="return sub()">
            <input type="hidden" name="role_id" value="<?php echo $role['role_id'] ?>">
            <div class="form-group">
                <label for="">角色</label>
                <input class="form-input-txt" type="text" disabled  value="<?php echo $role['role_name']?>"/>
                <span id="s_name"></span>
            </div>
            <br class="form-group">
            <label for="">权限</label>
                <br/>
            <?php foreach ($power as $k=>$v):?>
<!--                --><?php
//                if($v['pid']==0){
//                    ?>
                <!--                    <input type="checkbox" name="power[]" class="power" value="--><?php //echo $v['power_id']?><!--"/>--><?php //echo $v['power_name']?>
                <!--                --><?php
//                }
//                ?>
                <!--                --><?php
//                if(!empty($v['children'])){
//                    ?>
                <!--                    --><?php //foreach ($v['children'] as $kay=>$val):?>
                <!--                        <input type="checkbox" name="power[]" id="power" value="--><?php //echo $val['power_id']?><!--"/>--><?php //echo $val['power_name']?>
                <!--                    --><?php //endforeach;?>
                <!--                    <br>-->
                <!--                --><?php
//                }
//                ?>

                    <?php if($v['pp']==1){?>
                        <?php echo str_repeat("━&nbsp;&nbsp;",$v['flag']);?>
                        <input type="checkbox" name="power[]" value="<?php echo $v['power_id']?>" checked/><?php echo $v['power_name']?>
                    <?php }else{ ?>
                    <?php echo str_repeat("━&nbsp;&nbsp;",$v['flag']);?>
                    <input type="checkbox" name="power[]" value="<?php echo $v['power_id']?>"/><?php echo $v['power_name']?>
                    <?php }?>
                       <br/>
            <?php endforeach;?>
            <span id="s_name"></span>
        <div class="form-group" style="margin-left:150px;">
            <input type="submit" class="sub-btn" value="附 权" />
            <input type="reset" class="sub-btn" value="重 置" />
        </div>
        </form>
    </div>
</div>
</div>
</body>
</html>