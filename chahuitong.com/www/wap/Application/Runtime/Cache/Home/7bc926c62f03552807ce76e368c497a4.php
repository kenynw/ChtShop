<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>我的评价</title>
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/class.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/dingdan.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/wap/Public/Home/js/jquery-1.7.1.min.js"></script>
<script>
$(document).ready(function(){
	 if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
				$("header").css("display","none");	
				//$(".nav1").css("display","none");	
	  }	
	$(".star").each(function(){
		var n=$(this).attr("id");
		
		for(var m=0;m<n;m++){
			
			$(this).append("<span></span>")
			
			
			}
		
		
		})
    $('.content').each(function(){
        var h=$(this).height();
		var i=(h-25)/2;
		$(this).find('label').css("top",i);
    });
});
</script>
</head>
<style>
.pingfen{color:#787878;font-size:1.1em;text-align:left;margin-top:8px;}
.pingfen .star span{display:inline-table;background:url(/wap/Public/Home/img/redstar.png) no-repeat;background-position:center;background-size:24px 24px;width:24px;height:24px;margin-right:3px; vertical-align:middle;}
.pingfen_t{float:left;width:30%;}
.pingfen p{letter-spacing:5px;line-height:30px;}
.pingfen p mark{background:#fff;color:#787878;margin-right:8px;}
.p_right p{border-bottom:1px solid #dcdddd;}
.p_right p:last-child{border:none;}
</style>
<body>
<header id="header">
<a href="/wap/index.php/Home/Index/member"><img src="/wap/Public/Home/img/fanhui.png"></a>我的评价
<a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="mail">
<?php if(is_array($eval)): $i = 0; $__LIST__ = $eval;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="pingjia">
<ul>
<li><label>时间/金额</label><span class="p_right"><span class="yuan"></span><time><?php echo ($v["geval_addtime"]); ?></time><span class="shifu">实付：<mark><?php echo ($v["geval_goodsprice"]); ?></mark></span></span></li>
<li><label>商家/产品</label><span class="p_right"><a href="#"><?php echo ($v["seval_storename"]); ?></a><a class="c_title" href="#"><?php echo ($v["geval_goodsname"]); ?></a></span></li>
<li class="pingfen">
<label class="pingfen_t">动态评分</label><span class="p_right">
<p><mark></mark><span class="star" id="<?php echo ($v["geval_scores"]); ?>">
</p>

</li>
<li class="content"><label>评价内容</label><span class="p_right"><?php echo ($v["geval_content"]); ?></span></li>
</ul>
</div><?php endforeach; endif; else: echo "" ;endif; ?>

</div>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?9a15ea23e7316c631085bb3ef722599a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>