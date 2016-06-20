<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>搜索结果</title>
<script src="/mobile/app/b2b/Public/Home/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/Home/css/b2b.css" />
<script type="text/javascript">
	$(function(){
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
<a class="backButton" href="javascript:history.go(-1)">返回</a>
<h3 class="pageTitle">茶市</h3>
<a class="queryButton" id="cx" href="/mobile/app/b2b/index.php/Home/Index/search">查询</a>
</div>
<div style="height:50px;"></div>

<!-- 内容 -->
<div class="content">
<!-- 内容正文 -->
<div class="cBody">

<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item">
<div class="mHead">
<span class="shougou">
<?php if($vo["saleway"] == 1): ?>出售
<?php else: ?>购买<?php endif; ?>
</span>

</div>
<div class="imgThumbnail" >
<img src="/mobile/app/b2b/Public/upload/<?php echo ($vo["pic"]); ?>"/>
</div>
<a href="/mobile/app/b2b/index.php/Home/Index/info/id/<?php echo ($vo["id"]); ?>.html">
<div class="cDetail">
<span class="cTitle"><?php echo ($vo["name"]); ?></span><br/>
<span class="cDescribe"><?php echo ($vo["brand"]); ?>-<?php echo ($vo["name"]); ?></span>  
<div class="cPrice"><?php echo ($vo["price"]); ?></div>
<hr>
<div class="cTime"><?php echo ($vo["addtime"]); ?></div>
</div>
</a>
</div><?php endforeach; endif; else: echo "" ;endif; ?>

</div>
</div>
<div style="height:50px;"></div>
<div class="foot">
<a href="<?php echo U('Index');?>">首页</a>
<a href="<?php echo U('Index/post');?>">发布</a>
<a href="http://www.chahuitong.com/mobile/user.php">用户中心</a>
<a href="<?php echo U('Index/news');?>">消息</a>
<a href="<?php echo U('Index/myList');?>">我的</a>
</div>
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