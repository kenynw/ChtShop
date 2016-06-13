$(function(){
		var key = getcookie('key');
		if(key==''){
			location.href = 'login.html';
		}
		if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
				$("header").css("display","none");	
				//$(".nav1").css("display","none");	
	  }	
		//初始化列表
		function initPage(){
			$.ajax({
				type:'post',
				url:ApiUrl+"/index.php?act=member_address&op=address_list",	
				data:{key:key},
				dataType:'json',
				success:function(result){
					checklogin(result.login);
					if(result.datas.address_list==null){
						return false;
					}
					var data = result.datas;
					var html = template.render('saddress_list', data);
					$("#address_list").empty();
					$("#address_list").append(html);
					//点击删除地址
					$('.deladdress').click(delAddress);
					//设置默认地址
					$('.box1').click(defaultaddress);
				}
			});
		}
		initPage();
		//点击删除地址
		function delAddress(){
			var address_id = $(this).attr('address_id');
			$.ajax({
				type:'post',
				url:ApiUrl+"/index.php?act=member_address&op=address_del",
				data:{address_id:address_id,key:key},
				dataType:'json',
				success:function(result){
					checklogin(result.login);
					if(result){
						initPage();
					}
				}
			});
		}
		
	function defaultaddress(){
		
		var id=$(this).find(".undefault").val();
		var did=$(".default").val();
		
		$.ajax({
			type:'post',
			//url:ApiUrl+"/index.php/Home/Index/changeaddress",
			url:"/wap/index.php/Home/Index/changeaddress",
			data:{id:id,key:key,did:did},
			dataType:'json',
			success:function(result){			  
					checklogin(result.login);
					if(result){
						initPage();
					}
				}	
			
			})		
		}			
		
});