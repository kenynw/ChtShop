<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<title>消息</title>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/Home/css/common.css">
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/Home/css/b2b.css">
<script src="/mobile/app/b2b/Public/Home/js/jquery-1.4.4.min.js"></script>
<script>
$(document).ready(function() {
	
		var navi = navigator.userAgent;
	if(navi.indexOf("android")!=-1||navi.indexOf("ios")!=-1){
		$(".head").hide();
		$(".height").hide();
	}
    
});
</script>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
<meta charset="utf-8">
</head>

<body>
<div id="main">
  
<div class="head">
<a class="backButton" href="http://www.chahuitong.com/mobile/app/b2b/index.php/Home/Index">返回</a>
<h3 class="pageTitle">茶市</h3>
<a class="queryButton" id="cx" href="/mobile/app/b2b/index.php/Home/Index/search">查询</a>
</div>
<div class="height" style="height:50px;"></div>

 <div id="box_main">
   <div class="main_content" style="padding-bottom:70px">
     <ul class="news_ul">
     <?php if(is_array($newslist)): $i = 0; $__LIST__ = $newslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($v[isRead] == 0): ?><li style="background:#FFF">
       
       <div class="news_img">
        <?php if($own == $v['fid']): ?>我：
          <?php else: ?>
          &nbsp;&nbsp;对方：<?php endif; ?>
        
       </div>
       <div class="news_content"><h1><?php echo ($v["title"]); ?></h1>
       <p style="height:20px;overflow:hidden"><?php echo ($v["content"]); ?></p>
         
       </div>
       <div class="news_date">
        <p><?php echo ($v["addtime"]); ?></p>
       </div>
      
       </li>
      
       <?php else: ?>
        
       <li style="background:#FFF">
       
       <div class="news_img">
        <img src="/mobile/app/b2b/Public/upload/<?php echo (get_img($v["pid"])); ?>" width="50px" height="auto">
        
       </div>
       <div class="news_content"><h1><?php echo ($v["title"]); ?></h1>
       <p><?php echo ($v["content"]); ?></p>
       </div>
       <div class="news_date">
        <p><?php echo ($v["addtime"]); ?></p>
       </div>
      
       </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
     </ul>  
     <form action="/mobile/app/b2b/index.php/Home/Index/newssave" method="post">
       
        <div class="title" style="width:90%;margin:0 auto;height:100px;padding-bottom:10px;text-align:center">  
         <textarea name="content" style="width:100%;height:60px">     
     
          </textarea>
          <input type="hidden" name="uid" value="<?php echo ($uid); ?>">
          <input type="hidden" name="cid" value="<?php echo ($cid); ?>">
          <input type="hidden" name="pid" value="<?php echo ($pid); ?>"> 
          <input type="hidden" name="fid" value="<?php echo ($own); ?>">       
          <input type="submit" style="background: #a15641;
color: white;
border: none;
height: 35px;
line-height:35px;width:50px;border-radius:5px;font-size:16px;" value="提交">
         </div>
     
     </form>
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