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

var width=window.innerWidth;
var yy=width*0.536+8;
var list=document.getElementById('list');
var width=document.body.scrollWidth;
if(width>640) width=640;
var w=width*0.25;
var listA=list.getElementsByTagName('a');
var type=document.getElementsByClassName('type');
for(var i=0;i<listA.length;i++){
	listA[i].style.height=w+'px';
	dianji(listA[i]);
}
list.style.height=2*w+70+'px';
function dianji(obj){
	obj.onclick=function(){
		for(var j=0;j<type.length;j++){
			type[j].style.display='none';
			listA[j].removeAttribute('id');
		}
		var pid=obj.name;
		var a=document.getElementById(pid);
		a.style.display='block';
		obj.setAttribute('id','bg');
		window.scrollTo(0,yy);
	}
}
var sousuo=document.getElementById('sousuo');
var quxiao=document.getElementById('quxiao');
var cha=document.getElementById('a1');
var shan=cha.getElementsByTagName('h3');
var chaSpan=cha.getElementsByTagName('span');
for(var i=1;i<shan.length;i++){
	get_nextSibling(shan[i]).style.display='none';
}
for(i=0;i<chaSpan.length;i++){
	dj(chaSpan[i]);
}
function get_nextSibling(n){
	var x=n.nextSibling;
	while(x && x.nodeType!=1){
		x=x.nextSibling;
	}
	return x;
}
function dj(obj){
	obj.onclick=function(){
		if(this.getAttribute('id')=='on'){
			this.removeAttribute('id');
			get_nextSibling(obj.parentNode).style.display='none';
			
		}else{
		for(var i=0;i<chaSpan.length;i++){
			chaSpan[i].removeAttribute('id');
			get_nextSibling(chaSpan[i].parentNode).style.display='none';
		}
		obj.setAttribute('id','on');
		get_nextSibling(obj.parentNode).style.display='block';
	}}
}
}