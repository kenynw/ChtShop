<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>客户服务管理后台-登录</title>
<link rel="stylesheet" type="text/css" href="/myCustomer/Public/Admin/css/admin.css" />
<script type="text/javascript" src="/myCustomer/Public/Admin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
$(function(){
	//登录
	$("#login_button").click(function(){
		$(".hint_info").text("欢迎使用客户服务管理后台");
		$.ajax({
			type:"POST",
			url:"<?php echo U('Index/login');?>",
			data:{"name":$("#name").val(),"password":$("#password").val()},
			success:function(data){
				if(data!=0){
					window.location.href="<?php echo U('Admin/index');?>";
				}else{
					$(".hint_info").text("登录失败，请检查！");
				}
			},
		});
	});
})
</script>
</head>
<body>
<div id="content">
<div class="login_box">
<div class="login_box1">
<div>
<input type="text" placeholder="用户名" name="name" id="name"/>
</div>
<div>
<input type="password" placeholder="密码" name="password" id="password"/>
</div>
<input type="button" value="登录" id="login_button" style="cursor:pointer"/>
<div class="hint_info">欢迎使用客户服务管理后台</div>
</div>
</div>
</div>
</body>
</html>