<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>客户服务管理后台-影楼信息</title>
<link rel="stylesheet" type="text/css" href="/myCustomer/Public/Admin/css/admin.css" />
<script type="text/javascript" src="/myCustomer/Public/Admin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/myCustomer/Public/Admin/js/formValidatorRegex.js"></script>
<script type="text/javascript" src="/myCustomer/Public/Admin/js/formValidator.js"></script>
<link rel="stylesheet" type="text/css" href="/myCustomer/Public/Admin/js/validator.css" />
</head>
<style type="text/css">
.col_three{
	display:inline-block;
	border:1px solid #fbaa01;
	background-color:#fbaa01;
	color:white;
	padding:5px;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
	
	$.formValidator.initConfig({formID:"myForm",debug:false,submitOnce:false,
		onError:function(msg,obj,errorlist){
			alert(msg);
		},
	});
	
	$("#name").formValidator({onShow:"请输入影楼名称",onFocus:"影楼名称不可为空",onCorrect:"填写正确"})
	.inputValidator({min:"3",onError:"影楼名称长度大于三位"});
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
<a href="<?php echo U('Index/direct');?>">生成首页</a>
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
<form action="<?php echo U('Company/update_db');?>" method="post" enctype="multipart/form-data" id="myForm">
<input type="hidden" value="<?php echo ($data["id"]); ?>" name="id" />
<input type="hidden" value="<?php echo ($data["logo"]); ?>" name="logo1" />
影楼名称：<input type="text" maxlength="20" value="<?php echo ($data["name"]); ?>" name="name" id="name"/><span id="nameTip"></span><br>
<br>
影楼LOGO：
<a href="/myCustomer/Public//upload/com_logo//<?php echo ($data["logo"]); ?>" target="_blank" title="点击查看高清大图">
<img src="/myCustomer/Public//upload/com_logo//<?php echo ($data["logo"]); ?>" style="width:100px;vertical-align: middle;"/>
</a>
<br>
<input type="file" name="logo" id="logo"/>
1M以内
<br>
<br>
官方主页：
<input type="text" maxlength="50" style="width:200px" value="<?php echo ($data["homepage"]); ?>" name="homepage" id="homepage"/><span id="homepageTip"></span>
<br>
<br>
客服电话：
<input type="text" maxlength="15" value="<?php echo ($data["custom_service"]); ?>" name="custom_service" id="custom_service"/><span id="custom_serviceTip"></span>
<br>
<br>
总经理电话：
<input type="text" maxlength="15" value="<?php echo ($data["manager"]); ?>" name="manager" id="manager"/><span id="managerTip"></span>
<br>
<br>
<input type="submit" value="更改" />
</form>
</div>
</body>
</html>