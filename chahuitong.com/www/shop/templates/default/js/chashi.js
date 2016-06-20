(function (){
var sale = document.getElementById('sale');
var buy = document.getElementById('buy');
buy.onclick = function(){
	sale.style.backgroundImage = 'url(./templates/default/images/sale02.png)';
	buy.style.backgroundImage = 'url(./templates/default/images/buy01.png)';
}
sale.onclick = function(){
	sale.style.backgroundImage = 'url(./templates/default/images/sale01.png)';
	buy.style.backgroundImage = 'url(./templates/default/images/buy02.png)';
}

var paixu = document.getElementById('paixu');
var pSpan = paixu.getElementsByTagName('span');
for(var i = 1;i < pSpan.length;i++){
	if(i == 5){continue;}
	dianji(pSpan[i]);
}
function dianji(obj){
	obj.onclick = function(){
		var img = obj.getElementsByTagName('img')[0];
		var attr = img.getAttribute('name');
		if(attr){
			img.src = "../images/xia.png";
			img.removeAttribute('name');
		}else{
			img.src = "../images/shang.png";
			img.setAttribute('name','on');
		}
	}
}})();