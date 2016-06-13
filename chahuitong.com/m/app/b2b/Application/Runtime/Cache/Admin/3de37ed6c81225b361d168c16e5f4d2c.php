<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>客户服务管理后台-修改音乐信息</title>
<link rel="stylesheet" type="text/css" href="/myCustomer/Public/Admin/css/admin.css" />
<script type="text/javascript" src="/myCustomer/Public/Admin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/myCustomer/Public/static/WdatePicker.js"></script>
<script type="text/javascript" src="/myCustomer/Public/Admin/js/formValidatorRegex.js"></script>
<script type="text/javascript" src="/myCustomer/Public/Admin/js/formValidator.js"></script>
<link rel="stylesheet" type="text/css" href="/myCustomer/Public/Admin/js/validator.css" />
<script type="text/javascript">
</script>
</head>
<style type="text/css">
.col_five{
	display:inline-block;
	border:1px solid #fbaa01;
	background-color:#fbaa01;
	color:white;
	padding:5px;
}
.admin_box input{
	margin-bottom:10px;
}
#myForm div{
	float:left;
	width:18%;
	overflow:hidden;
	padding:10px;
	margin-bottom:10px;
	height:200px;
}
#myForm div img{
	width:80%;
}
</style>
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
<a href="<?php echo U('Index/direct');?>" target="_blank">生成首页</a>
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
<form action="<?php echo U('Music/update_db');?>" method="post" id="myForm" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo ($data["id"]); ?>"/>
<div>
音乐1:<input type="file" name="music1" id="music1"/><br>
<?php if($data["music1"] != ''): ?><audio id="aaa" src="/myCustomer/Public//upload/com_logo/<?php echo ($data["music1"]); ?>" controls="controls"></audio><?php endif; ?>
</div>
<div>
音乐2:<input type="file" name="music2" id="music2"/><br>
<?php if($data["music2"] != ''): ?><audio id="aaa" src="/myCustomer/Public//upload/com_logo/<?php echo ($data["music2"]); ?>" controls="controls"></audio><?php endif; ?>
</div>
<div>
音乐3:<input type="file" name="music3" id="music3"/><br>
<?php if($data["music3"] != ''): ?><audio id="aaa" src="/myCustomer/Public//upload/com_logo/<?php echo ($data["music3"]); ?>" controls="controls"></audio><?php endif; ?>
</div>
<div>
音乐4:<input type="file" name="music4" id="music4"/><br>
<?php if($data["music4"] != ''): ?><audio id="aaa" src="/myCustomer/Public//upload/com_logo/<?php echo ($data["music4"]); ?>" controls="controls"></audio><?php endif; ?>
</div>
<div>
音乐5:<input type="file" name="music5" id="music5"/><br>
<?php if($data["music5"] != ''): ?><audio id="aaa" src="/myCustomer/Public//upload/com_logo/<?php echo ($data["music5"]); ?>" controls="controls"></audio><?php endif; ?>
</div>
<select name="selected">
<option value="<?php echo ($data["selected"]); ?>" selected="selected">音乐<?php echo ($data["selected"]); ?></option>
<option value="<?php echo ($data["music1"]); ?>">音乐1</option>
<option value="<?php echo ($data["music2"]); ?>">音乐2</option>
<option value="<?php echo ($data["music3"]); ?>">音乐3</option>
<option value="<?php echo ($data["music4"]); ?>">音乐4</option>
<option value="<?php echo ($data["music5"]); ?>">音乐5</option>
</select>
<input type="submit" value="提交"/>
</form>
</div>
</body>
</html>