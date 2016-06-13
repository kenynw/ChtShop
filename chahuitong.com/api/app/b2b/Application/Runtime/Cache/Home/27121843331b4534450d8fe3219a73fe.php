<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>茶市协议</title><meta name="keywords" content="茶汇通,供求信息">
<meta name="description" content="茶汇通供求信息">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/mobile/app/b2b/Public/Home/css/gongqiu.css" type="text/css" rel="stylesheet">
<style>
textarea{width:90%;height:200px;padding:8px 2%;background:#e1e1e1;}
p{margin:12px auto;color:#999;font-size:0.9em;}
p input{margin-right:5px;}
button{width:92%;height:30px;color:#fff;background:#a15641;border:none;}
</style>
</head>
<body>
<header>
<a href="javascript:history.back()"><img src="/mobile/app/b2b/Public/Home/img/xiangzuo.jpg"></a>茶市协议
<a href="/mobile/app/b2b/index.php/Home/Index/search"><img src="/mobile/app/b2b/Public/Home/img/sousuo.jpg"></a>
</header>
<div class="mail">
<form action="/mobile/app/b2b/index.php/Home/Index/shenqing" method="post">
<textarea disabled>
  茶市
</textarea>
<p><input type="checkbox" name="chashi" value="1">我同意茶市协议并加入茶市</p>
<input type="hidden" name="uid" value="<?php echo ($uid); ?>">
<button>加入茶市</button>
</form>
</div>
<nav id="bottomTab">
<style>nav a{font-size:1em}</style>
<a class="nav_on"  style="color:#a15641" href="/mobile/app/b2b/index.php/Home/Index/index"><img src="/mobile/app/b2b/Public/Home/img/shouye.jpg"><br>首页</a>
<a href="/mobile/app/b2b/index.php/Home/Index/post"><img src="/mobile/app/b2b/Public/Home/img/fabu.jpg"><br>发布</a>
<a href="/mobile/app/b2b/index.php/Home/Index/news"><img src="/mobile/app/b2b/Public/Home/img/xiaoxi.jpg"><br>信息</a>
<a href="/mobile/app/b2b/index.php/Home/Index/myList"><img src="/mobile/app/b2b/Public/Home/img/user.jpg"><br>我的</a>
</nav>
</body>
</html>