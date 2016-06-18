<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>用户信息</title>
<meta content="text/html; charset=utf-8" http-equiv="content-type">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<script type="text/javascript" src="/wap/Public/Home/js/date/jquery.js"></script>

<script type="text/javascript">
<!--
$(document).ready(function(){
    if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
        $("#header").css("display","none");
        //$(".nav1").css("display","none");
    }
    $(".submit").click(function(){
	  $pwd=$("input[name='pwd']").val();
	  $newpwd=$("input[name='newpwd']").val();
	  $repwd=$("input[name='repwd']").val();
	  $.post(
	    "/wap/index.php/Home/Index/changepwdapi",
		 {pwd:$pwd,newpwd:$newpwd,repwd:$repwd},
		 function(data){
			 var json=eval(data);	
			 //$(".result").show(); 
			 $(".result").html(json.date);	
			 setTimeout(function(){
                        h()
                         },3000);		 
			 	 
			 },
         "json"
	    )
	  
	  })
	 
	 function h(){
		 
		   $(".result").html("");
		 
		 } 
		
});
//-->
</script>
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
input{border:none;text-align:center;padding:5px 0px;}
.submit{background:#1b8b80;width:60%;height:30px;color:#FFF;font-weight:bold}
</style>
</head>
<body>
<header id="header">
<a href="javaScript:window.history.back();"><img src="/wap/Public/Home/img/fanhui.png"></a>用户信息<a href="http://www.chahuitong.com/wap"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="user">


<ul>

<li>旧密码<span><input type="text" name="pwd" placeholder='旧密码' value=''></span></li>

<li>新密码<span><input type="text" name="newpwd" placeholder='新密码' value=''></span></li>

<li>确定：<span><input type="text" name="repwd" placeholder='确认密码' value=''></span></li>



</ul>

<input type="submit" class="submit" value="提交">

<li style="height:25px;padding-top:10px;list-style:none"><span class="result" style="color:red"></span></li>

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
</body>
</html>