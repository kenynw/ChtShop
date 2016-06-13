<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>用户个人中心</title>
<meta name="keywords" content="茶汇通">
<meta name="description" content="茶汇通用户个人中心">
<meta content="text/html; charset=utf-8" http-equiv="content-type">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/sharenew.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/usernew.css" type="text/css" rel="stylesheet">
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script src="/wap/Public/Home/js/jquery.cookie.js"></script>
<script>
 $(document).ready(function(){	 
	 $(".delcookie").click(function(){
		 
		 $.cookie("username",null,{path:"/"}); 
		 
		 $.cookie("key",null,{path:"/"}); 
		 
		 $(".show").html("已经清除了您的登陆信息");
		 
		 $(".mail a").attr('href',"/wap/index.php/Home/Index/login")
		 
		 $(".show").show();
		 
		 setTimeout(function(){
			 
			 $(".show").hide();
			 },3000)
		 
		 
		 
		 
		 }) 
	 })
</script>
<style>
#nav{width:100%;position:absolute;top:70px;left:0;}
#nav a:first-child{float:left;margin-left:5%;}
#nav a:last-child{float:right;margin-right:5%;}
#nav a img{width:40px;}
.memberbg{  width: 28%;;margin:0 auto;}
</style>
</head>
<body>
<div class="head">
<div class="memberbg" 
style="<?php if($userinfo): ?>background:url(/data/upload/shop/avatar/<?php echo ($userinfo["member_avatar"]); ?>) no-repeat center center; background-size:100% 95%;
<?php else: ?>
background:url(/wap/Public/Home/img/user123.png) no-repeat center center; background-size:100% 95%;<?php endif; ?>">
<div style="width:100%;height:42px;background:url(/wap/Public/Home/img/bg123.png)"></div>
<img src="/wap/Public/Home/img/background.png">
</div>
<p><?php if($userinfo): echo ($userinfo["member_name"]); else: ?>您还未登录<?php endif; ?></p>
</div>
<div class="mail">
<a href="<?php if($userinfo): ?>/wap/index.php/Home/Index/orderList<?php else: ?>/wap/index.php/Home/Index/login<?php endif; ?>"><img src="/wap/Public/Home/img/2_05.png"><br>我的订单<?php if($ordernumber): ?><span><?php echo ($ordernumber); ?></span><?php endif; ?></a>
<a href="<?php if($userinfo): ?>/wap/index.php/Home/Index/cart<?php else: ?>/wap/index.php/Home/Index/login<?php endif; ?>"><img src="/wap/Public/Home/img/2_07.png"><br>购物车<?php if($cartnumber): ?><span><?php echo ($cartnumber); ?></span><?php endif; ?></a>
<a href="<?php if($userinfo): ?>/wap/index.php/Home/Index/favorites<?php else: ?>/wap/index.php/Home/Index/login<?php endif; ?>"><img src="/wap/Public/Home/img/2_09.png"><br>我的收藏</a>
<a href="<?php if($userinfo): ?>/wap/index.php/Home/Index/myInfo<?php else: ?>/wap/index.php/Home/Index/login<?php endif; ?>"><img src="/wap/Public/Home/img/2_14.png"><br>用户信息</a>
<a href="<?php if($userinfo): ?>/wap/index.php/Home/Index/address<?php else: ?>/wap/index.php/Home/Index/login<?php endif; ?>"><img src="/wap/Public/Home/img/2_15.png"><br>收货地址</a>
<!--<a href="<?php if($userinfo): ?>/mobile/app/b2b/index.php/Home/Index/myList<?php else: ?>/wap/index.php/Home/Index/login<?php endif; ?>"><img src="/wap/Public/Home/img/fabu1.png"><br>我的发布</a>-->
<a href="<?php if($userinfo): ?>/wap/index.php/Home/Index/msg <?php else: ?>/wap/index.php/Home/Index/login<?php endif; ?>"><img src="/wap/Public/Home/img/2_20.png"><br>通知中心<?php if($messagecount): ?><span><?php echo ($messagecount); ?></span><?php endif; ?></a>
<a href=""><img src="/wap/Public/Home/img/2_23.png"><br>社&nbsp;区</a>
<a href="<?php if($userinfo): ?>/wap/index.php/Home/Index/message<?php else: ?>/wap/index.php/Home/Index/login<?php endif; ?>"><img src="/wap/Public/Home/img/2_22.png"><br>评&nbsp;价</a>
<a href="<?php if($userinfo): ?>/wap/index.php/Home/Index/suggest<?php else: ?>/wap/index.php/Home/Index/login<?php endif; ?>"><img src="/wap/Public/Home/img/2_24.png"><br>意见反馈</a>
</div>
<header>
<a href="#"><img src="/wap/Public/Home/img/yve.png">余额:<?php echo ($userinfo["available_predeposit"]); ?></a>
<a href="#"><img src="/wap/Public/Home/img/hongbao.png">红包</a>
<a href="#"><img src="/wap/Public/Home/img/jifen.png">积分:<?php echo ($userinfo["member_points"]); ?></a>
</header>
<div id="nav">
<a href="/wap"><img src="/wap/Public/Home/img/fanhui01.png"></a><a href="#" class="delcookie"><img src="/wap/Public/Home/img/tuichu.png"></a>
</div>
<div class="show" style="display:none;background:#F00;color:white;text-align:center;height:30px;line-height:30px;position:fixed;top:30%;width:100%"></div>
</body>
</html>