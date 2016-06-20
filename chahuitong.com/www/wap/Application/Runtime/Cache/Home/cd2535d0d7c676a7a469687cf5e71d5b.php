<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>用户信息</title>
<meta content="text/html; charset=utf-8" http-equiv="content-type">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/user.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/class.css" type="text/css" rel="stylesheet">
<style>
.user{margin-bottom:55px;}
.user ul{background:#fff;width:100%;}
.user ul:first-child{margin-bottom:12px;}
.user ul li{line-height:60px;color:#898989;border-bottom:1px solid #dcdddd;font-size:1.1em;text-align:left;width:90%;margin:0 auto;}
.user ul li a{display:block;}
.user ul li span{float:right;color:#ccc;}
.user ul:first-child li:first-child{line-height:90px;}
.user ul li:last-child{border:none;}
.user ul:first-child{border-bottom:2px solid #dcdddd;}
.user ul:last-child{border-top:1px solid #999;border-bottom:1px solid #999;}
.user ul li img{vertical-align:middle;margin-left:10px;}
.user ul li mark{background:#fff;}
.user ul li mark img{width:75px;height:75px;border-radius:75px;}
img {border:none;}
address,caption,cite,code,dfn,em,th,var{font-style:normal;font-weight:400;}
ol,ul{list-style:none;}
h1,h2,h3,h4,h5,h6{font-size:100%;}
</style>
</head>
<body>
<header id="header">
<a href="javascript:history.go(-1)"><img src="/wap/Public/Home/img/fanhui.png"></a>用户信息
<a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="user">
<ul>
<li><a href="/wap/index.php/Home/Index/edit">头像<span><mark><img src="http://www.chahuitong.com/data/upload/shop/avatar/<?php echo ($info["member_avatar"]); ?>"></mark><img src="/wap/Public/Home/img/you.png"></span></a></li>
<!--<li><a href="/wap/index.php/Home/Index/edit">用户名<span><?php if($info["member_truename"] == ''): ?>未填写</else><?php echo ($info["member_truename"]); endif; ?><img src="/wap/Public/Home/img/you.png"></span></a></li>
--><li><a href="/wap/index.php/Home/Index/edit">用户名<span><?php echo ($info["member_name"]); ?><img src="/wap/Public/Home/img/you.png"></span></a></li>
<li><a href="/wap/index.php/Home/Index/edit">性别<span>女<img src="/wap/Public/Home/img/you.png"></span></a></li>
<li><a href="/wap/index.php/Home/Index/edit">出生日期<span><?php echo ($info["member_birthday"]); ?><img src="/wap/Public/Home/img/you.png"></span></a></li>
</ul>
<ul>
<li><a href="/wap/index.php/Home/Index/address">地址管理<span><img src="/wap/Public/Home/img/you.png"></span></a></li>
<li><a href="/wap/index.php/Home/Index/changepw">账户安全<span>可修改密码<img src="/wap/Public/Home/img/you.png"></span></a></li>
</ul>
</div>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?9a15ea23e7316c631085bb3ef722599a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script>
$(document).ready(function(){	
	 if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
				$("header").css("display","none");	
				//$(".nav1").css("display","none");	
	  }		
	})
</script>
</body>
</html>