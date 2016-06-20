<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>茶汇通</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="Keywords" content="茶汇通,茶叶网购,茶叶电商,茶叶商城,普洱茶" />
<meta name="Description" content="茶汇通，茶叶电子商务综合服务平台，最大的茶叶网购专业平台" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta property="qc:admins" content="275530757363010514767637577107" />
<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/reset.css">
<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/main.css">
<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/index.css">
<script src="/wap/Public/Home/js/TouchSlide.1.1.js"></script>
</head>
<body>
<header class="main">
	<div class="header-wrap" style="display:none">
		<div class="htsearch-wrap with-home-logo">
			<input type="text" class="htsearch-input clr-999" value="" id="keyword" placeholder="搜索商品"/>
			<a href="javascript:void(0);" class="search-btn"></a>
		</div>
	</div>
</header>
<div class="main" id="main-container"></div>
 
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?9a15ea23e7316c631085bb3ef722599a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<script type="text/html" id="adv_list">
    <!--add by lai 15-5-27-->
	<?php if($khd != '1'): ?><div class="top" id="topss"><img src="/wap/Public/Home/img/logof.png"></div><?php endif; ?>
     <!--end by lai -->
	 <div id="focus" class="focus">
				<div class="hd">
					<ul></ul>
				</div>
				<div class="bd">
					<ul>
						<% for (var i in item) { %>
			<li>
				<a href="<%= item[i].url %>">
					<img src="<%= item[i].image %>" alt=""></a>
				</li>
		<% } %>
					</ul>
		</div>
	  </div>
	
	<!--add by lai 2015-5-27-->
	<div class="region row row_category">
  <ul class="flex flex-f-row">
  	        <li class="flex_in"> <a href="/wap/index.php/Home/Index/xianshi" title="闪购"> <img src="/wap/Public/Home/img/1405655662572425140.png"> </a>
      <p>闪购</p>
    </li>
                <li class="flex_in"> <a href="http://www.chahuitong.com/mobile/app/b2b/index.php/Home/index/index" title="茶市"> <img src="/wap/Public/Home/img/1427677257169333785.png"> </a>
      <p>茶市</p>
    </li>
                <li class="flex_in"> <a href="http://wsq.qq.com/reflow/264487503?type=browser" title="微社区"> <img src="/wap/Public/Home/img/1405655652755144849.png"> </a>
      <p>微社区</p>
    </li>
                <li class="flex_in"> <a href="http://www.chahuitong.com/mobile/app/b2b/index.php/News/Index/index" title="山头"> <img src="/wap/Public/Home/img/1426121287439107380.png"> </a>
      <p>山头</p>
    </li>
                <li class="flex_in"> <a href="/wap/index.php/Home/news" title="资讯"> <img src="/wap/Public/Home/img/1426121270890361197.png"> </a>
      <p>资讯</p>
    </li>
  </ul>
  
</div>
  <div class="search">
   <div class="searchcontent">
   <input type="text" class="htsearch-input clr-999" id='key2' value=""  placeholder="搜索你想要的茶"/>
   <span class="search-btn1" id="search-btn1"><img src="/wap/Public/Home/img/sousuo.png">搜索</span>
   </div>
  </div>
    <!--end-->
</script>
<script type="text/html" id="home1">
	<div class="index_block home1">
	<% if (title) { %>
		<div class="title"><%= title %></div>
	<% } %>
		<div class="content">
			<div class="item">
				<a href="<%= url %>">
					<img src="<%= image %>" alt="">
				</a>
			</div>
		</div>
	</div>
</script>
<script type="text/html" id="home2">
	<div class="index_block home2">
	<% if (title) { %>
		<div class="title"><%= title %></div>
	<% } %>
		<div class="content">
			<div class="item home2_1">
				<a href="<%= square_url %>"><img src="<%= square_image %>" alt=""></a>
			</div>
			<div class="item home2_2">
				<div class="border-left">
					<div class="border-bottom">
						<a href="<%= rectangle1_url %>"><img src="<%= rectangle1_image %>" alt=""></a>
					</div>
					<div>
						<a href="<%= rectangle2_url %>"><img src="<%= rectangle2_image %>" alt=""></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</script>
<script type="text/html" id="home3">
	<div class="index_block home3">
	<% if (title) { %>
		<div class="title"><%= title %></div>
	<% } %>
		<div class="content">
		<% for (var i in item) { %>
			<div class="item">
				<a href="<%= item[i].url %>"><img src="<%= item[i].image %>" alt=""></a>
			</div>
		<% } %>
		</div>
	</div>
	
