<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的收藏</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/main.css">
	<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/member.css">
</head>
<body>
<header>
     <a href="javascript:history.go(-1)"><img src="/wap/Public/Home/img/fanhui.png"></a>我的收藏
     <a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
     </header>
    <!--<header id="header"></header>-->
    <div class="favorites-list" id="favorites_list"></div>
    <script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?9a15ea23e7316c631085bb3ef722599a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
    <script type="text/html" id="sfavorites_list">
     <%if(favorites_list.length>0){%>
		 <ul>
			<%for(var i=0;i<favorites_list.length;i++){%>
            <li>
                <a href="/wap/index.php/Home/Index/goods?goods_id=<%=favorites_list[i].fav_id %>" class="mf-item clearfix">
                    <span class="mf-pic">
                        <img src="<%=favorites_list[i].goods_image_url %>"/>
                    </span>
                    <div class="mf-infor">
                        <p class="mf-pd-name"><%=favorites_list[i].goods_name %></p>
                        <p class="mf-pd-price">￥<%=favorites_list[i].goods_price %></p>
                        <p class="mf-pd-comment">&nbsp;</p>
                        <span class="i-del" goods_id="<%=favorites_list[i].fav_id %>"></span>
                    </div>
                </a>
            </li>
			<%}%>
        </ul>
        <%}else{%>
        <div class="no-record">
            暂无记录
        </div>
       <%}%>
	</script>
    <script type="text/javascript" src="/wap/Public/Home/js/config.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/zepto.min.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/template.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/common.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/common-top.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/favorites.js"></script>
   
</body>
</html>