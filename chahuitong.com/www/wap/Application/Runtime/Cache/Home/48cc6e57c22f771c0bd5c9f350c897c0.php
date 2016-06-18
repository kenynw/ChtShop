<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>社区————茶汇通</title>
<meta name="keywords" content="茶汇通,普洱,普洱茶">
<meta name="description" content="茶汇通普洱饼茶">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/shequ/share.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/shequ/shequ.css" type="text/css" rel="stylesheet">
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script src="/wap/Public/Home/js/jquery.cookie.js"></script>
<script>

  $(document).ready(function(){
	  
	  //var username=$.cookie("username");
	  
	  //var key=$.cookie("key");
	  
	  init();
	  jQuery(window).scroll(sliderdown);
	  	  
	  function init(){
		  
		  var page=$("input[name='page']").val();
		  
		  $.ajax({
			  
			  url:"/wap/index.php/Home/Discuz/get_allperson_active_api",
			  
			  type:"post",
			  
			  dataType:"json",
			  
			  data:{page:page},
			  
			  success:function(data){
				  
				  if(data.code==200){
					  
					  $("input[name='page']").val(page*1+1*1);
					  
					  for(var i=0;i<data.content.length;i++){
					  
					  var string='';
					  
					  var image=new Array();
					  
					  image=data.content[i].pics.split(",")
					  
					  string='<div class="xiangq"><img src="/data/upload/qunzi/'+image[0]+'"><h4>'+data.content[i].active_title;
					  
					  string+='</h4><ul><li><label>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;点:</label><span>'+data.content[i].location;
					  
					  var free='';
					  
					  if(data.content[i].free==''||data.content[i].free==0){
						  
					  free='免费';
						 					  
						  }else{
							  
							free=data.content[i].free;  
							  
							  }
					  
					  string+='</span></li><li><label>状&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;态：</label>即将出发</li><li><label>行程天数：</label>'+data.content[i].last_time+'天</li><li><label>行程时</label><span>~2015-09-05</span></li><li><label>活动宣言：</label><span>'+data.content[i].content+'</span></li><li><label>费&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用：</label><span>￥'+free+'</span></li></ul><a href="/wap/index.php/Home/Discuz/activeDetail/id/'+data.content[i].active_id+'">了解详情</a></div>';
					  					  
					  $(".list").append(string);
					  
					  }			  
					  
					  
			       }
				  			  
				  }		  
			  
			  })
		  	  
		  
		  }
	  
	  
	   function sliderdown(){
		   
		   		if(parseInt(jQuery(document).scrollTop())>=parseInt(jQuery(document).height())-parseInt(jQuery(window).height())){
					
					
					init();
					
					
					}	   
		   
		   }	  
	  
	  
	  })



</script>
</head>
<body>
<header>
<a href="javaScript:window.history.back();"><img src="/wap/Public/Home/img/fanhui.png"></a>
茶客聚聚<a href="#"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="list">

<input type="hidden" name="page" value="1">
</div>
</body>
</html>