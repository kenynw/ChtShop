(function (){
var pic = document.getElementById('pic');
var picLi = pic.getElementsByTagName('li');
var W = window.innerWidth || document.body.clientWidth;
if(W < 1200){W = 1200;}
document.getElementById('top').style.width = W + 'px';
var num = picLi.length;
var j = 0;
var tiao = document.getElementById('tiao');
if(ifIe()){
	tiao.style.left = (W - 300 * num) / 2 + 'px';
}else{
	tiao.style.left = (W - 300 * num) / 2;
}
for(var i = 0;i < num;i++){
	var imgs = picLi[i].getElementsByTagName('img')[0].src;
	picLi[i].style.width = W + 'px';
	picLi[i].style.backgroundImage = 'url(' + imgs +')';
	var newNode = document.createElement('li');
	tiao.appendChild(newNode);
}
var tiaoLi = tiao.getElementsByTagName('li');
tiaoLi[0].className = 'on';
var loop = setInterval(picMove,3000);
function picMove(){
	for(var i = 0;i < num;i++){tiaoLi[i].className = '';}
	if(j == num){j = 0;}
	startMove(pic,{left:-W*j});
	tiaoLi[j].className = 'on';
	j++;
}
for(var i = 0;i <num;i++){
	tiaoMove(tiaoLi,i);
}
function tiaoMove(obj,timer){
	obj[timer].onmouseover = function(){
	clearInterval(loop);
	for(var i = 0;i < num;i++){obj[i].className = '';}
	obj[timer].className = 'on';
	j = timer;
	startMove(pic,{left:-W*j});
	loop = setInterval(picMove,3000);
	}
}
window.onresize = function(){
	clearInterval(loop);
	W = window.innerWidth || document.body.clientWidth;
	if(W < 1200){W = 1200;}
	document.getElementById('top').style.width = W + 'px';
	vtiao = document.getElementById('tiao');
	if(ifIe()){
		tiao.style.left = (W - 300 * num) / 2 + 'px';
	}else{
		tiao.style.left = (W - 300 * num) / 2;
	}
	for(var i = 0;i < num;i++){
		picLi[i].style.width = W + 'px';
	}
	loop = setInterval(picMove,3000);
}

var tab = document.getElementById('tab');
var tabLi = tab.childNodes;
for(var i = 0;i < tabLi.length;i++){
	if(tabLi[i].nodeType != 1){
		continue;
	}
	tabMove(tabLi[i]);
	var tabA = tabLi[i].getElementsByTagName('a');
	for(var x = 1;x < tabA.length;x++){
		tabA[x].innerHTML = tabA[x].innerHTML.slice(0,18);
	}
}
function tabMove(obj){
	var tabH = obj.getElementsByTagName('h4')[0];
	var tabBody = obj.getElementsByTagName('div')[0];
	obj.onmouseover = function(){
		for(var i = 0;i < tabLi.length;i++){
			if(tabLi[i].nodeType != 1){
				continue;
			}
			tabLi[i].getElementsByTagName('h4')[0].className = '';
			tabLi[i].getElementsByTagName('div')[0].style.display = 'none';
		}
		tabH.className = 'on';
		tabBody.style.display = 'block';
	}
}


var ju = document.getElementById('ju');
var juTitle = document.getElementById('jutitle');
ju.onmouseover = function(){
	juTitle.style.display = 'block';
}
ju.onmouseout = function(){
	juTitle.style.display = 'none';
}
})();