<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo ($data["article_title"]); ?>--茶汇通</title>
<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/news.css" />
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
<div class="article-content">
<h3><?php echo ($data["article_title"]); ?></h3>
<div><?php echo ($data["article_author"]); ?></div>
<div><?php echo ($data["pubdate"]); ?></div>
<?php echo ($data["article_content"]); ?>
</div>
<div class="bottom"><img id="img" src="/wap/Public/Home/img/backtop.png" width="50px"/></div>
<div class="pics" style="display:none"><?php echo ($data["pics"]); ?></div>
<input type="hidden" value="<?php echo ($host); ?>" id="host"/>
<script src="/wap/Public/Home/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript">
$.noConflict();
</script>
<script src="/wap/Public/Home/js/zepto.min.js" type="text/javascript"></script>
<script src="/wap/Public/Home/js/swipeSlide.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		var host="http://www.damenghai.com";
		jQuery(".article-content img").each(function(){
			var imgsrc=host+jQuery(this).attr("src");
			if(($(this).attr("src").indexOf("120.24.208.42")==-1)&&($(this).attr("src").indexOf("damenghai.com")==-1)&&($(this).attr("src").indexOf("chahuitong.com")==-1)&&($(this).attr("src").indexOf("data")==-1)&&($(this).attr("src").indexOf("wap")==-1)&&($(this).attr("src").indexOf("data")==-1)){
			jQuery(this).attr("src",imgsrc);
			}			
			jQuery(this).css("width","100%");
						
		})
		
		jQuery("#img").css("width","50px")
		
		jQuery(".bottom").click(function(){
    		jQuery("body,html").animate({
    	   		 scrollTop: "0"
    		}, 1000)
   	 })
	})
</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?9a15ea23e7316c631085bb3ef722599a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</HTML>