<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>用户登陆</title><meta name="keywords" content="茶汇通">
<meta name="description" content="茶汇通用户登录">
<meta content="text/html; charset=utf-8" http-equiv="content-type">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/share.css" type="text/css" rel="stylesheet">
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script>
  $(document).ready(function(){
	  
	  	  $("input[name='password']").change(function(){
		  
		    password=$(this).val();
		    number=$("input[name='username']").val();
			
			$.ajax({
				url:"/wap/index.php/Home/Index/checkmobile",
				
				type:"post",
				
				data:{mobile:number,password:password},
				
				dataType:"json",
				
				success: function(data){
					
					   $("#show").html(data);
					
					   if(data.code!=200){
						   
						   $(".main").css("opacity","0.5");
						   $("#show").html(data.content);
						   $("#show").show();
						   	setTimeout(function(){
							   $("#show").hide();
							   $(".main").css("opacity","1");
						   },3000); 
						   						   
						   }else{
							   
							$(".main").css("opacity","0.5");
						   $("#show").html(data.content);
						   $("#show").show();
						   	setTimeout(function(){
							   $("#show").hide();
							   $(".main").css("opacity","1");
						    },3000); 
							   
							   }				
					}
								
				})
					  
		  })
		  
		$("#loginbtn").click(function(){
			
			var code=$("input[name='pwd']").val();
			
			var password=$("input[name='password']").val()
			
			if(code==''){
								
				 $(".main").css("opacity","0.5");
						   $("#show").html("验证码不能为空");
						   $("#show").show();
						   	setTimeout(function(){
							   $("#show").hide();
							   $(".main").css("opacity","1");
						   },3000); 
								
				}else{
					
				$.ajax({
					url:"/wap/index.php/Home/Index/loginbymobile",
					
					type:"post",
					
					dataType:"json",
					
					data:{code:code,password:password},
					
					success: function(data){
						
						if(data.code=200){
							
                         window.location.href="/wap/index.php/Home/Index/member";
							
							}else{
						    $(".main").css("opacity","0.5");
						   $("#show").html("验证失败，请重新验证");
						   $("#show").show();
						   	setTimeout(function(){
							   $("#show").hide();
							   $(".main").css("opacity","1");
						   },3000); 
		
						
								}
						
						
						 }				
					
					  })	
				}
		
			})  
	 	  
	  })
</script>
</head>
<body>
<header>
<div class="haed">
<a href="#"><img src="/wap/Public/Home/img/fanhui.png"></a>
<a href="#"><img src="/wap/Public/Home/img/home.png"></a>
</div>
<nav>
<a  href="#">登&nbsp;陆<span></span><mark></mark></a>
<a href="register.html">注&nbsp;册</a>
</nav>
</header>
<div class="main">
<div class="sub">
<form method="post" action="">
<input type="text" placeholder="手机号" name="username" id="username"  required><br>
<input type="text" class="password" placeholder="登陆密码" name="password"  required><br>
<input type="text" class="password" placeholder="验证码" name="pwd"  required><br>
<div class="line"></div>
<span class="roundedTwo"><input id="a1" type="checkbox"><label for="roundedTwo"></label></span>一个月内免登陆<a href="#">忘记密码？</a><br>
<a href="javascript:void(0);" class="l-btn-login mt10" id="loginbtn">
                登录
            </a>
</form>

</div>
<div class="di3f">
<div class="denglu">
</div>
<div class="error-tips mt10"></div>
<div class="logodl">
<a href="#"><img src="/wap/Public/Home/img/qq.png"><br>QQ</a>
<a href="#"><img src="/wap/Public/Home/img/weibo.png"><br>新浪微博</a>
<a href="#"><img src="/wap/Public/Home/img/weixin.png"><br>微信</a>
</div>
</div>
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
<input type="hidden" name="referurl">
<div id="show" style="display:none;position:fixed;top:30%;left:0;width:100%;height:50px;background:#F30;text-align:center;color:white;line-height:50px"></div>   
</body>

</html>