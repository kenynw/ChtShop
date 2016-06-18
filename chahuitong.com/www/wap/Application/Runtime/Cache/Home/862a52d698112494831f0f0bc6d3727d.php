<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>商品详情</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/main.css">
	<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/child.css">
</head>
<body>
	<header id="header"></header>
	<div id="product_detail_wp"></div>
	<footer id="footer"></footer>
	<script type="text/html" id="product_detail">
		<div class="content">
			<div class="pddetail-cnt">
				<div class="pddc-topwp">
					<a href="javascript:void(0);" class="pddct-imgwp">
						<div id='mySwipe'class='swiper-container'>
						  <div class='swipe-wrap'>
						  <% for(var i =0;i<goods_image.length;i++){　%>
						      <div class="swipe-item"><img src="<%=goods_image[i]%>"/></div>
						   <%}%>
						  </div>
						</div>
						<div class="pddct-shadow"></div>
						<div class="pddct-name-wp">
							<div class="pddctnw-name">
								<%=goods_info.goods_name%>
							</div>
						</div>
						<span class="pd-collect">收藏</span>
						<span class="pdpic-size-bg"></span>
						<span class="pdpic-size">
							<span class="pds-cursize">1</span>
							/
							<span class="pds-tsize"><%=goods_image.length%></span>
						</span>
					</a>
				</div>
				<% if(store_info.store_qq!=null&&store_info.store_phone!=null){%>
					<div style="background: none repeat scroll 0 0 #f5f5f5;
    padding: 8px 6px 0;">
					  <span class="pddetail-go-title">联系方式
					  <div style=" float:right">
					 <% if(store_info.store_phone){%>
							<a href="tel:<%=store_info.store_phone%>" target="_blank" title="点我咨询">商家电话：<%=store_info.store_phone%>
							</a>
							<% }%>
							<% if(store_info.store_qq){%>
							<a  href="http://wpa.qq.com/msgrd?v=3&uin=<%=store_info.store_qq%>&site=qq&menu=yes" target="_blank" title="QQ:<%=store_info.store_qq%>">
							<img border="0" src="http://wpa.qq.com/pa?p=2:<%=store_info.store_qq%>:52" style=" vertical-align: middle;"/>
							</a>	
							<% }%>							
							</div>
					  </span>						
							</div>
					<%} %>
							
				<div class="pddc-gray-warp">
	                <a href="product_info.html?goods_id=<%=goods_info.goods_id%>"  class="pddetail-go-title clearfix">
	                    <span class="pgt-title fleft">
	                        图文详情
	                    </span>
	                    <span class="pgt-go fright">
	                        <span class="i-go-right"></span>
	                    </span>
	                </a>
	            </div>
				<div class="pddc-gray-warp">
	                <a href="go_store.html?store_id=<%=goods_info.store_id%>"  class="pddetail-go-title clearfix">
	                    <span class="pgt-title fleft">
	                        进入本店铺
	                    </span><span class="pgt-go fright">
	                        <span class="i-go-right"></span>
	                    </span>
	                </a>
	            </div>
				<div class="pddc-property-one pddc-gray-warp">
					<div class="pddcp-one-wp ppdc-white-wrap">
						<div class="pddcp-one-top">
							<ul>
								<%if(goods_info.goods_jingle){%>
								<li class="clearfix">
									<%=goods_info.goods_jingle%>
								</li>
								<%}%>
								<% if (goods_info.promotion_type) {
									var promo;
									switch (goods_info.promotion_type) {
										case 'groupbuy':
										promo = '抢购';
										break;
										case 'xianshi':
										promo = '限时折扣';
										break;
									}
								%>
								<li class="clearfix">
									<span class="key">促销价：</span>
									<div class="price value">
										￥<%=goods_info.promotion_price%>
									<% if (promo) { %>
										（<%= promo %>）
									<% } %>
									</div>
								</li>
								<li class="clearfix">
									<span class="key">原售价：</span>
									<div class="value"><del>￥<%=goods_info.goods_price%></del></div>
								</li>
								<% } else { %>
								<li class="clearfix">
									<span class="key">价格：</span>
									<div class="price value">
										￥<%=goods_info.goods_price%>
									</div>
								</li>
								<% } %>
								<li class="clearfix">
									<span class="key">市场价：</span>
									<div class="value"><del>￥<%=goods_info.goods_marketprice%></del></div>
								</li>
								<li class="clearfix">
									<span class="key">销量：</span>
									<div class="value"><%=goods_info.goods_salenum%>件</div>
								</li>
						<% if (goods_info.is_virtual == '1') { %>
								<li class="clearfix">
									<span class="key">提货方式：</span>
									<div class="value">电子兑换券</div>
								</li>
								<li class="clearfix">
									<span class="key">有效期：</span>
									<div class="value">
										即日起 到 <%= goods_info.virtual_indate_str %>
										<% if (goods_info.buyLimitation && goods_info.buyLimitation > 0) { %>
										（每人次限购 <%= goods_info.buyLimitation %> 件）
										<% } %>
									</div>
								</li>
						<% } else { %>
							<% if (goods_info.is_presell == '1') { %>
								<li class="clearfix">
									<span class="key">预售：</span>
									<div class="value"><%= goods_info.presell_deliverdate_str %> 日发货</div>
								</li>
							<% } %>
							<% if (goods_info.is_fcode == '1') { %>
								<li class="clearfix">
									<span class="key">购买类型：</span>
									<div class="value">F码优先购买（每个F码优先购买一件商品）</div>
								</li>
							<% } %>
						<% } %>
							</ul>
							<div class="pddcp-arrow">
								<span class="graydownarrow"></span>
							</div>
						</div>
						<div class="pddcp-one-hide">
							<div class="clearfix">
								<span class="key">商品描述：</span>
							</div>
							<p id="mobile_body">
								暂无商品描述
							</p>
						</div>
					</div>
				</div>
			<% if (gift_array && !isEmpty(gift_array)) { %>
				<div class="pddc-gray-warp">
					<ul class="ppdc-white-wrap">
						<li class="clearfix">
							<span class="key">赠品：</span>
							<div class="value">
						<% for (var k in gift_array) { var v = gift_array[k]; %>
								<div class="gift-item">
									<a href="?goods_id=<%= v.gift_goodsid %>">
										<%= v.gift_goodsname %>
									</a>
									&#215; <%= v.gift_amount %>
								</div>
						<% } %>
							</div>
						</li>
					</ul>
				</div>
			<% } %>
				<div class="pddc-gray-warp">
					<ul class="pddc-active ppdc-white-wrap">
						<li class="clearfix">
							<span class="key">活动名称：</span>
							<div class="value">
								<%if(mansong_info && mansong_info.mansong_name){%>
									<%=mansong_info.mansong_name%>
								<%}else{%>
									暂无
								<%}%>
							</div>
						</li>
						<li class="bd-tdashed-dd">
							<span class="no-key">活动描述：</span>
							<%
								if (mansong_info != null && mansong_info.rules) {
									for (var i =0;i<mansong_info.rules.length;i++){
						    %>
								<div class="no-value mt5">
									单笔订单满<span class="clr-d94 mr5 ml5"><%=mansong_info.rules[i].price%></span>元
								<% if (mansong_info.rules[i].discount > 0) { %>
									，立减<span class="clr-green mr5 ml5"><%=mansong_info.rules[i].discount%></span>元
								<% } %>
								<% if (mansong_info.rules[i].goods_id != '0') { %>
									，送礼品：
									<p class="">
										<img src="<%=mansong_info.rules[i].goods_image_url%>"/>
									<p>
								<% } %>
								</div>
								<%}}else {%>
									暂无
								<%}%>
						</li>
					</ul>
				</div>
				<div class="pddc-gray-warp">
					<ul class="pddc-stock ppdc-white-wrap">
						<li class="pddc-stock-title clearfix">
							<span class="key">库存：</span>
							<div class="price value">
								<span class="stock-num"><%=goods_info.goods_storage%></span>
								件
							</div>
						</li>
						<% if(goods_map_spec.length>0){%>
						<% for(var i =0;i<goods_map_spec.length;i++){%>
						<li class="pddc-stock-spec bd-tdashed-dd">
							<span class="key-no" spec_id="<%=goods_map_spec[i].id%>">
								<%=goods_map_spec[i].goods_spec_name%>：
							</span>
							<div class="value-no mt10">
								<%for(var j = 0;j<goods_map_spec[i].goods_spec_value.length;j++){%>
									<a href="javascript:void(0);" <%if (goods_info.goods_spec[goods_map_spec[i].goods_spec_value[j].specs_value_id]){%> class="current" <%}%>specs_value_id = "<%=goods_map_spec[i].goods_spec_value[j].specs_value_id%>">
										<%=goods_map_spec[i].goods_spec_value[j].specs_value_name%>
										<i class="pd-choice-icon"></i>
									</a>
								<%}%>
							</div>
						</li>
						<%}%>
						<%}%>
						<li class="bd-tdashed-dd">
							<span class="key-no">
								数量：
							</span>
							<div class="value-no mt10 clearfix">
								<span class="minus-wp fleft">
										<span class="i-minus"></span>
								</span>
								<input type="text" class="buy-num fleft" id="buynum" value="1"/>
								<span class="add-wp fleft">
									<span class="i-add"></span>
								</span>
							</div>
						</li>
						<li class="bd-tdashed-dd">
							<div class="opera-product-wp">
							<% if (goods_info.is_virtual == '1') { %>
								<div class="opera-pd-item buy-now">立即购买</div>
							<% } else if (goods_info.is_presell == '1') { %>
								<div class="opera-pd-item buy-now">预售购买</div>
							<% } else if (goods_info.is_fcode == '1') { %>
								<div class="opera-pd-item buy-now">F码购买</div>
							<% } else { %>
								<div class="opera-pd-item buy-now">立即购买</div>
								<%if(goods_info.promotion_type!='groupbuy'){%>
								<div class="opera-pd-item add-to-cart">加入购物车</div>
								<%}%>
							<% } %>
							</div>
						</li>
					</ul>
				</div>
				<div class="pddc-gray-warp">
					<div class="pddc-commend-list">
						<span class="pddc-commendl-title">商品推荐：</span>
						<div class="pddc-commend-wp clearfix">
							<%for (var i = 0;i<goods_commend_list.length;i++){%>
								<a href="product_detail.html?goods_id=<%=goods_commend_list[i].goods_id%>">
									<img src="<%=goods_commend_list[i].goods_image_url%>">
									<span class="pddc-commendw-t" title="<%=goods_commend_list[i].goods_name%>">
										<%=goods_commend_list[i].goods_name%>
									</span>
									<span class="pddc-commendw-price" title="￥<%=goods_commend_list[i].goods_price%>">￥<%=goods_commend_list[i].goods_price%></span>
								</a>
							<%}%>
						</div>
					</div>
				</div>
			</div>
		</div>
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
	<script type="text/javascript" src="/wap/Public/Home/js/zepto.min.js"></script>
	<script type="text/javascript" src="/wap/Public/Home/js/config.js"></script>
	<script type="text/javascript" src="/wap/Public/Home/js/template.js"></script>
	<script type="text/javascript" src="/wap/Public/Home/js/swipe.js"></script>
	<script type="text/javascript" src="/wap/Public/Home/js/common.js"></script>
	<script type="text/javascript" src="/wap/Public/Home/js/simple-plugin.js"></script>
	<script type="text/javascript" src="/wap/Public/Home/js/tmpl/common-top.js"></script>	
	<script type="text/javascript" src="/wap/Public/Home/js/tmpl/product_detail.js"></script>
</body>
</html>