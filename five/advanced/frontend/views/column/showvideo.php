<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <title>视频演示</title>
<!--    <link rel="stylesheet" type="text/css" href="http://www.helloweba.com/demo/css/main.css" />-->
    <script src="js/html5.js"></script>
    <style>
        .demo{margin:60px auto}
    </style>
</head>

<body>
<h2 class="top_title"><?php echo $arr['file_name']?></h2>
    <div class="demo">
        <video class="video" src="<?php echo $arr['url']?>" width="618" height="347" controls preload></video>
    </div>

</body>
</html>
