$(function(){
	var stop=true; 
	var xianshiid=escape(GetQueryString('id'));
	var size=5;
	var page=$("input[name='page']").val();
	function init(){
	
	$(window).scroll(loadmore);
	$.ajax({
	url:WapSiteUrl+"/index.php/Home/Index/xianshiapi",
	type:'post',
	data:{xianshiid:xianshiid,page:page,size:size},
	success: function(data){
		 if(data.result==1){
		 for(var  i=0;i<data.goods.length;i++){			 
			 $("#none").before("<div class='mail_sg'><a href='"+WapSiteUrl+"/index.php/Home/Index/goods?goods_id="+data.goods[i].goods_id+"'><img src='"+SiteUrl+"/data/upload/shop/store/goods/"+data.goods[i].store_id+"/"+data.goods[i].goods_image+"'><p><b><img src='/wap/Public/Home/img/m.png'>"+data.goods[i].xianshi_price+"</b><span>"+Math.round((data.goods[i].xianshi_price/data.goods[i].goods_price)*10)+"折</span><mark>"+data.goods[i].goods_price+"</mark></p><h5>"+data.goods[i].goods_name+"</h5></a></div>");		
			 	 
			 }
	  $(".title").html(data.info.store_name+"-"+data.info.xianshi_name)		 
	  countDown(data.info.end_time,"#colockbox1");  				 				 		 
			 }else{
				 
			 $("#one").html("<img src="+WapSiteUrl+"'/Public/Home/img/wu.jpg'>"); 
				 }	
		},
	
	dataType:"json",
	
	});
	
	}
	
	init();
	
	
	 function loadmore(){
		 
		 totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()); 
        if($(document).height() <= totalheight){ 
		 page=$("input[name='page']").val()*1+1;
		 $("input[name='page']").val(page);
         if(stop==true){ 
            stop=false; 
            $.post(WapSiteUrl+"/index.php/Home/Index/xianshiapi",{xianshiid:xianshiid,page:page,size:size},function(data){ 
            if(data.result==1){
		     for(var  i=0;i<data.goods.length;i++){			 
			 $("#none").before("<div class='mail_sg'><a href='"+WapSiteUrl+"/index.php/Home/Index/goods?goods_id="+data.goods[i].goods_id+"'><img src='"+SiteUrl+"/data/upload/shop/store/goods/"+data.goods[i].store_id+"/"+data.goods[i].goods_image+"'><p><b><img src='/shopnc/wap/Public/Home/img/m.png'>"+data.goods[i].xianshi_price+"</b><span>"+Math.round((data.goods[i].xianshi_price/data.goods[i].goods_price)*10)+"折</span><mark>"+data.goods[i].goods_price+"</mark></p><h5>"+data.goods[i].goods_name+"</h5></a></div>");		
			 	 
			  }
   			 }else{
				 
			 $("#none").html("<img src='"+WapSiteUrl+"/Public/Home/img/wu.jpg'>"); 
				 
				 }
            stop=true; 
            },"json"); 
          } 
        } 
		
		}	
	function writeObj(obj){ 
    var description = ""; 
    for(var i in obj){   
        var property=obj[i];   
        description+=i+" = "+property+"\n";  
    }   
     alert(description); 
   } 
	
  	  function countDown(time,id){
	var day_elem = $(id).find('.day');
	var hour_elem = $(id).find('.hour');
	var minute_elem = $(id).find('.minute');
	var second_elem = $(id).find('.second');
	//var end_time = new Date(time).getTime(),//月份是实际月份-1
	
	var timer = setInterval(function(){
		var end_time=time*1000;
	sys_second =parseInt((end_time-(new Date().getTime()))/1000);
		if (sys_second > 1) {
			//sys_second -= 1;
			//var day = Math.floor(sys_second /(60*60*24));
			//var hour = Math.floor((sys_second / 3600) % 24);
			//var minute = Math.floor((sys_second / 60) % 60);
			//var second = Math.floor(sys_second % 60);
			var day=Math.floor(sys_second/(60*60*24)); 
            var hour=Math.floor((sys_second-day*24*60*60)/3600); 
            var minute=Math.floor((sys_second-day*24*60*60-hour*3600)/60); 
            var second=Math.floor(sys_second-day*24*60*60-hour*3600-minute*60);
			day_elem && $(day_elem).text(day+"天");//计算天
			$(hour_elem).text(hour<10?"0"+hour:hour+"时");//计算小时
			$(minute_elem).text(minute<10?"0"+minute:minute+"分");//计算分钟
			$(second_elem).text(second<10?"0"+second:second+"秒");//计算秒杀
		} else { 
			clearInterval(timer);
		}
	 }, 1000);
	 
    }	
	
	
	
	
	
	})