</script>
<script type="text/html" id="home4">
	<div class="index_block home2">
	<% if (title) { %>
		<div class="title"><%= title %></div>
	<% } %>
		<div class="content">
			<div class="item home2_2">
				<div class="border-right">
					<div class="border-bottom">
						<a href="<%= rectangle1_url %>"><img src="<%= rectangle1_image %>" alt=""></a>
					</div>
					<div>
						<a href="<%= rectangle2_url %>"><img src="<%= rectangle2_image %>" alt=""></a>
					</div>
				</div>
			</div>
			<div class="item home2_1">
				<a href="<%= square_url %>"><img src="<%= square_image %>" alt=""></a>
			</div>
		</div>
	</div>
	<!--add by lai 2015-5-27-->
	<div class="brand">
	 <div class="brand_left"></div>
	
	 <div class="brand_right">
	   <ul>
	   <?php if(is_array($recommend)): $i = 0; $__LIST__ = $recommend;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><li class="brandLi"><div class="img"><a href="/wap/index.php/Home/Index/brandGoods/bid/<?php echo ($value["brand_id"]); ?>"><img src="http://www.chahuitong.com/data/upload/shop/brand/<?php echo ($value["brand_pic"]); ?>"></a></div></li><?php endforeach; endif; else: echo "" ;endif; ?>
	   </ul>
	 </div>
	</div>	
	<!---->
	<!--begin 第二个轮播图-->
	<!-- 本例主要代码 Start ================================ -->
			<div id="slideBox" class="slideBox">
				<div class="bd">				   
					<ul>
					 <?php if(is_array($pics)): $i = 0; $__LIST__ = $pics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
							<a class="pic" href="<?php echo ($v["link_url"]); ?>"><img src="http://www.chahuitong.com/data/upload/shop/common/<?php echo ($v["link_pic"]); ?>" /></a>
							<a class="tit" href="<?php echo ($v["link_url"]); ?>"><?php echo ($v["link_title"]); ?></a>
							
						</li><?php endforeach; endif; else: echo "" ;endif; ?>	
					</ul>
					<a class="more" href="/wap/zhuanti.html" ><font style="color:grey">|</font>&nbsp;MORE&nbsp;></a>
				</div>

				<div class="hd">
					<ul></ul>
				</div>
			</div>
	<!--限时特够 即闪购-->
	<div class="index_block home2">
	
		<div class="content">
			<div class="item home2_1" style="position:relative">
			    <span class="item_span"><?php echo ($xianshi[0]['end_time']); ?>天</span>
				<a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($xianshi[0]['goods_id']); ?>"><img src="/wap/Public/Home/img/1.png" alt=""></a>
			</div>
			<div class="item home2_2" style="position:relative">
			<span class="item_span"><?php echo ($xianshi[1]['end_time']); ?>天</span>
			<span class="item_span" style="top:50%"><?php echo ($xianshi[0]['end_time']); ?>天</span>
				<div class="border-left">
					<div class="border-bottom">
						<a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($xianshi[1]['goods_id']); ?>"><img src="/wap/Public/Home/img/2.png" alt=""></a>
					</div>
					<div>
						<a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($xianshi[2]['goods_id']); ?>"><img src="/wap/Public/Home/img/3.png" alt=""></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<h1 style="text-align:center;height:30px;line-height:30px;background:#fff"><a href="/wap/index.php/Home/Index/xianshi" style="color:grey;font-size:14px;color:#900">更多闪购&nbsp;></a></h1>
	
	<!--end 闪购-->
	<!--底部图片-->
	<div class="bottomimg">
	<img src="/wap/Public/Home/img/2_32.png">
	<p><img src="/wap/Public/Home/img/2_34.png">品质保证<img src="/wap/Public/Home/img/2_36.png">特色服务<img src="/wap/Public/Home/img/2_38.png">品类齐全</p>
	</div>
	<!--底部图片-->
</script>
<script type="text/html" id="goods">
	<div class="index_block goods">
	<% if (title) { %>
		<div class="title"><%= title %></div>
	<% } %>
		<div class="content">
		<% for (var i in item) { %>
			<div class="goods-item">
				<a href="tmpl/product_detail.html?goods_id=<%= item[i].goods_id %>">
					<div class="goods-item-pic"><img src="<%= item[i].goods_image %>" alt=""></div>
					<div class="goods-item-name"><%= item[i].goods_name %></div>
					<div class="goods-item-price">￥<%= item[i].goods_promotion_price %></div>
				</a>
			</div>
		<% } %>
		</div>
	</div>
</script>
    

<script type="text/javascript" src="/wap/Public/Home/js/jquery.min.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/config.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/zepto.min.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/template.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/common.js"></script>

<script type="text/javascript" src="/wap/Public/Home/js/index.js"></script>


</body>
</html>