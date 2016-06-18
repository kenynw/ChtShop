<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>茶汇通-资讯首页</title>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/News/css/news.css" />
<style type="text/css">
.feilei-items li{
	width:70px;
}
</style>
</head>
<body>
<!-- 头部 -->
<div class="head">
<a class="backButton himg" href="javascript:history.go(-1)"><img src="/mobile/app/b2b/Public/News/img/back.png"/></a>
<h3>资讯</h3>
<a class="queryButton himg" href="<?php echo U('Index/index');?>" style="margin-top:17px;">山头</a>
</div>
<div style="height:50px;"></div>
<style type="text/css">
.head{
	background-color:#f9f9f9;
}
</style>
<!-- 茶-分类 -->
<div class="fenlei">
<ul class="feilei-items">
<li><a href="#" style="color:#edb201;border-bottom:2px solid #edb201;padding-bottom:5px">最新</a></li>
<li><a href="#">市场行情</a></li>
<li><a href="#">展会活动</a></li>
<li><a href="#">行业政策</a></li>
<li><a href="#">品牌新闻</a></li>
</ul>
</div>
<!-- 幻灯片 -->
<div class="slide" id="slide3">
    <ul>
        <li>
            <a href="#">
                <img src="/mobile/app/b2b/Public/News/img/test.jpg">
            </a>
        </li>
        <li>
            <a href="#">
                <img src="/mobile/app/b2b/Public/News/img/半坡老寨.jpg">
            </a>
        </li>
    </ul>
    <div class="dot">
        <span></span>
        <span></span>
    </div>
</div>

<!-- 资讯列表 -->
<div class="infos">
<div class="img-content">
<img src="http://www.damenghai.com/uploads/allimg/c141119/14163N4GG5F-43638.jpg" />
</div>
<div class="img-title">茶汇通即将震撼上线，给你惊喜，让您买茶卖茶不再犹豫不决</div>
<div class="img-descri">茶汇通即将震撼上线，给你惊喜，让您买茶卖茶不再犹豫不决</div>
</div>

<script src="/mobile/app/b2b/Public/News/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript">
$.noConflict();
</script>
<script src="/mobile/app/b2b/Public/News/js/zepto.min.js" type="text/javascript"></script>
<script src="/mobile/app/b2b/Public/News/js/swipeSlide.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    $('#slide3').swipeSlide({
        continuousScroll:true,
        speed : 3000,
        transitionType : 'cubic-bezier(0.22, 0.69, 0.72, 0.88)',
        callback : function(i){
            $('.dot').children().eq(i).addClass('cur').siblings().removeClass('cur');
        }
    });
    
    //顶部茶分类-点击效果
    $(".feilei-items li a").click(function(){
  	  	$(".feilei-items li a").css({"color":"#999999","border-bottom":"none"});
    		$(this).css({"color":"#edb201","border-bottom":"2px solid #edb201","padding-bottom":"5px"});
    })
});
</script>
</body>
</HTML>