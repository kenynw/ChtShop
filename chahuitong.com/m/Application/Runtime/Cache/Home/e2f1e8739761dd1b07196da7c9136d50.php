<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>用户注册</title><meta name="keywords" content="茶汇通">
<meta name="description" content="茶汇通用户注册">
<meta content="text/html; charset=utf-8" http-equiv="content-type">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/share.css" type="text/css" rel="stylesheet">
<style>
.sub form{background-size:100% 176px;}
.sub{position:relative;}
button{position:absolute;top:86px;right:5%;background:#1b8b80;line-height:40px;width:100px;border:none;}
</style>
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script >
$(document).ready(function(){
	
	$("#bon").click(function(){
		  
		    password=$("input[name='password']").val();
			
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
			
			var password=$("input[name='password']").val();
			
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
<script>
window.onload=function(){
	var s=60;
	var bon=document.getElementById('bon');
	var username=document.getElementById('username').value;
	var t;
	bon.onclick=function(){
		var username=document.getElementById('username').value;
		if(username.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/)){
			bon.disabled=true;
			bon.style.backgroundColor="#c9c9c9";
			daojishi(s);
		}
	};
	function daojishi(){
		bon.innerHTML=s+"秒后重新获取";
		s=s-1;
		t=setTimeout(daojishi,1000);
		if(s<0){
			s=60;
			clearTimeout(t);
			bon.disabled=false;
			bon.style.backgroundColor="#1b8b80";
			bon.innerHTML="获取验证码";
		}
	}
}
</script>
</head>
<body>
<header>
<div class="haed">
<a href="javascript:history.go(-1)"><img src="/wap/Public/Home/img/fanhui02.png"></a>
<a href="http://www.chahuitong.com/wap"><img src="/wap/Public/Home/img/home01.png"></a>
</div>
<nav>
<a href="login.html">登&nbsp;陆<mark></mark></a>
<a>注&nbsp;册<span></span></a>
</nav>
<div class="logo"><img src="/wap/Public/Home/img/logo01.png"></div>
</header>
<div>
<div class="sub">
<form id="form1" name="form1" method="post" action="#">
<inp