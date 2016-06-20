<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>供求信息</title><meta name="keywords" content="茶汇通,供求信息">
<meta name="description" content="茶汇通供求信息">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/mobile/app/b2b/Public/Home/css/gongqiu.css" type="text/css" rel="stylesheet">
<script src="/mobile/app/b2b/Public/Home/js/jquery-1.4.4.min.js"></script>
<script src="/mobile/app/b2b/Public/Home/js/gongqiu.js"></script>
<script>
$(document).ready(function() {
	
	$(".click").click(function(){
		
		window.location.href="/mobile/app/b2b/index.php/Home/Index/index/order/1";
		
		})
		var navi = navigator.userAgent;
	if(navi.indexOf("android")!=-1||navi.indexOf("ios")!=-1){
		$("header").hide();
		$("nav").hide();
	}
    
});
</script>
<script src="/mobile/app/b2b/Public/Home/js/TouchSlide.1.1.js"></script>
</head>
<body>
<header>
<a href="http://www.chahuitong.com/mobile/user.php"><img src="/mobile/app/b2b/Public/Home/img/xiangzuo.jpg"></a>供求信息
<a href="/mobile/app/b2b/index.php/Home/Index/search"><img src="/mobile/app/b2b/Public/Home/img/sousuo.jpg"></a>
</header>
<div id="focus" class="focus">
<div class="hd">
<ul></ul>
</div>
<div class="bd">
<ul>
<li><a href="#"><img src="/mobile/app/b2b/Public/Home/img/tu.jpg"/></a></li>
<li><a href="#"><img src="/mobile/app/b2b/Public/Home/img/tu.jpg"/></a></li>
<li><a href="#"><img src="/mobile/app/b2b/Public/Home/img/tu.jpg"/></a></li>
</ul>
</div>
</div>
<div class="mail">
<div class="nav">
<a class="on" href="/mobile/app/b2b/index.php/Home/Index/index" style="margin: 1px 1px;
padding: 2px 0px 9px 0px;
background: #fff;
color: #a15641;
border-left: 1px solid #a15641;
border-top: 1px solid #a15641;
border-bottom:none;
border-right: 1px solid #a15641;background:url(http://www.chahuitong.com/mobile/app/b2b/public/Home/img/dian.png) no-repeat 85% 30%;background-size:15% 50%">全部</a>
<a  href="/mobile/app/b2b/index.php/Home/Index/sale">出售</a>
<a  href="/mobile/app/b2b/index.php/Home/Index/buy">求购</a>
<img class="click" src="/mobile/app/b2b/Public/Home/img/timesort.jpg">
</div>
<div class="details">
<ul>
<?php if(is_array($all)): $i = 0; $__LIST__ = $all;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
<a href="/mobile/app/b2b/index.php/Home/Index/info/id/<?php echo ($v["id"]); ?>"n style="color:#CCC">
<div class="pic">
<?php if($v["pic"] != ''): ?><img class="picimg" src="/mobile/app/b2b/Public/upload/<?php echo ($v["pic"]); ?>">
<?php else: ?>
<img class="picimg" src="/mobile/app/b2b/Public/Home/img/nopic.jpg"><?php endif; ?>
<div class="state">
<?php if($v["saleway"] == 1): ?><img src="/mobile/app/b2b/Public/Home/img/shou.png">
<?php else: ?>
<img src="/mobile/app/b2b/Public/Home/img/gou.png"><?php endif; ?>
</div>
</div>
<div class="shop">
<div class="title">
<h3><?php echo ($v["brand"]); ?> <?php echo ($v["name"]); ?></h3>
<p><span>年份:<?php echo ($v["year"]); ?></span><span>数量:<?php echo ($v["weight"]); if($v["unit"] == 1): ?>克<?php endif; ?>
<?php if($v["unit"] == 2): ?>两<?php endif; ?>
<?php if($v["unit"] == 3): ?>饼<?php endif; ?>
<?php if($v["unit"] == 4): ?>盒<?php endif; ?>
<?php if($v["unit"] == 5): ?>件<?php endif; ?>
<?php if($v["unit"] == 6): ?>片<?php endif; ?>
<?php if($v["unit"] == 7): ?>套<?php endif; ?>
<?php if($v["unit"] == 12): ?>袋<?php endif; ?>
<?php if($v["unit"] == 9): ?>砖<?php endif; ?>
<?php if($v["unit"] == 8): ?>提<?php endif; ?>
<?php if($v["unit"] == 10): ?>斤<?php endif; ?>
<?php if($v["unit"] == 11): ?>公斤<?php endif; ?></span></p>
<p style="height:1.1em;overflow:hidden;"><?php echo ($v["content"]); ?></p>
</div>
<div class="jiage">
<?php if($v['arrow_order'] == 1): echo ($v["price"]); ?>

<?php else: ?>
价格详谈<?php endif; ?>

</div>
</div>
<div class="time">
<img src="/mobile/app/b2b/Public/Home/img/time.jpg"><?php echo ($v["addtime"]); ?>
</div>
</a>
</li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>


</div>
<style>
 .page{padding-top:2em;text-align:center;}
.page a{display:inline-block;width:30px;padding:5px 10px;margin:0 10px;font-size:14px}
.page span{display:inline-block;width:30px;padding:5px 10px;font-size:14px}
</style>
<div class="page">
  <?php echo ($page); ?>
</div>
</div>

<nav id="bottomTab">
<style>nav a{font-size:1em}</style>
<a class="nav_on"  style="color:#a15641" href="/mobile/app/b2b/index.php/Home/Index/index"><img src="/mobile/app/b2b/Public/Home/img/shouye.jpg"><br>首页</a>
<a href="/mobile/app/b2b/index.php/Home/Index/post"><img src="/mobile/app/b2b/Public/Home/img/fabu.jpg"><br>发布</a>
<a href="/mobile/app/b2b/index.php/Home/Index/news"><img src="/mobile/app/b2b/Public/Home/img/xiaoxi.jpg"><br>信息</a>
<a href="/mobile/app/b2b/index.php/Home/Index/myList"><img src="/mobile/app/b2b/Public/Home/img/user.jpg"><br>我的</a>
</nav>
</body>
<script type="text/javascript" src="/mobile/app/b2b/Public/Home/js/slide.js"></script>
</html>