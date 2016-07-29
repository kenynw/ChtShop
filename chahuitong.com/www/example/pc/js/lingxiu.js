(function(){
function tag(obj,tagName){
	return obj.getElementsByTagName(tagName);
}
function cN(obj,className){
	if(!document.getElementsByClassName){
		obj.getElementsByClassName = function(className){
			var t = tag(obj,'*');
			var len = t.length;
			var arr = [];
			for(var i = 0;i < len;i++){
				if(t[i].className == className){
					arr.push(t[i]);
				}
			}
			return arr;
		}
	}
	return obj.getElementsByClassName(className);
}
var guanzhu = cN(document,'toux_jia')[0];
var alink = cN(document,'alink');
guanzhu.onclick = function(){
	if(guanzhu.className){
		guanzhu.className = 'toux_yi';
	}else{
		guanzhu.setAttribute('class','toux_yi');
	}
	guanzhu.innerHTML ='<img src="img/shequ/yiguanzhu.png">已关注';
	guanzhu = null;
}
for(var i = 0;i < alink.length;i++){
	huifu(alink[i]);
}
function huifu(obj){
	obj.onclick = function(e){
		if(ifIe()){e.preventDefault();}
		else{window.event.returnValue = false;}
		var a = obj.parentNode.parentNode;
		var b = get_nextSibling(a);
		if(b.getAttribute('name') == 'open'){
			b.removeAttribute('name');
			b.style.display = 'none';
		}else{
			b.setAttribute('name','open');
			b.style.display = 'block';
		}
	}
}
function get_nextSibling(n){
	var x = n.nextSibling;
	if(x && x.nodeType != 1){
		x = x.nextSibling;
	}
	return x;
}
function ifIe(){
	if(window.navigator.userAgent.indexOf("IE") == -1){
		return true;
	}else{
		return false;//ie
	}
}
})();