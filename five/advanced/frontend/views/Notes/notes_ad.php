<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>添加课程</title>
    <link rel="stylesheet" href="css/pintuer.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/jquery.js"></script>
    <script src="js/pintuer.js"></script>

    <script type="text/javascript" src="diyUpload/js/webuploader.html5only.min.js"></script>
    <script type="text/javascript" src="diyUpload/js/diyUpload.js"></script>
<!--百度编辑器的-->
    <script type="text/javascript" charset="utf-8" src="bj/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="bj/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="bj/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript">
    var ue = UE.getEditor('myEditor')
    </script>
</head>
<style>
    *{ margin:0; padding:0;}
    #box{ margin:50px auto; width:540px; min-height:400px; background:#FF9}
    #demo{ auto; width:200px; min-height:; background:#CF9}
    div{
        width:100%;
    }
</style>
<body>
<div class="panel admin-panel">
    <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 添加课程</strong></div>
    <div class="body-content" id="lala">
        <form method="post" class="form-x" action="?r=notes/notes_ads" enctype="multipart/form-data">
            <div class="form-group">
                <div class="label">
                    <label>笔记名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="notes_tittle" data-validate="required:请输入笔记名称"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>所属分类：</label>
                </div>
                <div class="field">
                    <select name="type" class="input w50" data-validate="required:请选择分类">
                        <?php foreach($type as $key=>$val){?>
                            <option value="<?php echo $val['type_id']?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;',$val['flag'])?>
                                <?php echo $val['type_name']?></option>
                        <?php }?>
                    </select>
                    <div class="tips"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="label">
                    <label>讲师：</label>
                </div>
                <div class="field">
                    <select name="teacher_id" class="input w50" data-validate="required:请选择老师">
                        <?php foreach($teacher as $key=>$val){?>
                            <option value="<?php echo $val['teacher_id']?>"><?php echo $val['teacher_name']?></option>
                        <?php }?>
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>笔记描述：</label>
                </div>
                <div class="field">
                    <textarea class="input"  id="myEditor" name="notes_assess" data-validate="required:请输入笔记描述"></textarea>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>是否最热：</label>
                </div>
                <div class="field">
                    <div class="button-group radio">

                        <label class="button active">
                            <span class="icon icon-check"></span>
                            <input name="notes_hot" value="1" type="radio" checked="checked" style="cursor: pointer">是
                        </label>

                        <label class="button active"><span class="icon icon-times"></span>
                            <input name="notes_hot" value="0"  type="radio" checked="checked" style="cursor: pointer">否
                        </label>
                    </div>
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
</body>
</html>
