<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<title>意见反馈</title>
<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/reset.css">
<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/class.css">
<script>
function submitSuggest(){
	document.getElementById("form").submit();
	
	}

</script>
<style>
*{margin:0;padding:0;}
.yijian{padding:3%;}
.yijian textarea{width:100%;height:80px;margin:8px 0;}
.yijian input{width:100%;height:25px;margin:8px 0;}
.yijian button{background:#1b8b80;display:block;color:#fff;margin:3px auto;width:70%;height:36px;font-size:1.3em;border:none;}
</style>
</head>
<body>
   <header>
   <a href="javascript:history.go(-1)"><img src="/wap/Public/Home/img/fanhui.png"></a>意见反馈
   <a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
  </header>
<form action="/wap/index.php/Home/Index/suggestSave" method="post" id="form">
<div class="yijian">
你的宝贵意见：<br>
<textarea name="content"></textarea><br>
你的QQ：<br>
<input type="text" name="member_info"><br>
<button onClick="submitSuggest()">提&nbsp;&nbsp;&nbsp;交</button></div>
</form>
</body>
</html>