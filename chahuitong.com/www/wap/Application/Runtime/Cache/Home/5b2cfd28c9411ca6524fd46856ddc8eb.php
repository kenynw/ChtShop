<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>通知中心</title>
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
	var type=$("input[name='type']").val();
	$.post(
	     "/wap/index.php/Home/Index/msgapi",
	    {type:type},
	     function(data){	
		 var d=eval("("+data+")");	
		 var json=d.date;	 
		 var html='';
		 $(".notice").html("");			
		 for(var i=0;i<json.length;i++){
			 if(json[i]['message_title']==null){
				 json[i]['message_title']="未定义标题";
				 }	
			  /*替换查看物流信息*/	 	
			  json[i]['message_body']=json[i]['message_body'].replace('http://www.chahuitong.com/shop/index.php?act=member_order&op=show_order&order_id','http://www.chahuitong.com/wap/tmpl/member/order_delivery.html?order_id');	 	 
            $(".notice").append("<li><h5><label><img src='/wap/Public/Home/img/notice.png'>"+json[i]['message_title']+"</label><span><mark></mark>"+getLocalTime(json[i]['message_time'])+"</span></h5><p>"+json[i]['message_body']+"<span></span></p><div class='delete'>删除</div></li>");
               }		     
	    	}	
      	)
				
	$('#nav span').click(function(){
		$('#nav span').removeClass('on');
		$(this).addClass('on');
		var id=$(this).attr("id");
		$("input[name='type']").val(id);
		var type=$("input[name='type']").val();
		$.post(
	     "/wap/index.php/Home/Index/msgapi",
	    {type:type},
	     function(data){	
		 var d=eval("("+data+")");	
		 var json=d.date;	 
		 var html='';
		 $(".notice").html("");			
		 for(var i=0;i<json.length;i++){
			 if(json[i]['message_title']==null){
				 json[i]['message_title']="未定义标题";
				 }	
			 json[i]['message_body']=json[i]['message_body'].replace('http://www.chahuitong.com/shop/index.php?act=member_order&op=show_order&order_id','http://www.chahuitong.com/wap/tmpl/member/order_delivery.html?order_id');	 		 
            $(".notice").append("<li><h5><label><img src='/wap/Public/Home/img/notice.png'>"+json[i]['message_title']+"</label><span><mark></mark>"+getLocalTime(json[i]['message_time'])+"</span></h5><p>"+json[i]['message_body']+"<span></span></p><div class='delete'>删除</div></li>");
               }		     
	    	}	
      	)
	});
	
	function getLocalTime(nS) {     
   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
        }     
});
</script>
<style>
.mail #nav{padding-bottom:3px;}
</style>
</head>
<body id="box">
<header id="header">
<a href="javascript:history.go(-1)"><img src="/wap/Public/Home/img/fanhui.png"></a>通知中心
<a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="mail">
<div id="nav">
<span class="on" id="0">私信</span><span id="1">系统消息</span><span id="2">留言</span>
<input name="type" type="hidden" value="2">
</div>
<ul class="notice">
<li><img src="loader"></li>
</ul>
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