<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>茶汇通-山头详情页</title>
<link rel="stylesheet" type="text/css" href="/wap/app/b2b/Public/News/css/news.css" />
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
<?php if($headinfo == 0): ?><div class="head">
<a class="backButton himg" href="javascript:history.go(-1)"><img src="/wap/app/b2b/Public/News/img/back.png"/></a>
<img src="/wap/app/b2b/Public/News/img/hill_logo.png" style="width:80px;margin-top:8px;"/>
<!-- <a class="queryButton himg"><img src="/wap/app/b2b/Public/News/img/search.png"/></a> -->
</div>
<div style="height:50px;"></div>	
<?php else: endif; ?>
<div style="width:100%"><img src="<?php echo ($host); echo ($data["mobile_img"]); ?>" width="100%"/></div>
<div class="body_detail">
<!-- 文字描述 -->
<div class="decri">
<?php echo ($data["body"]); ?>
</div>
<!-- 图集描述 -->
<div style="width:100%;margin:20px 0px"><img src="/wap/app/b2b/Public/News/img/tuji.png" width="100%"/></div>
<div class="slide" id="slide3">
    <ul>
        
    </ul>
</div>
<!-- 茶叶特色 -->
<div style="margin:20px 0px"><img src="/wap/app/b2b/Public/News/img/chayetese.png" width="100%"/></div>
<div class="decri">
<?php echo ($data["cyte"]); ?>
</div>

<!-- 导航 -->
<div style="margin:20px 0px"><img src="/wap/app/b2b/Public/News/img/daohang.png" width="100%"/></div>
<input type="hidden" value="<?php echo ($data["zuobiao"]); ?>" id="zuobiao"/>
<div class="daohang">
<iframe style="width:99%;height: 300px;" src="/wap/app/b2b/index.php/News/Index/map"></iframe>
</div>

<!-- 相关文章 -->
<div style="margin:20px 0px 10px 0px"><img src="/wap/app/b2b/Public/News/img/about.png" style="width:25%;margin-left:10px"/></div>
<div class="about">
<ul>
<?php if(is_array($about)): $i = 0; $__LIST__ = $about;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="/wap/app/b2b/index.php/News/Index/detail/aid/<?php echo ($vo["id"]); ?>" target="_self"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
</div>
<div class="bottom"><img src="/wap/app/b2b/Public/News/img/backtop.png" width="50px"/></div>
<div class="pics" style="display:none"><?php echo ($data["pics"]); ?></div>
<input type="hidden" value="<?php echo ($host); ?>" id="host"/>
<script src="/wap/app/b2b/Public/News/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript">
$.noConflict();
</script>
<script src="/wap/app/b2b/Public/News/js/zepto.min.js" type="text/javascript"></script>
<script src="/wap/app/b2b/Public/News/js/swipeSlide.min.js" type="text/javascript"></script>
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
	})
</script>
</body>
</HTML>