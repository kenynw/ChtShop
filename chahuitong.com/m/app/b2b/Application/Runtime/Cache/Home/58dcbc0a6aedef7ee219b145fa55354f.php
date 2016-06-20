<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>商品详情</title><meta name="keywords" content="茶汇通,供求信息">
<meta name="description" content="茶汇通供求信息">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/mobile/app/b2b/Public/Home/css/shop.css" type="text/css" rel="stylesheet">
<script src="/mobile/app/b2b/Public/Home/js/jquery-1.4.4.min.js"></script>
<script>
$(document).ready(function() {
	
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
<a href="javascript:history.go(-1);"><img src="/mobile/app/b2b/Public/Home/img/xiangzuo.jpg"></a>商品详情
<a href="/mobile/app/b2b/index.php/Home/Index/search"><img src="/mobile/app/b2b/Public/Home/img/sousuo.jpg"></a>
</header>
<div id="focus" class="focus">
<div class="hd">
<ul></ul>
</div>
<div class="bd">
<ul>
<?php if($detail['img'][0] != ''): ?><li><a href="#"><img _src="/mobile/app/b2b/Public/upload/<?php echo ($detail["img"]["0"]); ?>"/></a></li><?php endif; ?>
<?php if($detail['img'][1] != ''): ?><li><a href="#"><img _src="/mobile/app/b2b/Public/upload/<?php echo ($detail["img"]["1"]); ?>"/></a></li><?php endif; ?>
<?php if($detail['img'][2] != ''): ?><li><a href="#"><img _src="/mobile/app/b2b/Public/upload/<?php echo ($detail["img"]["2"]); ?>"/></a></li><?php endif; ?>

</ul>
</div>
</div>
<div class="mail">
<h4><?php echo ($detail["brand"]); ?>-<?php echo ($detail["name"]); ?></h4>
<ul>
<li><label><span></span>品牌</label><?php echo ($detail["brand"]); ?><span class="fabu">发布价:<?php echo ($detail["price"]); ?></span></li>
<li><label><span></span>品名</label><?php echo ($detail["name"]); ?><span class="xiangtan"><?php if($v["arrow_order"] == 1): ?>价格详谈<?php endif; ?></span></li>
<li><label><span></span>年份</label><?php echo ($detail["year"]); ?></li>
<li><label><span></span>数量</label><?php echo ($detail["weight"]); if($detail["unit"] == 1): ?>克<?php endif; ?>
<?php if($detail["unit"] == 2): ?>两<?php endif; ?>
<?php if($detail["unit"] == 3): ?>饼<?php endif; ?>
<?php if($detail["unit"] == 4): ?>盒<?php endif; ?>
<?php if($detail["unit"] == 5): ?>件<?php endif; ?>
<?php if($detail["unit"] == 6): ?>片<?php endif; ?>
<?php if($detail["unit"] == 7): ?>套<?php endif; ?>
<?php if($detail["unit"] == 12): ?>袋<?php endif; ?>
<?php if($detail["unit"] == 9): ?>砖<?php endif; ?>
<?php if($detail["unit"] == 8): ?>提<?php endif; ?>
<?php if($detail["unit"] == 10): ?>斤<?php endif; ?>
<?php if($detail["unit"] == 11): ?>公斤<?php endif; ?></li>
<li><label><span></span>所在地</label><?php echo ($detail["address"]); ?></li>
<li><label><span></span>联系电话</label><?php echo ($detail["phone"]); ?></li>
</ul>
<div class="miaoshu">
<p>产品描述</p>
<p><?php echo ($detail["content"]); ?></p>
</div>
<p>发布时间<span><?php echo ($detail["addtime"]); ?></span></p>
<a href="/mobile/app/b2b/index.php/Home/Index/contact/id/<?php echo ($detail["id"]); ?>"><input type="button" value="联系卖家"></a>
</div>
<nav>
<a href="/mobile/app/b2b/index.php/Home/Index/index"><img src="/mobile/app/b2b/Public/Home/img/shouye.jpg"><br>首页</a>
<a href="/mobile/app/b2b/index.php/Home/Index/post"><img src="/mobile/app/b2b/Public/Home/img/fabu.jpg"><br>发布</a>
<a href="/mobile/app/b2b/index.php/Home/Index/news"><img src="/mobile/app/b2b/Public/Home/img/xiaoxi.jpg"><br>信息</a>
<a href="/mobile/app/b2b/index.php/Home/Index/myList"><img src="/mobile/app/b2b/Public/Home/img/user.jpg"><br>我的</a>
</nav>
</body>
<script type="text/javascript" src="/mobile/app/b2b/Public/Home/js/slide.js"></script>
</html>