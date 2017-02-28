<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>网站信息</title>  
    <link rel="stylesheet" href="css/pintuer.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/jquery.js"></script>
    <script src="js/pintuer.js"></script>  

</head>
<body>
<div class="panel admin-panel">
  <div class="panel-head"><strong class="icon-reorder"> 添加直播</strong></div>
  <div class="padding border-bottom">  
  <a class="button border-yellow" href="?r=teacher/show"><span class="icon-plus-square-o"></span>直播列表</a>
  </div> 
  
<div class="panel admin-panel margin-top">
 
  <div class="body-content">
    <form method="post" id="form" class="form-x" action="?r=teacher/add" enctype="multipart/form-data">   
      <input type="hidden" name="id"  value="" />  
      <div class="form-group">
        <div class="label">
          <label>直播名称：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="title" value="" data-validate="required:请输入名称" />         
          <div class="tips"></div>
        </div>
      </div>
 
         <div class="form-group">
            <div class="label">
                <label>上级分类：</label>
            </div>
            <div class="field">
                <select name="type_id" class="input w50">
                    <option value="0">顶级节点</option>
                    <?php foreach($type as $key=>$val){?>
                        <option value="<?php echo $val['type_id']?>">
                          <?php echo str_repeat('&nbsp;&nbsp;&nbsp;',$val['flag'])?><?php echo $val['type_name']?>
                        </option>
                    <?php }?>
                </select>
                <div class="tips">默认一级分类</div>
            </div>
        </div>

<div class="form-group">
            <div class="label">
                <label>老师：</label>
            </div>
            <div class="field">
                <select name="teacher_id" class="input w50">
                
                    <?php foreach($laoshi as $key=>$val){?>
                        <option value="<?php echo $val['teacher_id']?>">
                          <?php echo $val['teacher_name']?>
                      </option>
                    <?php }?>
                </select>
                <div class="tips"></div>
            </div>
        </div>

<div class="form-group">
        <div class="label">
          <label>直播地址：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="url" value="" data-validate="required:请输入直播地址" />         
          <div class="tips"></div>
        </div>
      </div>

      <div class="form-group">
        <div class="label">
          <label>封面：</label>
        </div>
        <div class="field">
          <input type="file" class="button bg-blue margin-left" id="image1" name="photo" value="+ 浏览上传"  style="float:left;" data-validate="required:请上传图片">
          <div class="tipss">图片尺寸：1920*200</div>
        </div>
      </div>
          
      <div class="form-group">
        <div class="label">
          <label>时间：</label>
        </div>
        <div class="field">
          <!-- 时间插件 -->
       <input type="text" class="sang_Calender" id="begintime" style="height:30px;" name="begintime"/>-
       <input type="text" class="sang_Calender" id="endtime" style="height:30px;" name="endtime"/> 
          <!-- end时间插件 -->
           <span id="info" style="color:#FF2D2D;"></span>
           <div class="tips"></div>

        </div>

      </div>
      <div class="form-group">
        <div class="label">
          <label>课程：</label>
        </div>
        <div class="field">
          <textarea type="text" class="input" name="course" style="height:100px;" data-validate="required:请填写课程" ></textarea>        
        </div>
     </div>
    
     
      
     <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o" type="submit" id="submit"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>
</body>
</html>
<!-- shijian -->
<script type="text/javascript" src="time/datetime.js"></script>
<!-- end shijian -->

<script>
$(function(){
     var error = 0 ;
     $("#begintime").blur(function(){
          var begintime = $(this).val();
           if(begintime == '')
           {
                error++;
                $("#info").html("请输入开始时间");
           }else
           {
                error=0;
           }
     })
      $("#endtime").blur(function(){
          var begintime = $(this).val();
           if(begintime == '')
           {
                error++;
                $("#info").html("请输入结束时间");
           }else
           {
                error=0;
           }
     })
      $("#form").submit(function(){
            var begintime = $("#begintime").val();
            var endtime = $("#endtime").val();
          if(begintime == '' || endtime == '')
          {
            $("#info").html("请输入直播的开始与结束时间");
             return false;
          }
      })
})

</script>