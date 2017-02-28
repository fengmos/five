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
    <title>添加资源</title>
    <link rel="stylesheet" href="css/pintuer.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/jquery.js"></script>
    <script src="js/pintuer.js"></script>

    <link rel="stylesheet" type="text/css" href="diyUpload/css/webuploader.css">
    <link rel="stylesheet" type="text/css" href="diyUpload/css/diyUpload.css">
    <script type="text/javascript" src="diyUpload/js/webuploader.html5only.min.js"></script>
    <script type="text/javascript" src="diyUpload/js/diyUpload.js"></script>
</head>
<style>
    *{ margin:0; padding:0;}
    #box{ margin:50px auto; width:540px; min-height:400px; background:#FF9}
    #demo{ margin:50px auto; width:540px; min-height:500px; background:#CF9}
</style>
<body>
<div class="panel admin-panel">
    <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 添加资源</strong></div>
    <div class="body-content" id="lala">
        <form method="post" class="form-x" action="?r=column/add" enctype="multipart/form-data">
            <div class="form-group">
                <div class="label">
                    <label>章节名称：</label>
                </div>
                <div class="field">
                    <select name="type" class="input w50" data-validate="required:请选择分类">
                        <?php foreach ($ziyuan as $k=>$v):?>
                            <option value="<?php echo $v['id']?>"><?php echo $v['chapter']?></option>
                        <?php endforeach;?>
                    </select>
                    <div class="tips"></div>
                </div>
            </div>

            <div id="k">
                <div class="form-group" id="l">
                    <div class="label">
                        <label>添加视频名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="video_name[]" style="width: 500px;float: left" data-validate="required:请输入视频名"/>
                        <div class="tips"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="label">
                    <label>课程资源：</label>
                </div>
                <div class="field">
                    <div id="demo">
                        <div id="as" ></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label></label>
                </div>
                <div class="field">
                    <button class="button bg-main icon-check-square-o" type="button" id="jie">追加视频名称</button>
                    <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
                </div>
            </div>
            <input type="hidden" value="" name="file_path[]" id="ll">
            <input type="hidden" value="" name="username[]" id="name">
        </form>
    </div>
</div>
</body>
</html>
<script>
    $('#jie').click(function () {
        var str1='<div class="form-group"><div class="label"><label>添加视频名称：</label></div><div class="field"><input type="text" class="input" name="video_name[]" style="width: 500px;float: left" data-validate="required:请输入章节"/><div class="tips"></div></div></div>';
        //var str1=$('#l').clone();
        $('#k').append(str1);
    })
</script>
<script>
    var str='';
    var str1='';
    $('#as').diyUpload({
        url:'?r=column/uploadimg',
        success:function(data) {
            str+=data['imgpath']+',';
            str1+=data['name']+',';
            $('#ll').val(str);
            $('#name').val(str1);
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