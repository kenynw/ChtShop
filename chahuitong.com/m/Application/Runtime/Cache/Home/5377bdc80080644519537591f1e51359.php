<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>产品详情</title><meta name="keywords" content="茶汇通,普洱,普洱茶,茶">
	<meta name="description" content="茶汇通">
	<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
	<link href="/wap/Public/Home/css/class.css" type="text/css" rel="stylesheet">
	<link href="/wap/Public/Home/css/details.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="share" style="background:#333;opacity:0.5;position:fixed;top:0px;right:0px;width:100%;height:40px;z-index:900;display:none "></div>
<div class="share" id="share" style="background:#333;opacity:0.5;position:fixed;top:0px;left:0px;width:15%;height:40px;z-index:999;display:none;color:#F00;text-align:center;line-height:40px;font-weight:bold">X</div>
<div class="share" style="position:fixed;top:0px;right:0px;width:55%;height:40px;z-index:999;display:none"><div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
	<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script></div>
<div id="product_detail_wp"></div>

<script type="text/html" id="product_detail">
	<header id="header">
		<a href="javaScript:window.history.back();"><img src="/wap/Public/Home/img/fanhui.png"></a><h5 style="width:70%;height:30px;text-align:center;overflow:hidden;display:inline-block"><%=goods_info.goods_name%></h5>
		<a href="http://www.chahuitong.com/wap"><img src="/wap/Public/Home/img/home.png"></a>
	</header>
	<div class="mail">
		<div id="focus" class="focus">
			<div class="hd">
				<ul></ul>
			</div>
			<div class="bd">
				<ul >
					<% for(var i =0;i<goods_image.length;i++){　%>
					<li><img src="<%=goods_image[i]%>"/></li>
					<%}%>
				</ul>
			</div>
		</div>
		<h5><%=goods_info.goods_name%></h5>
		<input type="hidden" class="buy-num fleft" id="buynum" value="1"/>
		<div class="xiaol">
			<mark><% if(goods_info.promotion_price){ %>促销价：￥<%=goods_info.promotion_price%><% }else{ %>￥<%=goods_info.goods_price%><%}%></mark><span class="span">销量<b><%=goods_info.goods_salenum%></b></span><span class="span">收藏量<b><%=goods_info.goods_collect%></b></span><span>总评价<b><%=goods_info.evaluation_count%></b></span>
		</div>
		<div class="details">
			<ul>
				<li>
					<h4 class="close">产品参数<div></div></h4>
					<ul id="a1" class="chanshu">
						<li><span>&nbsp;</span>品牌：<?php echo ($brand_name); ?></li>
						<li><span>&nbsp;</span>类型：<?php echo ($info["gc_name"]); ?></li>
						<?php if(is_array($info['goods_attr'])): $i = 0; $__LIST__ = $info['goods_attr'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li><span>&nbsp;</span><?php echo ($v["0"]); ?>：<?php echo ($v["1"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</li>
				<li>
					<h4 class="close">产品详情<div></div></h4>
					<ul id="a1" class="xq">
						<?php echo ($info["goods_body"]); ?>
					</ul>
				</li>
				<li>
					<h4 class="close">用户口碑<div></div></h4>
					<ul id="a1" class="pingjia">
						<?php if(is_array($evals)): $i = 0; $__LIST__ = $evals;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
								<div class="wenzi">
									<div class="yuan"></div>
									<time><?php echo ($v["geval_addtime"]); ?></time>
									<hgroup><?php echo ($v["geval_content"]); ?></hgroup>
								</div>
								<div class="head">
									<img src="/data/upload/shop/avatar/<?php echo ($v["img"]); ?>"><br>
									<?php echo ($v["geval_frommembername"]); ?>
								</div>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</li>
				<li>
					<h4 class="open">其他相关<div></div></h4>
					<div id="a1" class="qita" style="display:block;">

						<%for (var i = 0;i<goods_commend_list.length;i++){%>
						<div class="show">
							<div class="title">
								<a href="goods?goods_id=<%=goods_commend_list[i].goods_id%>">
									<img src="<%=goods_commend_list[i].goods_image_url%>">

									<p><%=goods_commend_list[i].goods_name%></p>
							</div>
							<div class="jiage">
								<mark>￥<%=goods_commend_list[i].goods_price%></mark>
								<span>详情</span></a>
							</div>
						</div>
						<%}%>

					</div></li></ul></div></div>
	<div id="dialog" style="display:none;position:fixed;top:45%;left:0;width:100%;z-index:999;color:white;text-align:center;padding:10px 5px;background:red;"><div style="">aaaaaaaa</div></div>
	<nav>
		<a href="#" class="pd-collect"><img src="/wap/Public/Home/img/collection.png">收藏</a>
		<a href="#" class="add-to-cart"><img src="/wap/Public/Home/img/cart.png">加入购物车</a>
		<a href="#" class="buy-now">立即购买<img src="/wap/Public/Home/img/shop.png"></a>
	</nav>

</script>
<style>
	#fanhuitop{position:fixed;right:20px;bottom:100px;display:none;}
	#fanhuitop img{width:36px;}
</style>
<div id="fanhuitop"><img src="/wap/Public/Home/img/fanhuitop.png"></div>

<script type="text/javascript" src="/wap/Public/Home/js/config.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/template.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/jquery.min.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/jquery-ui.js"></script>
<script src="/wap/Public/Home/js/TouchSlide.1.1.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/common.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/tmpl/common-top.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/tmpl/product_detail.js"></script>
<script>

	window.onload=function(){
		$(".xq p").each(function(){
			var text=$(this).html();
			var texts=text.replace(/【/g,"<br>【");
			$(this).html(texts);
		});
		setTimeout($('.xq img').removeAttr("height"),1000);
		var fanhuitop=document.getElementById("fanhuitop");
		window.onscroll=function(){
			var scrollTop=document.body.scrollTop||document.documentElement.scrollTop;
			if(scrollTop<200){
				fanhuitop.style.display="none";
			}else{
				fanhuitop.style.display="block";
			}
		}
		fanhuitop.onclick=function(){
			document.body.scrollTop=0;
		}

	};
</script>
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