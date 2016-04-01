(function(){
var paixu = document.getElementById('paixu');
var img = document.getElementById('img');
var paixuDiv = paixu.getElementsByTagName('div');
var x = 0;
img.onclick = function(){
	if(x%2 == 0){
		img.innerHTML = '<img src="img/down.png">';
		paixuDiv[0].removeAttribute('style');
	}else{
		img.innerHTML = '<img src="img/top.png">';
		paixuDiv[0].setAttribute('style','height:52px');
	}
	x++;
}
for(var i = 0;i < paixuDiv.length;i++){
	var paixuS = paixuDiv[i].getElementsByTagName('span');
	if(paixuS.length==0){continue;}
	for(var j = 0;j < paixuS.length;j++){
		spanClick(paixuS[j]);
	}
}
function spanClick(obj){
	obj.onclick = function(){
		if(obj.className == 'on'){
			obj.className = '';
			obj.removeAttribute('class');
		}else{
			var a = obj.parentNode.childNodes;
			for(var i = 0;i < a.length;i++){
				if(a[i].nodeType == 1){
					a[i].className = '';
					a[i].removeAttribute('class');
				}
			}
			obj.className = 'on';
		}
	}
}
})();