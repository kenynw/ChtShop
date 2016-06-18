<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo ($data[0]["title"]); ?>--茶汇通</title>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/News/css/news.css" />
<style type="text/css">
.slide{
	height:280px;
}
.slide li img{
	height:auto;
}
</style>
</head>
<body>
<!-- 头部 -->
<?php if($headinfo == 0): ?><header id="header">
<a href="javaScript:window.history.back();"><img src="/mobile/app/b2b/Public/News/img/fanhui.png"></a>山头<a href="http://www.chahuitong.com/wap"><img src="/mobile/app/b2b/Public/News/img/home.png"></a>
</header>
<?php else: endif; ?>
<style type="text/css">
.head{
	background-color:#f9f9f9;
}
</style>
<div class="article-content">
<h3><?php echo ($data[0]["title"]); ?></h3>
<div><?php echo ($data[0]["writer"]); ?></div>
<div><?php echo ($data[0]["pubdate"]); ?></div>
<?php echo ($data[0]["body"]); ?>
</div>
<div class="bottom"><img src="/mobile/app/b2b/Public/News/img/backtop.png" width="50px"/></div>
<div class="pics" style="display:none"><?php echo ($data["pics"]); ?></div>
<input type="hidden" value="<?php echo ($host); ?>" id="host"/>
<script src="/mobile/app/b2b/Public/News/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript">
$.noConflict();
</script>
<script src="/mobile/app/b2b/Public/News/js/zepto.min.js" type="text/javascript"></script>
<script src="/mobile/app/b2b/Public/News/js/swipeSlide.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		var host="http://www.damenghai.com";
		jQuery(".article-content img").each(function(){
			var imgsrc=host+jQuery(this).attr("src");
			jQuery(this).attr("src",imgsrc);
			jQuery(this).css("width","100%");
		})
		
		jQuery(".bottom").click(function(){
    		jQuery("body,html").animate({
    	   		 scrollTop: "0"
    		}, 1000)
   	 });
	 
	 if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
		       $("header").hide();	
	           }
	})
</script>
</body>
</HTML>