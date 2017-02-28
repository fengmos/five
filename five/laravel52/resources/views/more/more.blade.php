<!DOCTYPE html>
<html>
  <head>
     <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title>直播</title>
    <link href="{{asset('style/css/ionic.min.css')}}" rel="stylesheet">
    <script src="{{asset('style/js/ionic.bundle.min.js')}}"></script>
    
    
  </head>
  
  <body >
    	
 <div id="my_info">
    <div class="bar bar-header bar-positive  " >
	<a class="button button-clear icon ion-ios-arrow-left" onclick="history.go(-1);"></a>
     <h1 class="title">正在直播</h1>
	 
   </div>
   <div class="scroll-content has-header " style="background-image:url();">
     <div style="margin:10px auto;margin-top:230px; width:40px;height:40px;border-radius:40px;overflow:hidden; ">
                <img src="" style="margin:0;width:100%;height:100%;">
            </div>
            <p style="font-size:18px; text-align:center" >暂无直播视频</p>
   </div>
</div>
	 @include('master')
  </body>
</html>
