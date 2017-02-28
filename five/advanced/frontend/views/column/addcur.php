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
</head>
<style>
    *{ margin:0; padding:0;}
    #box{ margin:50px auto; width:540px; min-height:400px; background:#FF9}
    #demo{ auto; width:200px; min-height:; background:#CF9}
</style>
<body>
<div class="panel admin-panel">
    <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 添加课程</strong></div>
    <div class="body-content" id="lala">
        <form method="post" class="form-x" action="?r=column/addresources" enctype="multipart/form-data">
            <div class="form-group">
                <div class="label">
                    <label>课程名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="ke" data-validate="required:请输入课程名称"/>
                    <div class="tips"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="label">
                    <label>课程封面图：</label>
                </div>
                <div class="field">
                    <input type="file" class="button bg-blue margin-left" name="img" data-validate="required:请上传课程封面图">
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
                    <label>是否最热：</label>
                </div>
                <div class="field">
                    <div class="button-group radio">

                        <label class="button active">
                            <span class="icon icon-check"></span>
                            <input name="is_heat" value="1" type="radio" checked="checked" style="cursor: pointer">是
                        </label>

                        <label class="button active"><span class="icon icon-times"></span>
                            <input name="is_heat" value="0"  type="radio" checked="checked" style="cursor: pointer">否
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="label">
                    <label>是否最新：</label>
                </div>
                <div class="field">
                    <div class="button-group radio">
                        <label class="button active"  style="cursor: pointer">
                            <span class="icon icon-check"></span>
                            <input name="is_new" value="1" type="radio" checked="checked">是
                        </label>

                        <label class="button active"  style="cursor: pointer">
                            <span class="icon icon-times"></span>
                            <input name="is_new" value="0"  type="radio" checked="checked">否
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="label">
                    <label>是否收费：</label>
                </div>
                <div class="field" id="en">
<!--                    价格-->
                    <div class="button-group radio" id="pr">
                        <label class="button active"  style="cursor: pointer">
                            <span class="icon icon-check"></span>
                            <input name="price" value="1" type="radio" checked="checked">免费
                        </label>
                        <label class="button active"  style="cursor: pointer">
                            <input name="price" type="radio" checked="checked" id="p">付费
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="label">
                    <label>课程描述：</label>
                </div>
                <div class="field">
                    <textarea class="input" name="cur_describe" data-validate="required:请输入课程描述"></textarea>
                    <div class="tips"></div>
                </div>
            </div>

            <div id="k">
                <div class="form-group" id="l">
                <div class="label">
                    <label>添加章节：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="chapter[]" style="width: 500px;float: left" data-validate="required:请输入章节"/>
                    <div class="tips"></div>
                </div>
            </div>
            </div>

            <div class="form-group">
                <div class="label">
                    <label></label>
                </div>
                <div class="field">
                    <button class="button bg-main icon-check-square-o" type="button" id="jie"> 追加章节</button>
                    <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<script>
    //追加章节
    $('#jie').click(function () {
        var str1='<div class="form-group"><div class="label"><label>添加章节：</label></div><div class="field"><input type="text" class="input" name="chapter[]" style="width: 500px;float: left" data-validate="required:请输入章节"/><div class="tips"></div></div></div>';
        //var str1=$('#l').clone();
        $('#k').append(str1);
    })
    $(document).on('click','#p',function () {
         $('#pr').remove();
        /* 显示一个文本框 */
        var str='<input type="text" class="input" name="price" data-validate="required:请输入价格" style="width:100px;"/> <div class="tips"></div> ';
        $('#en').html(str);
    })
</script>
<script>
    $('#as').diyUpload({
        url:'?r=column/uploadimg',
        success:function( data ) {
            console.info( data );
            alert(data['imgpath'])
        },
        error:function( err ) {
            console.info( err );
        },
        buttonText : '选择文件',
        chunked:true,
        // 分片大小
        chunkSize:512 * 1024,
        //最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
        fileNumLimit:50,
        fileSizeLimit:5000000 * 1024,
        fileSingleSizeLimit:5000000 * 1024,
        accept: {

        }
    });
</script>