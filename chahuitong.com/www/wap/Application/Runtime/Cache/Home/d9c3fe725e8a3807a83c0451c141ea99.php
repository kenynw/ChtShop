<?php if (!defined('THINK_PATH')) exit();?><!Doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/reset.css">
<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/main.css">
<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/category.css">
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script>
 $(document).ready(function(){
	 	 
   //客户端去头部	
	if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
		$("header").hide();
		$(".header").hide();
		$(".nav1").css("display","none");
		//$("#topss").css('display','none');
		//$(".focus").css("margin-top","0px");
		//alert("1111");
		//document.getElementById("topss").style.display="none";
	  }	
	//end 客户端去头部


	 
	 var cid=$("ul li:first").attr('class');
	 $.post(
     "/wap/index.php/Home/Index/secondcg",
	 {id:cid},	 
     function(data) {
        $(".second_cg").html(data);
     },
      "text"
      )	
	  
	   $(".searchspan").click(function(){
		
        var keyword = encodeURIComponent($('.cg_sc').val());
        location.href ="/wap/index.php/Home/index/product_list?keyword="+keyword;
                  });
	  
	  $("li").click(function(){
		 
         var cid;
		 cid=$(this).attr('id');
		 $("li").attr('class','off');
		 $(this).attr('class','on');
		  $.post(
         "/wap/index.php/Home/Index/secondcg",
	     {id:cid},	 
          function(data) {
           $(".second_cg").html(data);
           },
           "text"
           )	
	 
		 })
	  
	    
	  
	 })
	 	 
</script>
</head>
<body>
<div class="main">
 <div class="header"><div class="arrowleft"><a href="/wap/index.php/Home/Index/index" style="display:block;width:40px;height:45px"></a></div><div class="cg_search"><div class="sg"><input class="cg_sc" value="" type="text"><span class="searchspan"></span></div></div></div>
 <div class="cg">
 <div class="cg_left">
  <ul>
  <?php if(is_array($class)): $k = 0; $__LIST__ = $class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($k % 2 );++$k; if($k == 1): ?><li id="<?php echo ($value["gc_id"]); ?>" class='on'><span class="class_name"><?php echo ($value["gc_name"]); ?></span></li> 
    <?php else: ?>
    <li id="<?php echo ($value["gc_id"]); ?>" class='off'><span class="class_name"><?php echo ($value["gc_name"]); ?></span></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
  </ul>
  </div>
 <div class="cg_right">
  <div class="cg_right_top"><a href="#"><img src="/wap/Public/Home/img/cg_right.png"></a></div>
  <div class="second_cg">

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
$(document).ready(function(){
    $('.class_name').click(function(){
		$('.class_name').removeClass("bor-close");
		$(this).parent().prev().find('.class_name').addClass("bor-close");
	});
});
</script>
</html>