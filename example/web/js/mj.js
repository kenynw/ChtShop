function id(idName){
	return document.getElementById(idName);
}
function cN(className,obj){
	if(obj){
		return obj.getElementsByClassName(className);
	}else{
		return document.getElementsByClassName(className);
	}
}
function tag(tagName,obj){
	if(obj){
		return obj.getElementsByTagName(tagName);
	}else{
		return document.getElementsByTagName(tagName);
	}
}
function css(obj,json){
	if(obj.length){
		for(var i = 0;i < obj.length;i++){
			csses(obj[i],json);
		}
	}else{
		csses(obj,json);
	}
	function csses(objs,json){
		for(var j in json){
			objs.style[j] = json[j];
		}
	}
}
function listC(nodes){
	for(var i = 0;i <nodes.length;i++){
		nodes[i].className = '';
	}
}
function daojishi(ids,node){
	var countdown = id(ids);
	var getTimes = parseInt(countdown.dataset.time);
	//var getTimes = (new Date(setTimes)).getTime();
	setInterval(function(){
		var time = (new Date()).getTime()/1000;
		if(time < getTimes){
			var num = parseInt(getTimes - time);
			var hour = parseInt(num / 3600);
			var minu = parseInt((num - hour * 3600) / 60);
			var sec = parseInt(num - hour * 3600 - minu * 60);
			tag(node,countdown)[0].innerHTML = numToStr(hour);
			tag(node,countdown)[1].innerHTML = numToStr(minu);
			tag(node,countdown)[2].innerHTML = numToStr(sec);
		}
	},1000);
}
function numToStr(num){
	return num = num < 10 ? '0' + num : num;
}
function getCookie(name){
	var cookieName = encodeURIComponent(name) + "=",
		cookieStart = document.cookie.indexOf(cookieName),
		cookieValue = null;
	if(cookieStart > -1){
		var cookieEnd = document.cookie.indexOf(';',cookieStart);
		if(cookieEnd == -1){
			cookieEnd = document.cookie.length;
		}
		cookieValue = decodeURIComponent(document.cookie.substring(cookieStart + cookieName.length,cookieEnd));
	}
	return cookieValue;
}
function toTop(){
var fanhui = id('fanhui');
if(fanhui){
var scrollTop,j;
window.onscroll=function(){
	scrollTop = document.body.scrollTop;
	if(scrollTop>=600){
		fanhui.style.display='block';
	}else{
		fanhui.style.display='none';
	}
};
fanhui.addEventListener('click',function(){
	j = 0;
	fh();
},false);
}
function fh(){
	document.body.scrollTop = scrollTop - scrollTop * j;
	j = j + 0.05;
	if(j >= 1){
		document.body.scrollTop = 0;
	}else{
		setTimeout(fh,30);
	}
}
}
var W = document.body.clientWidth > 640 ? 640 : document.body.clientWidth;
if(id('fanhui')){
	toTop();
}