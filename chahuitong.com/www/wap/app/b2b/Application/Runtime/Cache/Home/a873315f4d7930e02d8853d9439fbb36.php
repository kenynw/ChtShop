<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>联系商家</title>
<script src="/mobile/app/b2b/Public/Home/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/Home/css/b2b.css" />
<style type="text/css">
</style>
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
<div class="dDetail1">
<ul>
<li>品名：<?php echo ($detail["brand"]); ?></li>
<li>年份：<?php echo ($detail["year"]); ?></li>
<li>重量：<?php echo ($detail["weight"]); if($detail["unit"] == 1): ?>克<?php endif; ?>
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
<li>所在地：<?php echo ($detail["address"]); ?></li>
<li>添加时间：<?php echo ($detail["addtime"]); ?></li>
<li>到期时间：<?php echo ($detail["timeout"]); ?>天</li>
<li>电话：<?php echo ($detail["phone"]); ?></li>
</ul>
</div>
<div class="dPrice">
<h3>发布价<?php echo ($detail["price"]); ?></h3>
<i style="color:#a15641">价格详谈</i>
</div>
</div>
<div class="dDetail2">
  <form action="/mobile/app/b2b/index.php/Home/Index/newssave" method="post" id="news">
    <div class="title" style="width:80%;margin:0 auto;height:20px">
     <input type="hidden" value="标题" name="title" placeholder="标题" style="width:100%">
    </div>
    <div class="title" style="width:90%;margin:0 auto;height:60px;padding-bottom:10px">  
     <textarea name="content" style="width:100%;height:60px">
     
     
     </textarea>
     <input type="hidden" name='uid' value="<?php echo ($detail["user_id"]); ?>">
     <input type="hidden" name="cid" value="<?php echo ($cid); ?>">
     <input type="hidden" name="fid" value="<?php echo ($fid); ?>">
     <input type="hidden" name="pid" value="<?php echo ($detail["id"]); ?>">
   </div>
  
  
</div>
<div class="dDetail3">
<a href="tel:<?php echo ($detail["phone"]); ?>"><span style="margin-right:20px;">电话</span></a>
<input type="submit" style="background: #a15641;
color: white;
border: none;
height: 35px;
line-height:35px;width:50px;border-radius:5px;font-size:16px;" value="提交">
</div>
</form>

<nav id="bottomTab">
<style>nav a{font-size:1em}</style>
<a class="nav_on"  style="color:#a15641" href="/mobile/app/b2b/index.php/Home/Index/index"><img src="/mobile/app/b2b/Public/Home/img/shouye.jpg"><br>首页</a>
<a href="/mobile/app/b2b/index.php/Home/Index/post"><img src="/mobile/app/b2b/Public/Home/img/fabu.jpg"><br>发布</a>
<a href="/mobile/app/b2b/index.php/Home/Index/news"><img src="/mobile/app/b2b/Public/Home/img/xiaoxi.jpg"><br>信息</a>
<a href="/mobile/app/b2b/index.php/Home/Index/myList"><img src="/mobile/app/b2b/Public/Home/img/user.jpg"><br>我的</a>
</nav>
</body>
</HTML>