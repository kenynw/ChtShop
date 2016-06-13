<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加地址</title>
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
   <a href="javascript:history.go(-1)"><img src="/wap/Public/Home/img/fanhui.png"></a>收货地址
   <a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
  </header>
    <div class="address-opera">
        <div class="address-ocnt">
            <div class="address-octlt">收货人信息</div>
            <p>姓名：<span class="opera-tips">(*必填)</span></p>
            <p>
                <input type="text" id="true_name" class="input-30" name="true_name"/>
            </p>
            <p>手机号码：<span class="opera-tips">(*必填)</span></p>
            <p>
                <input type="tel" id="mob_phone" class="input-30" name="mob_phone"/>
            </p>
            <!--<p>电话号码：</p>
            <p>
                <input type="text"  class="input-30" name="tel_phone"/>
            </p>-->
            <div class="address-octlt">地址信息</div>
            <p>省份：<span class="opera-tips">(*必填)</span></p>
            <div class="new-select-wp" id="prov">
		        <select class="select-30" id="prov_select" name="prov">
					<option value="">请选择...</option>
		        </select>	
            </div>
            <p>城市：<span class="opera-tips">(*必填)</span></p>
            <div class="new-select-wp"  id="city">
		 		<select class="select-30" id="city_select" name="city">
					<option value="">请选择...</option>
		        </select>           	
            </div>
            <p>区县：<span class="opera-tips">(*必填)</span></p>
            <div class="new-select-wp" id="region">
		       	<select class="select-30" id="region_select" name="region">
					<option value="">请选择...</option>
		        </select>
            </div>
            <p>街道：<span class="opera-tips">(*必填)</span></p>
            <p>
                <input type="text" class="input-30" id="address" name="address">
            </p>
        </div>
        <div class="error-tips"></div>
        <a class="add_address mt10" href="javascript:;">保存地址</a>
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
<script>
window.onload = function(){
	var tel = document.getElementById('mob_phone');
	tel.onkeyup = function(){
		var str = tel.value;
		var num = str.length;
		if(num > 11){
			tel.value = str.slice(0,11);
		}else{
			tel.value = parseInt(str)?parseInt(str):'';
		}
	}
}
</script>
    <script type="text/javascript" src="/wap/Public/Home/js/zepto.min.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/config.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/template.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/common.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/simple-plugin.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/common-top.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/address_opera.js"></script>
    <script type="text/javascript">
	if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
		       $("#header").hide();	
	           }
	</script>
</body>
</html>