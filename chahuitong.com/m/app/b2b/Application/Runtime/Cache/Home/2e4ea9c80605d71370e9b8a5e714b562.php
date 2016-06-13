<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>详情页</title>
<script src="/mobile/app/b2b/Public/Home/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/Home/css/b2b.css" />
<style type="text/css">
</style>
<script type="text/javascript">
	$(function(){
	});
</script>
</head>
<body>
<!-- 头部 -->
<div class="head">
<a class="backButton" href="http://www.chahuitong.com/mobile/app/b2b/index.php/Home/Index">返回</a>
<h3 class="pageTitle">茶市</h3>
<a class="queryButton" id="cx" href="/mobile/app/b2b/index.php/Home/Index/search">查询</a>
</div>
<div class="height" style="height:50px;"></div>


<div class="dDetail">
<h1 style="font-size:12px;font-weight:500;text-align:center"><?php echo ($info["title"]); ?></h1>
</div>
<div class="dDetail2">
 <p><?php echo ($info["content"]); ?></p>
</div>
<div class="dDetail3">
<a href="/mobile/app/b2b/index.php/Home/Index/reply/pid/<?php echo ($info["pid"]); ?>/fid/<?php echo ($info["id"]); ?>"><span style="margin-right:20px;">回复商家</span></a>

</div>
<nav id="bottomTab">
<style>nav a{font-size:1em}</style>
<a class="nav_on"  style="color:#a15641" href="/mobile/app/b2b/index.php/Home/Index/index"><img src="/mobile/app/b2b/Public/Home/img/shouye.jpg"><br>首页</a>
<a href="/mobile/app/b2b/index.php/Home/Index/post"><img src="/mobile/app/b2b/Public/Home/img/fabu.jpg"><br>发布</a>
<a href="/mobile/app/b2b/index.php/Home/Index/news"><img src="/mobile/app/b2b/Public/Home/img/xiaoxi.jpg"><br>信息</a>
<a href="/mobile/app/b2b/index.php/Home/Index/myList"><img src="/mobile/app/b2b/Public/Home/img/user.jpg"><br>我的</a>
</nav>
</body>
</HTML>