<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>茶市</title>
<meta name="keywords" content="茶汇通,普洱,普洱茶">
<meta name="description" content="茶汇通普洱饼茶">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/mobile/app/b2b/Public/Home/css/share.css" type="text/css" rel="stylesheet">
<link href="/mobile/app/b2b/Public/Home/css/chashi.css" type="text/css" rel="stylesheet">
<script src="/mobile/app/b2b/Public/Home/js/qiugou.js"></script>
</head>
<body>
<header id="header">
<a href="javaScript:window.history.back();"><img src="/mobile/app/b2b/Public/Home/img/fanhui.png"></a>茶市<a href="/mobile/app/b2b/index.php/Home/Index/fabu"><img src="/mobile/app/b2b/Public/Home/img/home.png"></a>
</header>
<header>
<nav>
<a href="/mobile/app/b2b/index.php/Home/Index/brand">行情</a>
<a class="on" href="/mobile/app/b2b/index.php/Home/Index/sale">出售</a>
<a  href="/mobile/app/b2b/index.php/Home/Index/buy">求购</a>
<a href="/mobile/app/b2b/index.php/Home/Index/myList">发布</a>
</nav>
</header>
<div class="list">
<ul>
<?php if(is_array($all)): $i = 0; $__LIST__ = $all;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
<a href="/mobile/app/b2b/index.php/Home/Index/info/id/<?php echo ($v["id"]); ?>" style="color:#CCC">
<div class="pic">

<?php if($v["pic"] != ''): ?><img class="picimg" src="/mobile/app/b2b/Public/upload/<?php echo ($v["pic"]); ?>" width="101" height="101">
<?php else: ?>
<img class="picimg" src="/mobile/app/b2b/Public/Home/img/nopic.jpg" width="101" height="101"><?php endif; ?>
</div>
</a>
<!--新样式-->
<a href="/mobile/app/b2b/index.php/Home/Index/info/id/<?php echo ($v["id"]); ?>" style="color:#333">
<div name="text" class="text"><h5><?php echo ($v["name"]); ?><span><?php echo ($v["addtime"]); ?></span></h5>
<p><?php echo ($v["content"]); ?></p>
</a>
<div class="shop">
<?php if($v["arrow_order"] == 1): ?>￥<?php echo ($v["price"]); ?>
<?php else: ?>
价格详谈<?php endif; ?><span><a href="/mobile/app/b2b/index.php/Home/Index/info/id/<?php echo ($v["id"]); ?>">详情</a></span></div>
</div>
<!--end-->

</li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
<style>
 .page{padding-top:2em;text-align:center;}
.page a{display:inline-block;width:30px;padding:5px 10px;margin:0 10px;font-size:14px}
.page span{display:inline-block;width:30px;padding:5px 10px;font-size:14px}
</style>
<div class="page">
  <?php echo ($page); ?>
</div>

</body>
</html>