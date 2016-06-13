<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>茶汇通-山头首页</title>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/News/css/news.css" />
<style type="text/css">
</style>
</head>
<body>
<!-- 头部 -->

<!-- 茶-分类 -->
<div class="fenlei">
<ul class="feilei-items">
<li><a href="<?php echo U('Index/index');?>" style="color:#edb201;border-bottom:2px solid #edb201;padding-bottom:5px">普洱茶</a></li>
<li><a href="<?php echo U('Index/wulong');?>">乌龙茶</a></li>
<li><a href="<?php echo U('Index/hong');?>">红茶</a></li>
<li><a href="<?php echo U('Index/lv');?>">绿茶</a></li>
<li><a href="<?php echo U('Index/hei');?>">黑茶</a></li>
<li><a href="<?php echo U('Index/huang');?>">黄茶</a></li>
<li><a href="<?php echo U('Index/bai');?>">白茶</a></li>
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
<!-- 印象 -->

<!-- 各大茶区 -->
<div class="chaqu">
<!-- 勐海 -->

<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2912">西湖龙井</a></h2>
<span><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2909">狮峰龙井</a></span>|<span><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2913">翁家山龙井</a></span>|<span><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2908">云栖龙井</a></span>|<span><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2908">虎跑龙井</a></span>|<span><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2909">梅家坞龙井</a></span>|
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2925">黄山毛峰</a></h2>
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2940">太平猴魁</a></h2>
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2921">洞庭碧螺春</a></h2>
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2915">信阳毛尖</a></h2>
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2939">崂山绿茶</a></h2>
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2934">恩施玉露茶</a></h2>
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2945">庐山云雾</a></h2>
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2945">六安瓜片</a></h2>
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2945">雀舌</a></h2>
<span><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2947">武夷雀舌</a></span>|<span><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2947">贵州雀舌</a></span>|<span><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2947">蒲江雀舌</a></span>|<span><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2947">金坛雀舌</a></span>|<span><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2947">浙江雀舌</a></span>|
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2945">蒙顶毛峰</a></h2>
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2945">竹叶青</a></h2>
</div>
<div class="shantou">
<h2><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/2945">都匀毛尖</a></h2>
</div>
</div>

</div>
<!-- 勐腊 -->

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
    //山头详情-点击隐藏，显示
    $(".open").click(function(){
   	 	$(this).siblings(".shantou-content").css("display","block");
   	 	$(this).hide();
   	 	$(this).prev(".close").show();
    })
    $(".close").click(function(){
    		$(this).siblings(".shantou-content").css("display","none");
    		$(this).hide();
   	 	$(this).next(".open").show();
    })
    
    jQuery(".bottom").click(function(){
    		jQuery("body,html").animate({
    	   		 scrollTop: "0"
    		}, 1000)
   	 })
});
</script>
</body>
</HTML>