<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>客户服务管理后台-添加管理员信息</title>
<link rel="stylesheet" type="text/css" href="/myCustomer/Public/Admin/css/admin.css" />
<script type="text/javascript" src="/myCustomer/Public/Admin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/myCustomer/Public/Admin/js/formValidatorRegex.js"></script>
<script type="text/javascript" src="/myCustomer/Public/Admin/js/formValidator.js"></script>
<link rel="stylesheet" type="text/css" href="/myCustomer/Public/Admin/js/validator.css" />
</head>
<style type="text/css">
.col_one{
	display:inline-block;
	border:1px solid #fbaa01;
	background-color:#fbaa01;
	color:white;
	padding:5px;
}
.admin_box input,select{
	margin-bottom:10px;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
	
	$.formValidator.initConfig({formID:"myForm",debug:false,submitOnce:false,
		onError:function(msg,obj,errorlist){
			alert(msg);
		},
	});
	
	$("#login_name").formValidator({onShow:"请输入用户名",onFocus:"用户名长度不小于3",onCorrect:"填写正确"})
	.inputValidator({min:"3",onError:"用户名长度不小于3"});
	
	$("#password").formValidator({onShow:"请输入密码",onFocus:"密码长度不小于6",onCorrect:"填写正确"})
	.inputValidator({min:"6",onError:"密码长度不小于6"});
})
</script>
<body>
<div class="menu">
<ul>
<li>
<a href="<?php echo U('Admin/index');?>" class="col_one">管理员</a>
</li>
<li>
<a href="<?php echo U('Actor/index');?>" class="col_two">角色</a>
</li>
<li>
<a href="<?php echo U('Company/index');?>" class="col_three">公司</a>
</li>
<li>
<a href="<?php echo U('Customer/index');?>" class="col_four">客户-流程</a>
</li>
<li>
<a href="<?php echo U('Music/update_f');?>" class="col_five">音乐管理</a>
</li>
<li>
<a style="cursor:pointer" class="out">退出</a>
</li>
</ul>
</div>
<script type="text/javascript">
$(function(){
	$(".out").click(function(){
		window.location.href="<?php echo U('Index/out');?>";
	})
})
</script>
<div class="admin_box">
<form action="<?php echo U('Admin/add_db');?>" method="post" id="myForm">
姓名:<input type="text" placeholder="登录名" name="login_name" id="login_name" maxlength="10"/>
<span id="login_nameTip"></span>
<br>
密码:<input type="password" placeholder="密码" name="password" id="password" maxlength="20"/>
<span id="passwordTip"></span>
<br>
类型:
<select name="admin_type">
<option value="2">普通管理员</option>
<option value="3">信息发布员</option>
</if>
</select><br>
状态:
<select name="admin_status">
<option value="1">启用</option>
<option value="0">禁用</option>
</select><br>
<input type="submit" value="提交"/>
</form>
</div>
</body>
</html>