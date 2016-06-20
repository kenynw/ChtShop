<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>用户信息</title>
<meta content="text/html; charset=utf-8" http-equiv="content-type">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<script type="text/javascript" src="/wap/Public/Home/js/date/jquery.js"></script>
<style type="text/css">@import "/wap/Public/Home/css/jquery.datepick.css";</style> 
<script type="text/javascript" src="/wap/Public/Home/js/date/jquery.datepick.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/date/jquery.datepick-zh-CN.js"></script>
<script src="/wap/Public/Home/js/img/uploadPreview.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
$(document).ready(function(){
	if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
				$("header").css("display","none");	
				//$(".nav1").css("display","none");	
	  }	
	$('#biuuu').datepick({dateFormat: 'yy-mm-dd'}); 
	$("#imgShow").click(function(){$("#up_img").click();})
	$("#up_img").click(uploadPreview({ UpBtn: "up_img", DivShow: "imgdiv", ImgShow: "imgShow" }));
});
//-->
</script>

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
input{border:none;text-align:center;padding:5px 0px;}
.submit{background:#1b8b80;width:60%;height:30px;color:#FFF;font-weight:bold}
</style>
</head>
<body>
<header id="header">
<a href="/wap/index.php/Home/Index/member"><img src="/wap/Public/Home/img/fanhui.png"></a>用户信息
<a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="user">
<form action="/wap/index.php/Home/Index/infoupdate" method="post" enctype="multipart/form-data">

<ul>
<li>头像<span style="display:block;width:160px;text-align:center;"><mark><div id="imgdiv"><img src="http://www.chahuitong.com/data/upload/shop/avatar/<?php echo ($info["member_avatar"]); ?>" id="imgShow"></div></mark><input type="file" name="member_avatar" id="up_img" style="display:none"></span></li>
<li>用户名<span><input type="text" name="member_truename" placeholder='<?php echo ($info["member_truename"]); ?>'></span></li>
<li>昵称<span><input type="text" name="member_name" value="<?php echo ($info["member_name"]); ?>"></span></li>
<li>性别<span style="display:block;width:160px;text-align:center;"><?php if($info["member_sex"] == '1'): ?><input type="radio" name="member_sex" value="1" checked="checked">男
<input type="radio" name="member_sex" value="2" >女
<?php else: ?>
<input type="radio" name="member_sex" value="1" >男
<input type="radio" name="member_sex" value="2" checked="checked">女<?php endif; ?></span></li>
<li>出生日期<span><input type="data" name="member_birthday" value="<?php echo ($info["member_birthday"]); ?>" id="biuuu"></span></li>
</ul>

<input type="submit" class="submit" value="提交">

</form>
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