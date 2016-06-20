window.onload=function(){
	var nav=document.getElementById('nav');
	var a1=document.getElementById('a1');
	a1.onmousemove=function(){
		nav.style.height="181px";
	}
	a1.onmouseout=function(){
		nav.style.height="81px";
	}
	var head=document.getElementById('head');
	var w=head.scrollWidth;
	head.style.height=w+'px';
	var header=document.getElementsByName('head');
	for(var i=0;i<header.length;i++){
		yidong(header[i],(i+1));
	}
}
function yidong(obj,x){
	obj.onmouseover=function(){
		head.style.backgroundImage='url(images/erweima0'+x+'.png)';
	};
	obj.onmouseout=function(){
		head.style.backgroundImage='none';
	}
}