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
<div class="panel admin-panel margin-top">
    <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>添加分类</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="?r=cate/cateedit" enctype="multipart/form-data">
            <input type="hidden" name="tid" value="<?php echo $one['type_id']?>">
            <div class="form-group">
                <div class="label">
                    <label>分类标题：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="type_name" value="<?php echo $one['type_name']?>" data-validate="required:请输入分类标题"  />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>上级分类：</label>
                </div>
                <div class="field">
                    <select name="parent_id" class="input w50">
                        <option value="0">顶级节点</option>
                        <?php foreach($type as $key=>$val){?>
                            <?php if($val['type_id']==$one['parent_id']){?>
                                <option value="<?php echo $val['type_id']?>" selected="selected"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;',$val['flag'])?>
                                    <?php echo $val['type_name']?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $val['type_id']?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;',$val['flag'])?>
                                    <?php echo $val['type_name']?></option>
                            <?php }?>
                        <?php }?>
                    </select>
                    <div class="tips">默认为一级分类</div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>分类图标：</label>
                </div>
                <div class="field">
                    <div>
                        <input type="file" name="type_img[]"/>
                        <div class="tips"></div>
                    </div>
                    <div>
                        <img src="<?php echo $one['type_img']?>" width="50" alt=""/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>是否显示：</label>
                </div>
                <div class="field">
                    <input type="radio" class="radio" name="type_is_show" value="1" checked="checked"/>显示&nbsp;&nbsp;&nbsp;
                    <input type="radio" class="radio" name="type_is_show" value="0"/>不显示&nbsp;&nbsp;&nbsp;
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>排序：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="sort" value="<?php echo $one['type_sort']?>"  data-validate="required:请输入分类标题,number:排序必须为数字" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label></label>
                </div>
                <div class="field">
                    <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body></html>