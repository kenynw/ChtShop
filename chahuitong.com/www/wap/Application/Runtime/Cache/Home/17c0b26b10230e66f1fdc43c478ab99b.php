<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>所有品牌</title>
<meta name="keywords" content="茶汇通,普洱,普洱茶">
<meta name="description" content="茶汇通普洱饼茶">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/class.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/brand.css" type="text/css" rel="stylesheet">
<style>
    #.scroll a{color:black}
</style>
<script type="text/javascript" src="/wap/Public/Home/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
	   
	   $.post("/wap/index.php/Home/Index/brandAjax",
	          {catId:<?php echo ($catId); ?>},
			  function(data){
				  var json=eval(data.content.brands);
                  $("#scroll").html('');
                  if(data.content.adv) {
                      $("#scroll").html('<a href="' + data.content.adv.goods_link + '">' + data.content.adv.slogan + '</a>')
                  }
				  //alert()				  
				  var html='';
				   for(var i=0;i<=json.length;i++){				   				  
					  $(".loading").remove();  
					  $(".brand").append("<li><a href='/wap/index.php/Home/Index/brandGoods/bid/"+json[i].brand_id+"'><img src=http://www.chahuitong.com/data/upload/shop/brand/"+json[i].brand_pic+"><p>"+json[i].brand_name+"</p></a></li>");
					  $(".brand").append('<span class="loading"><img src="http://www.chahuitong.com/wap/Public/Home/img/loader.gif" width="16px" height="16px"></span>')		  
					  }
				   
				  },
               "json"    			   
			  )  
         $("#nav a").click(function(){
			 var cs='';
			 cs=$(this).attr("id");
			 var name=$(this).html();
			 $("#nav a").removeAttr("class");
			 $(this).addClass("on")		
			$.post(
			  "/wap/index.php/Home/Index/brandAjax",
			  {catId:cs},
			  function(data){
				  
				  $(".type").html(name);
				  var json=eval(data.content.brands);
                  $("#scroll").html('');
                  if(data.content.adv) {
                      $("#scroll").html('<a href="' + data.content.adv.goods_link + '">' + data.content.adv.slogan + '</a>')
                  }
				  $(".brand").html('<span class="loading"><img src="http://www.chahuitong.com/wap/Public/Home/img/loader.gif" width="16px" height="16px"></span>');
				  for(var i=0;i<=json.length;i++){	
				     $(".loading").remove();  
					  $(".brand").append("<li><a href='/wap/index.php/Home/Index/brandGoods/bid/"+json[i].brand_id+"'><img src=http://www.chahuitong.com/data/upload/shop/brand/"+json[i].brand_pic+"><p>"+json[i].brand_name+"</p></a></li>");
					  $(".brand").append('<span class="loading"><img src="http://www.chahuitong.com/wap/Public/Home/img/loader.gif" width="16px" height="16px"></span>')		
				       }
				  },
				  "json"
			
		     	)
 
			 })
			 
	 $(".find").click(function(){
		 
		 $(".search").show();
		 
		 })	
		 
	 $(".search-btn2").click(function(){
		 
		 $(".search").hide();
		 
		 
		 
		 })	
		 
	 $("#search-btn1").click(function(){
		 
		 var key=$("#key2").val();
		 
		 window.location.href="/wap/index.php/Home/Index/product_list?keyword="+key;
		 
		 
		 })	  	 
			 			 
	 })

</script>
</head>
<body>
<header id="header">
<a href="javaScript:window.history.back();"><img src="/wap/Public/Home/img/fanhui.png"></a>商城<a href="http://www.chahuitong.com/wap"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<marquee style="width:100;margin-top:30px;border:1px solid #d9d9d9;line-height:30px;" id="scroll"> 1111 </marquee>
<header class="header">
<span class="type"><?php if($catId == 1): ?>普洱茶<?php endif; if($catId == 2): ?>乌龙茶<?php endif; if($catId == 3): ?>红茶<?php endif; if($catId == 256): ?>绿茶<?php endif; if($catId == 308): ?>黑茶<?php endif; if($catId == 470): ?>黄茶<?php endif; if($catId == 530): ?>白茶<?php endif; if($catId == 662): ?>茶具<?php endif; if($catId == 593): ?>其它<?php endif; ?></span>
<a href="#" class="find"><img src="/wap/Public/Home/img/sousuo02.png"></a>
</header>
<div>
<div class="mail">
<!--搜索框-->
<div class="search">
<input type="text" class="htsearch-input clr-999" id="key2" value="" placeholder="搜索你想要的茶">
<span class="search-btn1" id="search-btn1"><img src="/wap/Public/Home/img/sousuobrand.png"></span>
<span class="search-btn2" >X</span>
</div>

<!--end 搜索框-->

<div class="list">
<ul class="brand">
 <span class="loading"><img src="/wap/Public/Home/img/loader.gif" width="16px" height="16px"></span>
</ul>
</div>
</div>
<div id="nav" class="nav">
<?php if(is_array($cats)): $key = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($key % 2 );++$key; if($v['gc_id'] == $catId): ?><a class="on" id="<?php echo ($v["gc_id"]); ?>"><?php echo ($v["gc_name"]); ?></a>
  <?php else: ?>
  <a id="<?php echo ($v["gc_id"]); ?>"><?php echo ($v["gc_name"]); ?></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
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
window.onload=function(){	
	if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
		$("header").hide();
		$(".header").hide();
		$(".nav").css("top","0px");
		$(".nav1").css("display","none");
		$(".list").css("margin-top","33px");
		//$("#topss").css('display','none');
		//$(".focus").css("margin-top","0px");
		//alert("1111");
		//document.getElementById("topss").style.display="none";
	  }	
}
</script>
</body>
</html>