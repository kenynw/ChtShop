<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title></title><meta name="keywords" content="茶汇通,普洱,普洱茶">
<meta name="description" content="茶汇通普洱饼茶">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/class.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/list.css" type="text/css" rel="stylesheet">
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script src="/wap/Public/Home/js/jquery.cookie.js"></script>
<script>
 $(document).ready(function(){
	 
	 $("#pic").click(function(){
		 
		 $("#jies").toggle(function(){
			 
			 if($("#pic").attr("src")=="/wap/Public/Home/img/down.png"){
				 
				 $("#pic").attr("src","/wap/Public/Home/img/up.png");
				 
				 }else{
					 
				$("#pic").attr("src","/wap/Public/Home/img/down.png");	 
					 }
			 
			 });
		 		 
		 });
		 
	/*加入收藏*/
	
	$("#fav").click(function(){
		
		//alert($.cookie("username"));
		
		if($.cookie("key")==""||$.cookie("username")==""){			
			$("#show").html("您还未登陆");			
			$("#show").show();		
			setTimeout(function(){				
				$("#show").hide();			
				},3000);			
			}else{
			
			var bid=$("input[name='bid']").val();
							
			$.ajax({
				url:"/wap/index.php/Home/Index/fav",
				type:"post",
				dataType:"json",
				data:{bid:bid,type:"brand"},
				success: function(data){	
				     //alert(data);				
					  if(data.code==200){
						  $("#show").html(data.content);			
		               	$("#show").show();		
		               	setTimeout(function(){				
			            	$("#show").hide();			
			            	},3000);	
						  
						  }else{
							$("#show").html(data.content);			
		               	$("#show").show();		
		               	setTimeout(function(){				
			            	$("#show").hide();			
			            	},3000);	
							  
							  }
					
					}
								
				})					
				}		
	
		
		})	 
		
   /*产品排序*/
   
   $(".order").change(function(){
	   
	   var id=$(this).children('option:selected').val();
	   
	   if(id!=0){
		   
		  var url="/wap/index.php/Home/Index/brandGoods/bid/<?php echo ($bid); ?>/showway/"+id;
		  
		  window.location.href=url;
		   	   
		   }
	   
	   
	   
	   })
   /*end 产品排序*/
   
   /*分享代码*/
   $("#shares").click(function(){
	   
	   $(".share").show();
	   
	   })
	   
  $("#share").click(function(){
	   
	   $(".share").hide();
	   
	   })	   
  				 	 	 
	 })
	
</script>

</head>
<body style="background:#FFF">
<!--分享代码-->
<div class="share" style="background:#333;opacity:0.5;position:fixed;top:0px;right:0px;width:100%;height:40px;z-index:900;display:none "></div><div class="share" id="share" style="background:#333;opacity:0.5;position:fixed;top:0px;left:0px;width:15%;height:40px;z-index:999;display:none;color:#F00;text-align:center;line-height:40px;font-weight:bold">X</div>
<div class="share" style="position:fixed;top:0px;right:0px;width:55%;height:40px;z-index:999;display:none"><div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script></div>

<!--end分享-->
<header id="header">
<a href="javaScript:window.history.back();"><img src="/wap/Public/Home/img/fanhui.png"></a><span id="title"><?php echo ($name["brand_name"]); ?></span>
<a href="http://www.chahuitong.com/wap"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<input type="hidden" name="bid" value="<?php echo ($bid); ?>">
<div class="brand" style="width:100%;background:#FFF"><img src="/wap/Public/upload/<?php echo ($brandImage); ?>" width="100%"></div>
<div class="jieshao" style="border-top: 1px solid #c9c9c9;
  margin-top: 45px;
  position: relative;
  padding-top: 40px;
  background:#FFF;">
<h3 style="background: #fff;
  width: 50%;
  line-height: 36px;
  display: inline-block;
  position: absolute;
  top: -18px;
  left: 25%;">品牌介绍<img id="pic" src="/wap/Public/Home/img/down.png"></h3>
<p id="jies" style="  text-indent: 2em;
  text-align: left;
  color: #585858;
  line-height: 25px;
  overflow: hidden;
  width: 90%;
  margin: 0 auto;"><?php echo ($desc); ?></p>
</div>
<!--列表标题-->
<div style="border-top: 1px solid #c9c9c9;
  margin-top: 45px;
  position: relative;
  padding-top: 40px;">
<h3 style="background: #fff;
  width: 50%;
  line-height: 36px;
  display: inline-block;
  position: absolute;
  top: -18px;
  left: 25%;
  index: 9;">
  商品列表<select class="order" name="order" >
  <option value="0">排序</option>
  <option value="1" <?php if($showway == 1): ?>selected='selected'<?php endif; ?> >价格</option>
  <option value="2" <?php if($showway == 2): ?>selected='selected'<?php endif; ?>>最新</option>
  <option value="3" <?php if($showway == 3): ?>selected='selected'<?php endif; ?>>热度</option>
  <option value="4" <?php if($showway == 4): ?>selected='selected'<?php endif; ?>>销量</option>
  </select>
 </h3>
</div>
<!--列表标题-->
<div class="mail">
<div class="list" style="margin-top:1px">

<?php if(is_array($brandgoods)): $i = 0; $__LIST__ = $brandgoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><div class="show">
<div class="title">
<a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($value["goods_id"]); ?>"><img src="http://www.chahuitong.com/data/upload/shop/store/goods/<?php echo ($value["store_id"]); ?>/<?php echo ($value["goods_image"]); ?>"><h3 style="font-weight:500"><?php echo ($value["goods_name"]); ?></h3></a>
</div>
<div class="jiage">
    <?php if($value["goods_promotion_price"] != ''): ?><mark>￥<?php echo ($value["goods_promotion_price"]); ?></mark>
        <?php else: ?>
        <mark>￥<?php echo ($value["goods_price"]); ?></mark><?php endif; ?>
    <a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($value["goods_id"]); ?>"><img src="/wap/Public/Home/img/you.png"></a>
</div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</div>
<div id="show" style="color:white;background:#F00;width:100%;height:30px;line-height:30px;text-align:center;position:fixed;top:40%;left:0;display:none"></div>
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
<script>
window.onload=function(){
	var title=$("#title").html();
	
	$("title").html(title);
	
	
	
	if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
		$("header").hide();
		$(".header").hide();
		//$("#topss").css('display','none');
		//$(".focus").css("margin-top","0px");
		//alert("1111");
		//document.getElementById("topss").style.display="none";
	  }
}
</script>
</html>