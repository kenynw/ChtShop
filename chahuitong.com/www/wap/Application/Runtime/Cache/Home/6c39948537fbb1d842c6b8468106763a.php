<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>社区————茶汇通</title>
<meta name="keywords" content="茶汇通,普洱,普洱茶">
<meta name="description" content="茶汇通普洱饼茶">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/share.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/shequ/shequ.css" type="text/css" rel="stylesheet">
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script src="/wap/Public/Home/js/jquery.cookie.js"></script>
<script>
 $(document).ready(function(){
	 
	  var username=$.cookie("username");
  
      var key=$.cookie("key");
	  
	  init();
	  
	  $(".lingxiu li button").live("click",function(){
		  
		 var member_id=$(this).attr("class");
		 
		 var number=$("#"+member_id+" .guanzhu").text();
		 
		 $.ajax({

        url:"/wap/index.php/Home/Discuz/add_insterst_api",
      
        type:"post",

         dataType:"json",

        data:{username:username,key:key,member_id:member_id},

         success:function(data){

      	  if(data.code==200){

         $(".showmsg").html(data.content);

         $(".showmsg").show();

         $(".lingxiu").css("opacity","0.3");

          setTimeout(function(){

          $(".showmsg").hide();

          $(".lingxiu").css("opacity","1");

          number=number*1+1;

          $("#"+member_id+" .guanzhu").text(number);
        	
          },3000)
  

        	}else{


         $(".showmsg").html(data.content);

         $(".showmsg").show();
  
         $(".lingxiu").css("opacity","0.3");

         setTimeout(function(){

        $(".showmsg").hide();

        $(".lingxiu").css("opacity","1");
        	
         },3000)

        	}

         }	


        }) 		
		  
		  })
	  
	  jQuery(window).scroll(sliderdown);
	  
	  function sliderdown(){
		   
		   		if(parseInt(jQuery(document).scrollTop())>=parseInt(jQuery(document).height())-parseInt(jQuery(window).height())){
					
					
					init();
					
					
					}	   
		   
		   }	  
  
      function init(){
		  
		   var page=$("input[name='page']").val();
		  
		   $.ajax({
	  
	       url:"/wap/index.php/Home/Discuz/home_page_leader_api",
		   
		   type:"post",
		   
		   dataType:"json",
		   
		   data:{page:page},
		   
		   success:function(data){
			   
			   if(data.code==200){
				   
				   $("input[name='page']").val(page*1+1*1);
				   
				   var string='';
				   
				    for(var i=0;i<data.content.length;i++){
					   
				    string='<li id="'+data.content[i].member_id+'"><a href="/wap/index.php/Home/Discuz/memberContent/id/'+data.content[i].member_id+'" style="display:block;height:174px;overflow:hidden">';
					   
					 if(data.content[i].member_avatar!=null){

     	  	    	 string+='<img src="/data/upload/shop/avatar/'+data.content[i].member_avatar+'">';
	
     	  			 }else{

     	  			 string+='<img src="/data/upload/shop/avatar/nopic.jpg">';

     	  		     }
					   
					 string+='<p>'+data.content[i].member_name+'<img src="/wap/Public/Home/img/nan.png"></p>';
					 
					 string+='<p ><span class="guanzhu">'+data.content[i].guanzhu+'</span>关注</p>';
					 
					  if(data.content[i].rank==''){
                    
                    string+='<p>人气领袖</p>'; 

                    }else{
                   
                    string+='<p>'+data.content[i].rank+'</p>';

                    }
					 
					 string+='</a><button class="'+data.content[i].member_id+'"><img src="/wap/Public/Home/img/weigz.png" class="guanzhu">加关注</button></li>';
					 
					 $(".lingxiu").append(string);
					   				   					   
					   }
		   
				   
				   }
   
			   }
	  
	      })
	  
	   }	
	 
	 })
 
</script>
<style>
header p{color:#fff;padding-top:3px;}
h5{line-height:50px;}
.xin p{padding-bottom:15px;}
.lingxiu li{list-style:none}
</style>
</head>
<body>
<header>
<a href="javaScript:window.history.back();"><img src="/wap/Public/Home/img/fanhui.png"></a>领袖榜单<a href="/wap/index.php/Home/Discuz/index"><img src="/wap/Public/Home/img/home.png"></a><p>资深茶客|品茶专家</p>
</header>
<input type="hidden" name="page" value="1">
<ul class="lingxiu">

</ul>
</div>
<div class="showmsg" style="position:fixed;top:40%;left:0;height:30px;line-height:30px;display:none;background:red;color:white;width:100%;text-align:center"></div>
</body>
</html>