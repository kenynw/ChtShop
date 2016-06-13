<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>客户服务管理后台-添加客户信息</title>
<link rel="stylesheet" type="text/css" href="/myCustomer/Public/Admin/css/admin.css" />
<script type="text/javascript" src="/myCustomer/Public/Admin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/myCustomer/Public/static/WdatePicker.js"></script>
<script type="text/javascript" src="/myCustomer/Public/Admin/js/formValidatorRegex.js"></script>
<script type="text/javascript" src="/myCustomer/Public/Admin/js/formValidator.js"></script>
<link rel="stylesheet" type="text/css" href="/myCustomer/Public/Admin/js/validator.css" />
</head>
<style type="text/css">
.col_four{
	display:inline-block;
	border:1px solid #fbaa01;
	background-color:#fbaa01;
	color:white;
	padding:5px;
}
.admin_box input{
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
	
	$("#name").formValidator({onShow:"请输入姓名",onFocus:"姓名长度不小于两位",onCorrect:"填写正确"})
	.inputValidator({min:"2",onError:"姓名长度不小于两位"});
	$("#telphone").formValidator({onShow:"请输入电话",onFocus:"电话长度等于十一位",onCorrect:"填写正确"})
	.regexValidator({regExp:"intege1",dataType:"enum",onError:"电话格式不正确"});
	$("#deal_date").formValidator({onShow:"请输入日期",onFocus:"请选择日期",onCorrect:"填写正确"})
	.inputValidator({min:"2",onError:"日期有误"});
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
<a href="<?php echo U('Customer/index');?>" class="col_four">客户&流程</a>
</li>
<li>
<a href="<?php echo U('First/index');?>" class="col_five">先睹为快</a>
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
<form action="<?php echo U('Customer/save_db');?>" method="post" id="myForm">
姓名:<input type="text" name="name" id="name"/>
<span id="nameTip"></span>
<br>
电话:<input type="text" maxlength="11" name="telphone" id="telphone"/>
<span id="telphoneTip"></span>
<br>
订单日期:<input type="text" name="deal_date" id="deal_date" onclick="WdatePicker()"/>
<span id="deal_dateTip"></span>
<br>
<input type="submit" value="提交"/>
</form>
</div>
</body>
</html>