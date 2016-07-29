(function (){
var sale = document.getElementById('sale');
var buy = document.getElementById('buy');
buy.onclick = function(){
	sale.style.backgroundImage = 'url(img/chashi/sale02.png)';
	buy.style.backgroundImage = 'url(img/chashi/buy01.png)';
}
sale.onclick = function(){
	sale.style.backgroundImage = 'url(img/chashi/sale01.png)';
	buy.style.backgroundImage = 'url(img/chashi/buy02.png)';
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
			img.src = "img/chashi/xia.png";
			img.removeAttribute('name');
		}else{
			img.src = "img/chashi/shang.png";
			img.setAttribute('name','on');
		}
	}
}})();