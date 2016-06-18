window.onload=function(){
var navi = navigator.userAgent;
if(navi.indexOf("android")!=-1||navi.indexOf("ios")!=-1){
		//$("header").hide();
		//$("nav").hide();
		document.getElementById("header").style.display="none";
}
var w=document.body.scrollWidth;
if(w>640) w=640;
var textW=w*0.96*0.28+15;
var name=document.getElementsByName('text');
for(var i=0;i<name.length;i++){
	name[i].style.height=textW+'px';
}
var liH=document.getElementsByTagName('li');
for(i=0;i<liH.length;i++){
	liH[i].style.height=textW+'px';
}
var pic = document.getElementsByClassName('picimg');
var w =pic[0].width;
console.log(w);
for(var i = 0;i < pic.length;i++){
pic[i].style.width = w + 'px';
pic[i].style.height = w + 'px';
}
}