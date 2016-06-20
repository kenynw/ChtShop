// JavaScript Document
TouchSlide({
	slideCell:"#focus",
	titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
	mainCell:".bd ul", 
	effect:"left", 
	autoPlay:true,//自动播放
	autoPage:true, //自动分页
	switchLoad:"_src" //切换加载，真实图片路径为"_src" 
});
$(document).ready(function(){
    $(".details ul li h4").click(function(){
		var kaiguan=$(this).attr("class");
		if(kaiguan=="close"){
			$(this).attr("class","open");
			$(this).next('#a1').slideDown(500);
		}
		if(kaiguan=="open"){
			$(this).attr("class","close");
			$(this).next('#a1').slideUp(500);
		}
	});
});