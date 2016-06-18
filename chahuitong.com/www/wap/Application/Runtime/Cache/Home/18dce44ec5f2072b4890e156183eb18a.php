<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>评价结果</title>
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/class.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/shopcart.css" type="text/css" rel="stylesheet">
<style>
.jieguo{background:#fff;width:94%;padding:0 3%;border-bottom:1px solid #999;color:#898989;}
.jieguo h2{line-height:60px;border-bottom:1px solid #ddd;}
.jieguo h2 img{width:25px;padding-right:15px;vertical-align:middle;}
.jieguo p{color:#898989;padding:15px 0;}
.result>a{display:inline-block;width:75%;margin-top:36px;background:#1b8b80;line-height:45px;color:#fff;font-size:1.2em;border:none;}
.tel{position:absolute;bottom:10px;left:0;width:100%;color:#aaa;text-align:center;font-size:0.8em;}
.tel a{color:#898989;font-size:1.3em;}
</style>
</head>
<body>
<header>
<a href="javascript:history.go(-1)"><img src="/wap/Public/Home/img/fanhui.png"></a>评价结果
<a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="mail">
<div class="result">
<div class="jieguo">
<h2><img src="/wap/Public/Home/img/gou1.png">您已经完成评价！</h2>
<p>页面讲自动跳转，等待时间：<span id="sp">5</span></p></div>
<a href="/wap/index.php/Home/Index/orderList">点击查看其他订单</a>
</div>
<div class="tel">
如有任何疑问，请致电客服：<a href="tel:05925990900">0592-5990900</a>
</div>
<ul class="cart-list" id="inneed"></ul>
<script>
var sp = document.getElementById('sp');
var num = 5;
function sj(){
	if(num == 0){
		window.location = "/wap/index.php/Home/Index/member";
	}
	sp.innerHTML=num;
	num--;
	setTimeout(sj,1000);
}
sj();
</script>
<script type="text/javascript" src="/wap/Public/Home/js/zepto.min.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/config.js"></script>  
    <script type="text/javascript" src="/wap/Public/Home/js/template.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/common.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/simple-plugin.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/common-top.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/cart-list.js"></script>
<div>

</div>
</div>
</body>
</html>