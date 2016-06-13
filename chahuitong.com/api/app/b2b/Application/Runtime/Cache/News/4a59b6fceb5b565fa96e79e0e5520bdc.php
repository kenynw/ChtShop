<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>茶汇通-山头详情页</title>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/News/css/news.css" />
<link href="/mobile/app/b2b/Public/News/css/share.css" type="text/css" rel="stylesheet">
<link href="/mobile/app/b2b/Public/News/css/shantou.css" type="text/css" rel="stylesheet">
<style type="text/css">
.slide{
	height:280px;
}
.slide li img{
	height:auto;
}
#ding{position:fixed;right:5%;bottom:60px;display:none;z-index:9;}
#ding img{width:36px;}
</style>
</head>
<body>
<!-- 头部 -->
<header id="header">
<a href="javaScript:window.history.back();"><img src="/mobile/app/b2b/Public/News/img/fanhui.png"></a>山头<a href="http://www.chahuitong.com/wap"><img src="/mobile/app/b2b/Public/News/img/home.png"></a>
</header>
<div style="width:100%"><img src="<?php echo ($host); echo ($data["mobile_img"]); ?>" width="100%"/></div>
<div class="body_detail">
<!-- 文字描述 -->
<div class="decri">
<?php echo ($data["body"]); ?>
</div>
<!-- 图集描述 -->
<div style="width:100%;margin:20px 0px"><img src="/mobile/app/b2b/Public/News/img/tuji02.png" width="100%"/></div>
<div class="slide" id="slide3">
    <ul>
        
    </ul>
</div>
<!-- 茶叶特色 -->
<div style="margin:20px 0px"><img src="/mobile/app/b2b/Public/News/img/tese.png" width="100%"/></div>
<div class="decri">
<?php echo ($data["cyte"]); ?>
</div>

<!-- 导航 -->
<div style="margin:20px 0px"><img src="/mobile/app/b2b/Public/News/img/map.png" width="100%"/></div>
<input type="hidden" value="<?php echo ($data["zuobiao"]); ?>" id="zuobiao"/>
<div class="daohang">
<iframe style="width:99%;height: 300px;" src="/mobile/app/b2b/index.php/News/Index/map"></iframe>
</div>

<!-- 相关文章 -->
<div style="margin:20px 0px 10px 0px"><img src="/mobile/app/b2b/Public/News/img/word.png" style="width:100%;/></div>
<div class="about">
<ul>
<?php if(is_array($about)): $i = 0; $__LIST__ = $about;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/<?php echo ($vo["id"]); ?>" target="_self"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
</div>
<div id="ding"><img src="/mobile/app/b2b/Public/News/img/top.png"></div>
<script>
window.onload=function(){
	var ding=document.getElementById('ding');
	window.onscroll=function(){
		var scrollTop=document.body.scrollTop;
		if(scrollTop>360){
			ding.style.display='block';
		}else{ding.style.display='none';}
	ding.onclick=function(){document.body.scrollTop=0};	
	};
};
</script>
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
		var host=jQuery("#host").val();
		$(".pics img").each(function(){
			var imgsrc=$(this).attr("src");
			//alert(imgsrc);
			$("#slide3 ul").append("<li><a><img style='max-width:640px' src='http://www.damenghai.com/"+imgsrc+"'></a></li>");
		})
		
		$('#slide3').swipeSlide({
	        continuousScroll:true,
	        speed : 3000,
	        transitionType : 'cubic-bezier(0.22, 0.69, 0.72, 0.88)',
	        callback : function(i){
	            $('.dot').children().eq(i).addClass('cur').siblings().removeClass('cur');
	        }
	    });
		jQuery(".bottom").click(function(){
    		jQuery("body,html").animate({
    	   		 scrollTop: "0"
    		}, 1000)
   	 })
	 if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
		       $("header").hide();	
	           }
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