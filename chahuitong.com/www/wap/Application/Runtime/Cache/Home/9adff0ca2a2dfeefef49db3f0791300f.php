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

 	 var member_id=<?php echo ($member_id); ?>;

 	 init();
	 
	  if(member_id==1){
		 
		 $(".top").css("display","none");
		 
		 $(".insterst").css("display","none");
		 
		 }
		 
	  $(".close").click(function(){
		  		  
		  $(".fenxiang").css("display","none")
		  
		  })	 
		 
	   $(".share").live("click",function(){
			
	   var content_id=$(this).attr("data-id");
	   
	   var username=$.cookie("username");
	   
	   var key=$.cookie("key");
	  	   
	   $.ajax({
		   
		   url:"/wap/index.php/Home/Discuz/add_share_api",
		   
		   type:"post",
		   
		   dataType:"json",
		   
		   data:{content_id:content_id,username:username,key:key},
		   
		   success:function(data){
			   
			   $(".fenxiang").css("display","block");
			   
			   if(data.code==200){
				   
			   var zan=$("#"+content_id+" .homeshare").text();
			   
			   zan=zan*1+1*1;
			   
			 
			   $("#"+content_id+" .homeshare").text(zan);
			   
			   }
		          	   
			   }
		   	   
		   })   
			
		
		});	 

 	 function showComment(){

    var class_id=$(this).attr("class");

 	 	var content_id=$(this).attr("data-id");

    if(class_id=="comment"&&class_id!="finished"){

        $.ajax({

         url:"/wap/index.php/Home/Discuz/get_content_comment_api",

         type:"post",

         dataType:"json",

         data:{content_id,content_id},

         success:function(data){

           $("#"+content_id+" .comment").addClass("finished");

           $("#"+content_id+" .finished").removeClass("comment");

           $("#"+content_id+" .reply_to").css("display","block");


         	if(data.code==200){

         	 var string='<div style="clear:both;width:100%;height:auto" class="pinglun">';	
         	 
         	 for(var i=0;i<data.content.length;i++){

         	 	string+='<div style="clear:both;padding:10px 0"  class="comment">';

            var img='';

            if(data.content[i].memberInfo.member_avatar!=null){
    
              img='<img style="width:15%;float:left" src="/data/upload/shop/avatar/'+data.content[i].memberInfo.member_avatar+'">';

            }else{

              img='<img style="width:15%;float:left" src="/data/upload/shop/avatar/nopic.jpg">';
            }

         	 	string+=img+'<div style="width:80%;padding-left:20%;"><span class="member_name">'+data.content[i].memberInfo.member_name+'</span> ';

            if(data.content[i].reply_to!=''){

            string+='@'+data.content[i].reply_to+" ";

            }

         	 	
         	 	string+=data.content[i].comment_time+'<br><p>'+data.content[i].comment+'</p></div></div>';


         	 }	


             $("#"+content_id+" .pic").after(string);

             
         	}else{

              

         	}

             

          }


        })
  
       }

 	 }

   function pinglun_state(){

      //alert($(this).parent().parent().find(".pinglun").css("display"))

      if($(this).parent().parent().find(".pinglun").css("display")=="none"){

        $(this).parent().parent().find(".pinglun").css("display","block");
     

      }else{

        $(this).parent().parent().find(".pinglun").css("display","none");

      }

      if($(this).parent().parent().find(".reply_to").css("display")=="none"){

        $(this).parent().parent().find(".reply_to").css("display","block");

      }else{

        $(this).parent().parent().find(".reply_to").css("display","none");

      }


   }

 	 function insterst(){

 	 var username=$.cookie("username");
 	
 	 var key=$.cookie("key");


     $.ajax({

      url:"/wap/index.php/Home/Discuz/add_insterst_api",
      
      type:"post",

      dataType:"json",

      data:{username:username,key:key,member_id:member_id},

      success:function(data){

      	if(data.code==200){

        $(".showmsg").html(data.content);

        $(".showmsg").show();

        $(".xiangqing").css("opacity","0.3");

        $(".top").css("opacity","0.3");

        setTimeout(function(){

        $(".showmsg").hide();

        $(".xiangqing").css("opacity","1");

        $(".top").css("opacity","1");

        var number=$(".guanzhu").html();

        number=number*1+1;

        $(".guanzhu").html(number); 

        	
        },3000)
  

      	}else{


        $(".showmsg").html(data.content);

        $(".showmsg").show();

        $(".xiangqing").css("opacity","0.3");

        $(".top").css("opacity","0.3");

        setTimeout(function(){

        $(".showmsg").hide();

        $(".xiangqing").css("opacity","1");

        $(".top").css("opacity","1");
        	
        },3000)

      	}

      }	


     }) 		

    
 	}

  /*添加回复人*/
  function add_reply_to(){

    var name=$(this).find(".member_name").html();

    $(this).parent().parent().find("input[name='reply_to']").val(name);
    
    $(this).parent().parent().find(".reply").html("回复:"+name)

   }

   /*发表评论*/
   function post_comment(){

    var content_id=$(this).attr("data-id");

    var username=$.cookie("username");

    var key=$.cookie("key");

    var comment=$(this).parent().find(".text").val();

    //alert(comment);

    var reply_to=$(this).parent().find("input[name='reply_to']").val();

    $.ajax({

      url:"/wap/index.php/Home/Discuz/add_content_comment_api",

      type:"post",

      dataType:"json",

      data:{username:username,key:key,content_id:content_id,comment:comment,reply_to:reply_to},

      success:function(data){

             if(data.code==200){
				 
				 var view=$("#"+content_id+" .view").text();
				 
				 view=view*1+1;
				 
				 $("#"+content_id+" .view").text(view);
				 			 
				 var img='';
				 
				 if(data.content.memberInfo.member_avatar!=''){
					 
					 img=data.content.memberInfo.member_avatar;
					 
					 }else{
					
					 img="nopic.jpg"	 
						 
						 }
						 
				var name='';
				
				if(data.reply_to!=undefined){
					
					name=data.content.memberInfo.member_name+' @'+data.reply_to;
								
					}else{
						
					name=data.content.memberInfo.member_name;	
						}		 
				 
				var string='<div style="clear:both;padding:10px 0" class="comment"><img style="width:15%;float:left" src="/data/upload/shop/avatar/'+img+'"><div style="width:80%;padding-left:20%;"><span class="member_name">';
				
				if(data.content.memberInfo.member_name) 
              
			  $("#"+content_id+" .pic").after(string+name+'</span>'+data.time+'<br><p>'+data.comment+'</p></div></div>');
              


             }else{

              alert(data.content)



             }


         }

      

        })

   }
   
   /*添加点赞*/
   function add_zhan(){
	   
	   var content_id=$(this).parent().parent().attr("id");
	   
	   //alert(content_id);
	   
	   var username=$.cookie("username");
	   
	   var key=$.cookie("key");
	   
	   //alert(username+','+key)
	   
	   $.ajax({
		   
		   url:"/wap/index.php/Home/Discuz/add_zan_api",
		   
		   type:"post",
		   
		   dataType:"json",
		   
		   data:{content_id:content_id,username:username,key:key},
		   
		   success:function(data){
			   if(data.code==200){
			   var zan=$("#"+content_id+"  .zhan  .zan").text();
			   
			   zan=zan*1+1*1;
			   
			 $(".showmsg").html(data.content);

            $(".showmsg").show();

            $(".xiangqing").css("opacity","0.3");

            $(".top").css("opacity","0.3");

            setTimeout(function(){

            $(".showmsg").hide();

            $(".xiangqing").css("opacity","1");

            $(".top").css("opacity","1")},3000)
			   
			   $("#"+content_id+"  .zhan  .zan").text(zan);
			   
			   }else{
				   
		     $(".showmsg").html(data.content);

            $(".showmsg").show();

            $(".xiangqing").css("opacity","0.3");

            $(".top").css("opacity","0.3");

            setTimeout(function(){

            $(".showmsg").hide();

            $(".xiangqing").css("opacity","1");

            $(".top").css("opacity","1")},3000)
				   
				   
			     }
		          	   
			   }
		   	   
		   })   
	   
	   }


   /*初始化函数*/

 	 function init(){

    $(".insterst").click(insterst);	

 	 var page=$("input[name='page']").val();	

 	 $.ajax({

 	 url:"/wap/index.php/Home/Discuz/member_content_api",

 	 type:"post",

 	 dataType:"json",

 	 data:{member_id:member_id,page:0},

 	 success:function(data){

 	 	//alert(data.code);
 	 	if(data.memberInfo.member_avatar!=''){

 	 	$(".avatar").attr("src","/data/upload/shop/avatar/"+data.memberInfo.member_avatar);

 	 	   }else{
        
        $(".avatar").attr("src","/data/upload/shop/avatar/nopic.jpg");

 	 	 }

 	 	$(".guanzhu").html(data.memberInfo.guanzhu); 

 	 	$(".member_name").prepend(data.memberInfo.member_name);

 	 	$("rank").html(data.memberInfo.rank);



 	 	if(data.code==200){

 	 	for(var i=0;i<data.content.length;i++){

 	 	 var string='';
 	 	 
 	 	 string='<li id="'+data.content[i].content_id+'"><p>'+data.content[i].time+'<span></span></p><p>'+data.content[i].content+'</p>';

 	 	 if(data.content[i].image!=''){

 	 	 	string+='<div>';

 	 	 	var strs= new Array(); //定义一数组 

            strs=data.content[i].image.split(","); //字符分割 

           for (j=0;j<strs.length;j++) 

               { 

            string+='<div style="width:33%;float:left;text-align:center"><img class="shai_image" width="80%" src="/data/upload/qunzi/'+strs[j]+'"></div>';	
            
               } 

             string+='</div>';

 	 	    }

 	 	 string+='<div class="pic" style="clear:both"><span class="share" data-id="'+data.content[i].content_id+'"><img src="/wap/Public/Home/img/share.png"><time class="homeshare">'+data.content[i].share+'</time></span><span class="comment" data-id="'+data.content[i].content_id+'"><img src="/wap/Public/Home/img/bi.png"><time class="view">'+data.content[i].comment+'</time></span><span class="zhan"><img src="/wap/Public/Home/img/zhan.png"><time class="zan">'+data.content[i].view+'</time></span></div><div class="reply_to" style="clear:both;width:100%;padding-top:10px;display:none"><div class="reply"></div><div><div class="'+data.content[i].content_id+'"><input type="hidden" name="reply_to" value=""><span class="reply_to"></span></div><textarea style="width:100%;height:50px;" class="text"></textarea><br><div style="width:20%;margin:0 auto" class="post" data-id="'+data.content[i].content_id+'">发表</div></div></li>';	

 	 	 $(".xiangqing").append(string);

 	 	 

 	 	   }

 	 	   

 	 	}else{

        $(".showmsg").html("用户没有发表任何信息");

        $(".showmsg").show();

        $(".xiangqing").css("opacity","0.3");

        $(".top").css("opacity","0.3");

        setTimeout(function(){

        $(".showmsg").hide();

        $(".xiangqing").css("opacity","1");

        $(".top").css("opacity","1");
          
        },3000)


 	 	}

       $(".comment").click(showComment); 

       $(".pinglun .comment").live("click",add_reply_to);

       $(".xiangqing  .post").click(post_comment);

       $(".finished").live("click",pinglun_state); 
	   
	    $(".zhan").live("click",add_zhan); 

 	  }


 	})

   }

 })
</script>
</head>
<body>
<header>
<a href="javaScript:window.history.back();"><img src="/wap/Public/Home/img/fanhui.png"></a><?php if($member_id == 1): ?>精选话题<?php endif; ?><a href="/wap/index.php/Home/Discuz/index"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="top">
<img class="avatar" src="/wap/Public/Home/img/lingxiu01.png">
<h4 class="member_name"><img src="/wap/Public/Home/img/nan.png"><span class="guanzhu">256关注</span></h4>
<p class="rank">中国茶学院荣誉院长</p>
</div>
<button class="insterst"><img src="/wap/Public/Home/img/weigz.png">加关注</button>
<ul class="xiangqing">

</ul>
</div>
<div class="showmsg" style="position:fixed;top:40%;left:0;height:30px;line-height:30px;display:none;background:red;color:white;width:100%;text-align:center"></div>
<div class="fenxiang" style="display:none;position:fixed;top:40%;left:0;height:40px;line-height:40px;text-align:center;width:100%;background:#FFF;z-index:999">
<div style="display:inline-block;width:80%;float:left">
<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>
</div>
<div class="close" style="display:inline-block;width:19%;color:#F00;float:right">X</div>
</div>
</body>
</html>