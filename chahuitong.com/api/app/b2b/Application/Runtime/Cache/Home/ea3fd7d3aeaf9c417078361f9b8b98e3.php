<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>茶市————茶汇通</title>
<meta name="keywords" content="茶汇通,普洱,普洱茶">
<meta name="description" content="茶汇通普洱饼茶">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/mobile/app/b2b/Public/Home/css/share.css" type="text/css" rel="stylesheet">
<link href="/mobile/app/b2b/Public/Home/css/chashi.css" type="text/css" rel="stylesheet">
<style>
h5 mark{background:#1b8b80;color:#fff;width:15px;height:15px;line-height:15px;display:inline-block;border-radius:50%;text-align:center;margin-right:8px;}
.pics{width:100%;text-align:center;font-size:0.9em;border-top:1px solid #c9c9c9;line-height:36px;}
.pics a{display:inline-block;color:#585858;}
.pics a img{width:18px;vertical-align:middle;margin-right:3px;}
.pics a:first-child{float:left;margin-left:3%;}
.pics a:last-child{float:right;margin-right:3%;}
h6{color:#1b8b80;margin:12px 0;}
#ding{position:fixed;right:5%;bottom:60px;display:none;z-index:9;}
#bianji{position:fixed;right:5%;bottom:20px;z-index:9;}
#ding img,#bianji img{width:36px;}
.list ul li{height:101px;}
.picimg{width:100px;height:100px;}
</style>
</head>
<body>
<header id="header">
<a href="javaScript:window.history.back();"><img src="/mobile/app/b2b/Public/Home/img/fanhui.png"></a>茶市<a href="http://www.chahuitong.com/wap"><img src="/mobile/app/b2b/Public/Home/img/home.png"></a>
</header>
<header>
<nav>
<a href="/mobile/app/b2b/index.php/Home/Index/brand">行情</a>
<a href="/mobile/app/b2b/index.php/Home/Index/sale">出售</a>
<a href="/mobile/app/b2b/index.php/Home/Index/buy">求购</a>
<a class="on" href="/mobile/app/b2b/index.php/Home/Index/fabu">发布</a>
</nav>
</header>
<div class="list">
<ul>
<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li id="$v.id">
<a href="/mobile/app/b2b/index.php/Home/Index/info/id/<?php echo ($v["id"]); ?>" style="color:#CCC">
<div class="pic">
<?php if($v["pic"] != ''): ?><img class="picimg" src="/mobile/app/b2b/Public/upload/<?php echo ($v["pic"]); ?>">
<?php else: ?>
    <img class="picimg" src="/mobile/app/b2b/Public/upload/logo.png"><?php endif; ?>
</div>
</a>
<a href="/mobile/app/b2b/index.php/Home/Index/info/id/<?php echo ($v["id"]); ?>" style="color:#333">
</a><div name="text" class="text"><a href="/mobile/app/b2b/index.php/Home/Index/info/id/<?php echo ($v["id"]); ?>" style="color:#333"><h5><?php echo ($v["name"]); ?><span><mark>
    <?php if($v["saleway"] == '1'): ?>卖
        <?php else: ?>
        买<?php endif; ?>
</mark><?php echo ($v["addtime"]); ?></span></h5>
<h6>￥<?php echo ($v["price"]); ?></h6>
</a>
<div class="pics">
<a href="/mobile/app/b2b/index.php/Home/Index/editor/id/<?php echo ($v["id"]); ?>"><img src="/mobile/app/b2b/Public/Home/img/edit.png">修改</a>
<a href="/mobile/app/b2b/index.php/Home/Index/delete/id/<?php echo ($v["id"]); ?>" class="del" data-id="$v.id"><img src="/mobile/app/b2b/Public/Home/img/delete.png">删除</a>
<a href="/mobile/app/b2b/index.php/Home/Index/info/id/<?php echo ($v["id"]); ?>"><img src="/mobile/app/b2b/Public/Home/img/fabu.jpg">查看</a></div>
</div>
</li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
<style>
 .page{padding-top:2em;text-align:center;}
.page a{display:inline-block;width:30px;padding:5px 10px;margin:0 10px;font-size:14px}
.page span{display:inline-block;width:30px;padding:5px 10px;font-size:14px}
</style>
<div class="page"></div>
<script>
window.onload=function(){
    var navi = navigator.userAgent;
    if(navi.indexOf("android")!=-1||navi.indexOf("ios")!=-1){
        //$("header").hide();
        //$("nav").hide();
        document.getElementById("header").style.display="none";
    }
	var ding=document.getElementById('ding');
	window.onscroll=function(){
		var scrollTop=document.body.scrollTop;
		if(scrollTop>360){
			ding.style.display='block';
		}else{ding.style.display='none';}
	};
	ding.onclick=function(){document.body.scrollTop=0};
};
</script>
<div id="bianji"><a href="/mobile/app/b2b/index.php/Home/Index/fabu"><img src="/mobile/app/b2b/Public/Home/img/bianji02.png"></div>
</body></html>