// JavaScript Document
$(document).ready(function() {
	var headerWidth=$("header").width();
	var headerHeight=headerWidth*0.4282;
	$("header").css("height",headerHeight);
	$(window).resize(function() {
		var headerWidth=$("header").width();
		var headerHeight=headerWidth*0.4282;
		$("header").css("height",headerHeight);
    });
	$(function(){
	$('#zhuce').click(function(){
		var name = $('#username').val();
		var padd1=$('#password').val();
		var padd2=$('#password2').val();
		if(name==""||name.length<3||name.length>10){
				var errMsg="用户名长度为3-10个字符";
				//alert(name);
				$('#pass').html(errMsg);
				$('#pass').css('display','block');
				return false;
		}
		if(padd1==""||padd1.length<6){
				var errMsg = "登录密码不能少于6个字符";
				$('#pass').html(errMsg);
				$('#pass').css('display','block');
				return false;
			}else if(padd1!=padd2){
				var errMsg = "两次输入密码不一致";
				$('#pass').html(errMsg);
				$('#pass').css('display','block');
				return false;
			}else{
				$('#pass').css('display','none');
			}
			if(!agrees){
				return false;
			}
		});
})

});