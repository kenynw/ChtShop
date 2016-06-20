<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>客户服务管理后台-修改客户流程信息</title>
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
<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="step">
<form action="<?php echo U('Process/update_db');?>" method="post">
<h1>
<?php if($vo["step"] == 1): ?>试衣<?php endif; ?>
<?php if($vo["step"] == 2): ?>摄影<?php endif; ?>
<?php if($vo["step"] == 3): ?>选样<?php endif; ?>
<?php if($vo["step"] == 4): ?>定稿<?php endif; ?>
<?php if($vo["step"] == 5): ?>取件<?php endif; ?>
</h1>

<input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>" id="id">
<input type="hidden" name="step" value="<?php echo ($vo["step"]); ?>" id="step">

跟单人：
<br>
<select name="actor_id">
<?php if($vo["actor_id"] != ''): ?></else>
<option selected="selected" value="<?php echo ($vo["actor_id"]); ?>"><?php echo ($vo["actor"]); ?>--<?php echo ($vo["utype"]); ?></option>
<option value="">不选择</option>
<?php if(is_array($data1)): $i = 0; $__LIST__ = $data1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo1["id"]); ?>"><?php echo ($vo1["name"]); ?>--<?php echo ($vo1["user_type"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select><?php endif; ?>
<br>
<select name="actor_id1">
<?php if($vo["actor_id1"] != ''): ?></else>
<option selected="selected" value="<?php echo ($vo["actor_id1"]); ?>"><?php echo ($vo["actor1"]); ?>--<?php echo ($vo["utype1"]); ?></option>
<option value="">不选择</option>
<?php if(is_array($data1)): $i = 0; $__LIST__ = $data1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo1["id"]); ?>"><?php echo ($vo1["name"]); ?>--<?php echo ($vo1["user_type"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select><?php endif; ?>
<br><br>
时间：
<input type="text" value="<?php echo ($vo["process_date"]); ?>" name="process_date" id="process_date" onclick="WdatePicker()"/><br>
地点：
<input type="text" value="<?php echo ($vo["address"]); ?>" name="address" id="address"/><br>
温馨提示：
<textarea class="content_hint" name="content"><?php echo ($vo["content"]); ?></textarea>
<input type="submit" value="提交" class="subButton"/>
</form>
</div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</body>
</html>