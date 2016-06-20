function getStyle(obj,attr){
	if(obj.currentStyle){
		return obj.currentStyle[attr];
	}else{
		return getComputedStyle(obj,false)[attr];
	}
}
function startMove(obj,json,fn){
	var flag = true;
	clearInterval(obj.timer);
	obj.timer = setInterval(function(){
		for(var attr in json){
			var iCur = 0;
			if(attr == 'opacity'){
				iCur = Math.round(parseFloat(getStyle(obj,attr)) * 100);
			}else{
				iCur = parseInt(getStyle(obj,attr));
			}
			var iSpeed = (json[attr] - iCur) / 8;
			iSpeed = iSpeed > 0 ? Math.ceil(iSpeed) : Math.floor(iSpeed);
			if(iCur != json[attr]){
				flag = false;
			}
			if(attr == 'opacity'){
				obj.style.filter = 'alpha(opacity:' + (iCur + iSpeed) + ')';
				obj.style.opacity = (iCur + iSpeed) / 100;
			}else{
				obj.style[attr] = iCur + iSpeed + 'px';
			}
		}
		if(flag){
			clearInterval(obj.timer);
			if(fn){
				fn();
			}
		}
	},30);
}

function ifIe(){
	if(window.navigator.userAgent.indexOf("IE") == -1){
		return true;
	}else{
		return false;//ie
	}
		if(window.navigator.userAgent.indexOf("IE") == -1) //FireFox
{
     tabBody = obj.getElementsByClassName('body')[0];
}
else //IE
{
     tabBody = obj.getElementsByTagName('div')[0];
}
}