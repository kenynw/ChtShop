window.onload=function(){	
$(".hd ul").html("11111");	
TouchSlide({ 
	slideCell:"#focus",
	titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
	mainCell:".bd ul", 
	effect:"left", 
	autoPlay:true,//自动播放
	autoPage:true, //自动分页
	switchLoad:"_src" //切换加载，真实图片路径为"_src" 
});

var w=document.body.scrollWidth;
if(w>640) w=640;
var user=document.getElementById('user');
var userLeft=(w-80)/2-2;
user.style.left=userLeft+'px';
var textW=w*0.92*0.28+5;
var name=document.getElementsByName('text');
for(var i=0;i<name.length;i++){
	name[i].style.height=textW+'px';
}
}

