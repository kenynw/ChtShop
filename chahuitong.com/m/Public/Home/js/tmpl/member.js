$(function(){
		var key = getcookie('key');
		if(key==''){
			location.href = 'login.html';
		}
	if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
				$(".head").css("display","none");	
				$(".nav1").css("display","none");	
	  }	
		$.ajax({
			type:'post',
			url:ApiUrl+"/index.php?act=member_index",	
			data:{key:key},
			dataType:'json',
			//jsonp:'callback',
			success:function(result){
				checklogin(result.login);
				$('#username').html(result.datas.member_info.user_name);
				$('#point').html(result.datas.member_info.point);
				$('#predepoit').html(result.datas.member_info.predepoit);
				$('#avatar').attr("src",result.datas.member_info.avator);
				return false;
			}
		});
		
		//客户退出	
		
	 $(".tuichu").click(function(){
		 		 delCookie("key");
		     	 delCookie("username");
				 location.reload();	 
		 })	
	function delCookie(name) 
     { 
     var date=new Date();
          date.setTime(date.getTime()-10000);
          document.cookie=name+"=v; expire="+date.toGMTString()+"; path=/";
     } 	 
		
});