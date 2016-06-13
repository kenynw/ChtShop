<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
		body, html,#allmap {width: 100%;height: 100%;margin:0;}
	</style>
	<script type="text/javascript" src="http://api.map.baidu.com/api?type=quick&ak=9sE2sS7rMGs1ZGAP6GNsmWM0&v=1.0"></script>
	<title>地图官网展示效果</title>
</head>
<body>
	<a id="golist" href="../demolist.htm">返回demo列表页</a>
	<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("allmap");            // 创建Map实例
	var point = new BMap.Point(116.404, 39.915); // 创建点坐标
	map.centerAndZoom(point,15);                 // 初始化地图,设置中心点坐标和地图级别。
	map.addControl(new BMap.ZoomControl());      //添加地图缩放控件
</script>