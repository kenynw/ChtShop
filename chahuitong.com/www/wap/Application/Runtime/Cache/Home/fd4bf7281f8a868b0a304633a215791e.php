<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>商品评价</title>
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/class.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/wap/Public/Home/js/jquery-1.7.1.min.js"></script>
<script>
window.onload=function(){
	//var h=$('.title img').height();
	//$('.title').height(h);
	$('.store span').click(function(){
		var a=$(this).parent().find('span').index(this);
		$(this).parent().find('span:lt(' + (a+1) + ')').css("background-image","url(/wap/Public/Home/img/redstar.png)");
		$(this).parent().find('span:gt(' + a + ')').css("background-image","url(/wap/Public/Home/img/star.png)");
	    $(this).parent().find("input").val(a+1);
	});
	
	$(".product span").click(function(){
		var a=$(this).parent().find('span').index(this);
		$(this).parent().find('span:lt(' + (a+1) + ')').css("background-image","url(/wap/Public/Home/img/redstar.png)");
		$(this).parent().find('span:gt(' + a + ')').css("background-image","url(/wap/Public/Home/img/star.png)");
		$(this).parent().find("input[name='star']").val(a+1);
		//var f=$(this).parent().find("input[name='star']").val();
		
		$.ajax({
			url:"/wap/index.php/Home/Index/goodspingjiaajax",
			type:"get",
			
			dataType:"json",
					
			data:$(this).parent().find("input").serialize(),
			
			success:function(data){
				
				//writeObj(data)
				
				
				}						
			
			})
		
		
		})
	
	
	
	function writeObj(obj){ 
    var description = ""; 
    for(var i in obj){   
        var property=obj[i];   
        description+=i+" = "+property+"\n";  
    }   
    alert(description); 
} 	
	
};
</script>
<style>
.mail{width:90%;padding-bottom:45px;background:#fff;padding:0 5%;}
.pingjia{background:#fff;width:100%;padding:15px 0 0px 0;}
.title{width:100%;padding:8px 0;border-top:1px solid #c9c9c9;border-bottom:1px solid #c9c9c9;text-align:left;color:#787878;font-size:0.9em;}
.title_p{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.title p span{color:#1b8b80;}
.title img{width:20%;;float:left;border:1px solid #c9c9c9;margin-right:10px;}
label span{display:inline-table;background:url(/wap/Public/Home/img/star.png) no-repeat;background-position:center;background-size:24px 24px;width:24px;height:24px;margin-right:3px; vertical-align:middle;}
.pingfen{color:#000;font-size:1.1em;text-align:left;margin-top:8px;margin-bottom:20px;}
.pingfen_t{float:left;width:30%;line-height:90px;}
.pingfen ul li{letter-spacing:5px;line-height:30px;}
.pingfen ul li mark{background:#fff;color:#000;margin-right:8px;}
textarea{width:90%;height:80px;padding:8px 5%;border:1px solid #c9c9c9;}
.pingjia p{text-align:left;color:#000;font-size:0.9em;line-height:36px;}
.mail p{background:#fff;height:30px;}
.p_r{float:right;color:#000;}
.p_r button{background:#f5f5f5;border:none;width:80px;height:26px;border-radius:26px;margin-left:20px;font-family: "微软雅黑";}
.wrap input{display:none;}
.slider{position:relative;top:5px;right:6px;display:inline-block;width:40px;height:20px;border-radius:20px;transition:350ms;background:#f5f5f5;}
.slider::after{position:absolute;content:"";width:18px;height:18px;top:1px;left:1px;border-radius:20px;background:#fff;transition:250ms ease-in-out;}
input:checked + .slider::after{left:21px;}
input:checked + .slider{background:#1b8b80;}
</style>
</head>
<body>
<header id="header">
<a href="javascript:history.go.back()"><img src="/wap/Public/Home/img/fanhui.png"></a>商品评价
<a href="/wap/index.php/Home/Index"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="mail">
<?php if(is_array($ordergoods)): $k = 0; $__LIST__ = $ordergoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($k % 2 );++$k; if(is_array($value)): $i = 0; $__LIST__ = $value;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="pingjia" >
<div class="title"><img src="/data/upload/shop/store/goods/<?php echo ($v["store_id"]); ?>/<?php echo ($v["goods_image"]); ?>">
<p class="title_p"><?php echo ($v["goods_name"]); ?></p>
<p>实付：<span><?php echo ($v["goods_price"]); ?></span></p>

</div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>
<div class="pingfen">
<form method="post" action="/wap/index.php/Home/Index/pingajiestore">
<div class="pingfen_t">店铺评分</div>
<ul class="store">
<li><mark>产品</mark><label class="star"><span></span><span></span><span></span><span></span><span></span><input type="hidden" name="product" value="0"></label></li>
<li><mark>服务</mark><label class="star"><span></span><span></span><span></span><span></span><span></span><input type="hidden" name="service" value="0"></label></li>
<li><mark>物流</mark><label class="star"><span></span><span></span><span></span><span></span><span></span><input type="hidden" name="deliver" value="0"></label></li>
</ul>
</div>
<input type="hidden" name="store_id" value="<?php echo ($v["store_id"]); ?>"><input type="hidden" name="store_name" value="<?php echo ($v["store_name"]); ?>"><input type="hidden" name="order_id" value=<?php echo ($v["order_id"]); ?>><input type="hidden" name="orderno" value="<?php echo ($v["order_sn"]); ?>"><input type="hidden" name="buyer_id" value="<?php echo ($v["buyer_id"]); ?>">
<textarea name="content" placeholder="亲，写点什么吧，您的意见对对其他茶友有很大帮助！"></textarea>
<p><spaN class="p_r"><span class="wrap"><input type="checkbox" name="hiddenname" id="s<?php echo ($k); ?>" checked="checked" value="1"><label class="slider" for="s<?php echo ($k); ?>"></label></span>匿名<button>发表评价</button></span></p></form>
</div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<div style="width:100%;height:90px"></div>
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