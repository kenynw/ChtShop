<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>客户服务管理后台-修改先睹为快信息</title>
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
<a href="<?php echo U('Music/update_f');?>" class="col_five">生成首页</a>
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
<form action="<?php echo U('First/update_db');?>" method="post" id="myForm" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo ($data["id"]); ?>"/>
<div>
顶部图:<input type="file" name="top_img" id="top_img"/><br>
<?php if($data["top_img"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["top_img"]); ?>" /><?php endif; ?>
</div>
<div>
底部图:<input type="file" name="bottom_img" id="bottom_img"/><br>
<?php if($data["bottom_img"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["bottom_img"]); ?>" /><?php endif; ?>
</div>
<div>
图1:<input type="file" name="img1" id="img1"/><br>
<?php if($data["img1"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["img1"]); ?>" /><?php endif; ?>
</div>
<div>
图2:<input type="file" name="img2" id="img2"/><br>
<?php if($data["img2"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["img2"]); ?>" /><?php endif; ?>
</div>
<div>
图3:<input type="file" name="img3" id="img3"/><br>
<?php if($data["img3"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["img3"]); ?>" /><?php endif; ?>
</div>
<div>
图4:<input type="file" name="img4" id="img4"/><br>
<?php if($data["img4"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["img4"]); ?>" /><?php endif; ?>
</div>
<div>
图5:<input type="file" name="img5" id="img5"/><br>
<?php if($data["img5"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["img5"]); ?>" /><?php endif; ?>
</div>
<div>
图6:<input type="file" name="img6" id="img6"/><br>
<?php if($data["img6"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["img6"]); ?>" /><?php endif; ?>
</div>
<div>
图7:<input type="file" name="img7" id="img7"/><br>
<?php if($data["img7"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["img7"]); ?>" /><?php endif; ?>
</div>
<div>
图8:<input type="file" name="img8" id="img8"/><br>
<?php if($data["img8"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["img8"]); ?>" /><?php endif; ?>
</div>
<div>
图9:<input type="file" name="img9" id="img9"/><br>
<?php if($data["img9"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["img9"]); ?>" /><?php endif; ?>
</div>
<div>
图10:<input type="file" name="img10" id="img10"/><br>
<?php if($data["img10"] != ''): ?><img src="/myCustomer/Public//upload/com_logo/<?php echo ($data["img10"]); ?>" /><?php endif; ?>
</div>
<textarea name="words"><?php echo ($data["words"]); ?></textarea><br>
<input type="submit" value="提交"/>
</form>
</div>
</body>
</html>