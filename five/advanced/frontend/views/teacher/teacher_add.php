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
  <div class="panel-head"><strong class="icon-reorder"> 添加教师</strong></div>
  <div class="padding border-bottom">  
  <a class="button border-yellow" href="?r=teacher/teacher_list"><span class="icon-plus-square-o"></span>教师列表</a>
  </div> 
  
<div class="panel admin-panel margin-top">
 
  <div class="body-content">
    <form method="post" id="form" class="form-x" action="?r=teacher/teacher_add_info" enctype="multipart/form-data">   
      <input type="hidden" name="id"  value="" />  

      <div class="form-group">
        <div class="label">
          <label>教师名称：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="name" value="" data-validate="required:请输入名称" />         
          <div class="tips"></div>
        </div>
      </div> 

      <div class="form-group">
        <div class="label">
          <label>教师头像：</label>
        </div>
        <div class="field">
          <input type="file" class="button bg-blue margin-left" id="image1" name="photo" value="+ 浏览上传"  style="float:left;" data-validate="required:请上传个人头像">
          <div class="tipss">图片尺寸：1920*200</div>
        </div>
      </div>

          <div class="form-group">
        <div class="label">
          <label>任职时长：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="years" value="" data-validate="required:请输入任职时间" />
          <div class="tips"></div>
        </div>
      </div> 

       <div class="form-group">
        <div class="label">
          <label>教师邮箱：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="email" value="" data-validate="required:请输入邮箱" />         
          <div class="tips"></div>
        </div>
      </div> 

         <div class="form-group">
        <div class="label">
          <label>直播地址：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="address" value="" data-validate="required:请输入直播地址" />
          <div class="tips"></div>
        </div>
      </div> 
      <div class="form-group">
        <div class="label">
          <label>教师简介：</label>
        </div>
        <div class="field">
          <textarea type="text" class="input" name="desc" style="height:100px;" data-validate="required:请填写教师简介" ></textarea>        
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