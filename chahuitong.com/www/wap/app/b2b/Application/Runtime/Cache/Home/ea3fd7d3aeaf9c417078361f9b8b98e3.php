<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>我的发布</title>
<script src="/mobile/app/b2b/Public/Home/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/Home/css/b2b.css" />
<script type="text/javascript">
	$(document).ready(function() {
	
		var navi = navigator.userAgent;
	if(navi.indexOf("android")!=-1||navi.indexOf("ios")!=-1){
		$(".head").hide();
		$(".height").hide();
		$("nav").hide();
	}
    
});
</script>
<style type="text/css">
.item{
	border:none;
	margin-top: -7px;
  	margin-bottom: 18px;
}
.imgThumbnail {
  margin-top: 7px;
}
.cBody{
	width:100%;
}
body{
	background-color:#e9e9e7;
}
.cTime{
	background-color:#f9f9f9;
}
.cPrice{
	margin-right:5px;
}
.cDetail {
  background-color: #f9f9f9;
  padding-bottom: 5px;
}
</style>
</head>
<body>
<!-- 头部 -->
<div class="head">
<a class="backButton" href="http://www.chahuitong.com/mobile/app/b2b/index.php/Home/Index">返回</a>
<h3 class="pageTitle">茶市</h3>
<a class="queryButton" id="cx" href="/mobile/app/b2b/index.php/Home/Index/search">查询</a>
</div>
<div class="height" style="height:50px;"></div>

<!-- 内容 -->
<div class="content">
<!-- 内容正文 -->
<div class="cBody" style="padding-bottom:50px;">

<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item">
<div class="mHead">
<span class="shougou">
<?php if($vo["saleway"] == 1): ?>出售
<?php else: ?>求购<?php endif; ?>
</span>
<span class="del" data-id="<?php echo ($vo["id"]); ?>">删除</span>
</div>
<div class="imgThumbnail" >
<?php if($vo["pic"] != ''): ?><img class="picimg" src="/mobile/app/b2b/Public/upload/<?php echo ($vo["pic"]); ?>">
<?php else: ?>
<img class="picimg" src="/mobile/app/b2b/Public/Home/img/nopic.jpg"><?php endif; ?>
</div>
<a href="/mobile/app/b2b/index.php/Home/Index/info/id/<?php echo ($vo["id"]); ?>.html">
<div class="cDetail">
<span class="cTitle"><?php echo ($vo["name"]); ?></span><br/>
<span class="cDescribe">年份：<?php echo ($vo["year"]); ?> 数量<?php echo ($v["number"]); ?></span>  
<div class="cPrice">价格:<?php echo ($vo["price"]); ?></div>
<span class="cDescribe"><?php echo ($vo["brand"]); echo ($v["name"]); ?></span> 
<hr style="border: 1px dashed #ccc; width: 100%; height: 1px;">
<div class="cTime"><?php echo ($vo["addtime"]); ?></div>
</div>
</a>
</div><?php endforeach; endif; else: echo "" ;endif; ?>

</div>
</div>
<nav id="bottomTab" style="z-index:999">
<style>.nav_on{color: #a15641;}</style>
<a href="/mobile/app/b2b/index.php/Home/Index/index"><img src="/mobile/app/b2b/Public/Home/img/shouyeno.jpg"><br>首页</a>
<a  href="/mobile/app/b2b/index.php/Home/Index/post"><img src="/mobile/app/b2b/Public/Home/img/fabu.jpg"><br>发布</a>
<a  href="/mobile/app/b2b/index.php/Home/Index/news"><img src="/mobile/app/b2b/Public/Home/img/xiaoxi.jpg"><br>信息</a>
<a class="nav_on" href="/mobile/app/b2b/index.php/Home/Index/myList"><img src="/mobile/app/b2b/Public/Home/img/users1.png"><br>我的</a>
</nav>
<script type="text/javascript">
	$(function(){
		$(".del").click(function(){
			if(!confirm("是否删除？")){
				return false;
			}
			var id=$(this).data("id");
			var tem=$(this);
			$.ajax({
				type:"POST",
				url:"/mobile/app/b2b/index.php/Home/Index/delete/id/"+id,
				success:function(data){
					if(data!=-1){
						tem.parent().parent().fadeOut();
					}
				}
			})
		})
	})
</script>
</body>
</HTML>