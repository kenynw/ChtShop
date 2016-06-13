<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>茶汇通-资讯首页</title>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/News/css/news.css" />
<style type="text/css">
.feilei-items li{
	width:70px;
}
.on{
	display:block;
}
.off{
	display:none;
}
#hint{
	width:320px;
	padding:10px;
	height:50px;
	line-height:50px;
	text-align:center;
	position:fixed;
	top:50%;
	margin-top:-25px;
	left:50%;
	margin-left:-170px;
	font-size:18px;
	color:white;
	background-color:#fbaa01;
	border-radius:10px;
	display:none;
	z-index:99999;
}
#hint font{
	font-size:12px;
	color:black;
}
</style>
</head>
<body>
<div id='hint'>暂时只有这么多了<font>(点击隐藏)</font></div>
<!-- 头部 -->
<?php if($headinfo == 0): ?><header id="header">
<a href="javaScript:window.history.back();"><img src="/mobile/app/b2b/Public/News/img/fanhui.png"></a>山头<a href="http://www.chahuitong.com/wap"><img src="/mobile/app/b2b/Public/News/img/home.png"></a>
</header>
<?php else: endif; ?>
<style type="text/css">
.head{
	background-color:#f9f9f9;
}
</style>
<!-- 茶-分类 -->
<div class="fenlei">
<ul class="feilei-items">
<li><a id="80" style="color:#edb201;border-bottom:2px solid #edb201;padding-bottom:5px">最新</a></li>
<li><a id="88">综合资讯</a></li>
<li><a id="89">茶苑美文</a></li>
<li><a id="90">生活茶事</a></li>
<li><a id="91">品牌新闻</a></li>
<li><a id="92">品茶公开课</a></li>
</ul>
</div>
<!-- 幻灯片 -->
<div class="slide" id="slide3">
    <ul>
        <li>
            <a href="http://www.chahuitong.com/mobile/app/b2b/index.php/News/Index/detail/aid/5808.html">
                <img src="/mobile/app/b2b/Public/News/img/zx0601.jpg">
            </a>
        </li>
		<li>
            <a href="http://www.chahuitong.com/mobile/app/b2b/index.php/News/Index/detail/aid/5921.html">
                <img src="/mobile/app/b2b/Public/News/img/zx06012.jpg">
            </a>
        </li>
            </ul>
    <div class="dot">
        <span></span>
        <span></span>
    </div>
</div>

<!-- 资讯列表 -->
<div class="infos 80 on" data-id="80">
<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><input type="hidden" value="5" class="page"/>
<div class="infos-item">
<div class="img-content">
<a href="<?php echo U('Index/detail?aid='.$data[id].'');?>" target="_self"><img src="<?php echo ($host); echo ($data["litpic"]); ?>" /></a>
</div>
<div class="img-title"><a href="<?php echo U('Index/detail?aid='.$data[id].'');?>" target="_self"><?php echo ($data["title"]); ?></a></div>
<div class="img-descri"><a href="<?php echo U('Index/detail?aid='.$data[id].'');?>" target="_self"><?php echo ($data["description"]); ?>...</a></div>
<div class="img-date"><?php echo ($data["writer"]); ?>|<?php echo ($data["typename"]); ?>|<?php echo ($data["pubdate"]); ?></div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>

</div>

<div class="infos 88 off" data-id="88"><input type="hidden" value="0" class="page"/></div>
<div class="infos 89 off" data-id="89"><input type="hidden" value="0" class="page"/></div>
<div class="infos 90 off" data-id="90"><input type="hidden" value="0" class="page"/></div>
<div class="infos 91 off" data-id="91"><input type="hidden" value="0" class="page"/></div>
<div class="infos 92 off" data-id="92"><input type="hidden" value="0" class="page"/></div>

<script src="/mobile/app/b2b/Public/News/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript">
$.noConflict();
</script>
<script src="/mobile/app/b2b/Public/News/js/zepto.min.js" type="text/javascript"></script>
<script src="/mobile/app/b2b/Public/News/js/swipeSlide.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$('#slide3').swipeSlide({
        continuousScroll:true,
        speed : 3000,
        transitionType : 'cubic-bezier(0.22, 0.69, 0.72, 0.88)',
        callback : function(i){
            $('.dot').children().eq(i).addClass('cur').siblings().removeClass('cur');
        }
    });
	
    //顶部茶分类-点击效果
    jQuery(".feilei-items li a").click(function(){
   	 	jQuery(".feilei-items li a").css({"color":"#999999","border-bottom":"none"});
   	    jQuery(this).css({"color":"#edb201","border-bottom":"2px solid #edb201","padding-bottom":"5px"});
    		var typeid=jQuery(this).attr("id");
    		var typeid1=typeid;
    		if(typeid==80){
    			typeid1=null;
    		}
    		var page=jQuery("."+typeid).find(".page").val();
    		if(page==0){
    			jQuery.ajax({
        			type:"POST",
        			url:"<?php echo U('News/getColumnArticles');?>",
        			data:{typeid:typeid1,page:0},
        			success:function(data){
        				jQuery(".infos").removeClass("on");
        				jQuery(".infos").addClass("off");
        				jQuery("."+typeid).append(data);
        				jQuery("."+typeid).removeClass("off");
        				jQuery("."+typeid).addClass("on");
        			},
        		});
    			jQuery("."+typeid).find(".page").val(parseInt(page)+5);
    		}else{
    			jQuery(".infos").removeClass("on");
			jQuery(".infos").addClass("off");
			jQuery("."+typeid).removeClass("off");
    			jQuery("."+typeid).addClass("on");
    		}
    });
    
    var con=true;
    /*滑动到底部，加载文章*/
    jQuery(window).scroll(function(){
		if(parseInt(jQuery(document).scrollTop())>=parseInt(jQuery(document).height())-parseInt(jQuery(window).height())){
			if(!con){
			jQuery("#hint").show();
			setTimeout(function(){
				jQuery("#hint").hide();
			},2000);
    			return false;
    			}
			var page=jQuery(".on").find(".page").val();
			var typeid=jQuery(".on").data("id");
			var typeid1=typeid;
    		if(typeid==80){
    			typeid1="";
    		}
    		jQuery.ajax({
    			type:"POST",
    			url:"<?php echo U('News/getColumnArticles');?>",
    			data:{typeid:typeid1,page:page},
    			success:function(data){
    				if(data.length==0){
    					jQuery("#hint").show();
    					setTimeout(function(){
    						jQuery("#hint").hide();
    					},2000);
    					con=false;
    				}
    				jQuery(".on").append(data);
    			},
    		});
    		jQuery(".on").find(".page").val(parseInt(page)+5);
		}
});
    jQuery("#hint").click(function(){
    		jQuery(this).hide();
    })
});
</script>
</body>
</HTML>