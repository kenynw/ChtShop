<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>普洱饼茶</title><meta name="keywords" content="茶汇通,普洱,普洱茶">
<meta name="description" content="茶汇通普洱饼茶">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/class.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/list.css" type="text/css" rel="stylesheet">
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script>
$(document).ready(function(){
	
	var id;
	
    id=$("#class").val();
	
	$("#a1").click(function(){
		 $("#sort").attr('value',1);
		 $("#page").attr('value',1);
		
		  $.post(
		  " /wap/index.php/Home/Index/select",
		  {id:id,orderway:1},
		  function(data){			 
			  $('body,html').animate({scrollTop:0},500);
			  $(".list").html(data);
			  $(".list").append('<div id="Loading"><img src="/wap/Public/Home/img/loader.gif"></div>');
			  
			  },
			  
		"text"	  	  
		  )
				
		})
	$("#a3").click(function(){
		 $("#sort").attr('value',3);
		 $("#page").attr('value',1);		
		  $.post(
		  " /wap/index.php/Home/Index/select",
		  {id:id,orderway:3},
		  function(data){			 
			  $('body,html').animate({scrollTop:0},500);
			  $(".list").html(data);
			  $(".list").append('<div id="Loading"><img src="/wap/Public/Home/img/loader.gif"></div>');
			  
			  },
			  
		"text"	  	  
		  )
				
		})	
	$("#a4").click(function(){
		 $("#sort").attr('value',4);
		 $("#page").attr('value',1);		
		  $.post(
		  " /wap/index.php/Home/Index/select",
		  {id:id,orderway:4},
		  function(data){			 
			  $('body,html').animate({scrollTop:0},500);
			  $(".list").html(data);
			  $(".list").append('<div id="Loading"><img src="/wap/Public/Home/img/loader.gif"></div>');
			  
			  },
			  
		"text"	  	  
		  )
				
		})		
	$("#a2").click(function(){
		  $("#sort").attr('value',2);
		  $("#page").attr('value',1);
		  
		  $.post(
		  " /wap/index.php/Home/Index/select",
		  {id:id,orderway:2},
		  function(data){
			  $('body,html').animate({scrollTop:0},500);
			  $(".list").html(data);
			  $(".list").append('<div id="Loading"><img src="/wap/Public/Home/img/loader.gif"></div>');
			  
			  },
			  
		"text"	  	  
		  )
				
		})	
	 
		
	var stop=true; 
    $(window).scroll(function(){ 
     totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()); 
     if($(document).height() <= totalheight){ 
         if(stop==true){ 
            stop=false; 
			var orderway;
			var page;
			page=Number($("#page").val())+1;
			orderway=$("#sort").val();
			$("#page").attr('value',page);
			orderway=$("#sort").val();
             $.post("/wap/index.php/Home/Index/select", 
			  {id:id, orderway:orderway,page:page},
			  function(txt){ 
                 $("#Loading").before(txt); 
                 stop=true; 
              },"text"); 
          } 
       } 
      });
		
	
	})
</script>
</head>
<body>
<header>
<a href="/wap"><img src="/wap/Public/Home/img/fanhui.png"></a>普洱饼茶
<a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="mail">
<input type="hidden" id="class" value="<?php echo ($gc_id); ?>">
<input type="hidden" id="sort" value="1">
<input type="hidden" id="page" value="1">
<div id="nav" class="nav">
<ul>
<li><a id="a1" href="#a1" >销量</a></li>
<li><a id="a2" href="#a2">价格</a></li>
<li><a id="a3" href="#a3">年份</a></li>
<li><a id="a4" href="#a4">形状</a></li>
</ul>
</div>

<div class="list">

<?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><div class="show">
<div class="title">
<a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($value["goods_id"]); ?>"><img src="http://www.chahuitong.com/data/upload/shop/store/goods/<?php echo ($value["store_id"]); ?>/<?php echo ($value["image_url"]); ?>"><h3 style="font-weight:500"><?php echo ($value["goods_name"]); ?></h3></a>
</div>
<div class="jiage">
<img src="/wap/Public/Home/img/jiage.gif"><mark><?php echo ($value["goods_price"]); ?></mark><a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($value["goods_id"]); ?>"><img src="/wap/Public/Home/img/you.png"></a>
</div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>
<div id="Loading"><img src="/wap/Public/Home/img/loader.gif"></div>
</div>



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
<script>

window.onload=function(){
	
	if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
		$("header").hide();
		$(".nav").css("top","0px");		
	  }else{
		var nav=document.getElementById("nav");
	window.onscroll=function(){
		var scrollTop=document.body.scrollTop||document.documentElement.scrollTop;
		if(scrollTop<40){
			nav.style.top=40-scrollTop+'px';
		}else{
			nav.style.top="0px";
		}
	}  
		  
		  }
	
}

</script>
</html>