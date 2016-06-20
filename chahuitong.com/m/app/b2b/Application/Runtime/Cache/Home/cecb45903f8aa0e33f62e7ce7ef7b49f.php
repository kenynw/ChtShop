<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<title>消息</title>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/Home/css/common.css">
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/Home/css/b2b.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
<meta charset="utf-8">
<script src="/mobile/app/b2b/Public/Home/js/jquery-1.4.4.min.js" type="text/javascript"></script>
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
</head>

<body>
<div id="main">
  
<div class="head">
<a class="backButton" href="http://www.chahuitong.com/mobile/app/b2b/index.php/Home/Index">返回</a>
<h3 class="pageTitle">茶市</h3>
<a class="queryButton" id="cx" href="/mobile/app/b2b/index.php/Home/Index/search">查询</a>
</div>
<div class="height" style="height:50px;"></div>

 <div id="box_main" style="height:auto;position:relative;padding-bottom:60px;">
   <div class="main_content">

     <ul class="news_ul">
     <?php if(is_array($newslist)): $i = 0; $__LIST__ = $newslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="/mobile/app/b2b/index.php/Home/Index/newslist/cid/<?php echo ($v["cid"]); ?>/pid/<?php echo ($v["pid"]); ?>">
       <li>     
       <div class="news_img">
        <img src="/mobile/app/b2b/Public/upload/<?php echo (get_img($v["pid"])); ?>" width="50px" height="auto">        
       </div>
       <div class="news_content"><h1>消息提示</h1>
       <p>
       <?php if($own == $v['cid']): ?>您针对-<?php echo (get_name($v["pid"])); ?>-的提问 </p>      
         <?php else: ?>      
       您的产品-<?php echo (get_name($v["pid"])); ?>-有供求的信息</p><?php endif; ?>
       </div>
       <div class="news_date">
        <p><?php echo ($v["addtime"]); ?></p>
       </div>
      
       </li>
        </a><?php endforeach; endif; else: echo "" ;endif; ?>
     </ul>  
     
   </div>
 </div>
<nav id="bottomTab">
<a href="/mobile/app/b2b/index.php/Home/Index/index"><img src="/mobile/app/b2b/Public/Home/img/shouyeno.jpg"><br>首页</a>
<a  href="/mobile/app/b2b/index.php/Home/Index/post"><img src="/mobile/app/b2b/Public/Home/img/fabu.jpg"><br>发布</a>
<a style="color:#a15641" class="nav_on" href="/mobile/app/b2b/index.php/Home/Index/news"><img src="/mobile/app/b2b/Public/Home/img/xiaoxi1.jpg"><br>信息</a>
<a href="/mobile/app/b2b/index.php/Home/Index/myList"><img src="/mobile/app/b2b/Public/Home/img/user.jpg"><br>我的</a>
</nav>
</div>
</body>
</html>