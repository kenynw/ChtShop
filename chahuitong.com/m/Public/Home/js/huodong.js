window.onload=function(){
TouchSlide({ 
	slideCell:"#focus",
	titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
	mainCell:".bd ul", 
	effect:"left", 
	autoPlay:true,//自动播放
	autoPage:true, //自动分页
	switchLoad:"_src" //切换加载，真实图片路径为"_src" 
});
var huodong=document.getElementById('huodong');
var xiang=document.getElementById('xiang');
var i=0
huodong.onclick=function(){
	if(i%2==0){
		xiang.style.display='none';
		huodong.setAttribute('class','close');
	}else{
		xiang.style.display='block';
		huodong.setAttribute('class','open');
	}
	i++;
};
}