(function(){
var img = document.getElementById('img');
var box = document.getElementById('ulLi');
var li = img.getElementsByTagName('li');
var boxLi = box.getElementsByTagName('li');
var len = li.length;
var loop,j = 0;
if(len > 1){
for(var i = 0;i < len;i++){
	var newNode = document.createElement('li');
	if(i == 0){
		newNode.className = 'on';
	}
	box.appendChild(newNode);
	mouseMove(newNode,i);
}
loop = setInterval(move,3000);
}
function move(){
	if(j == len){j = 0;}
	startMove(img,{left:-504 * j});
	for(var i = 0;i < len;i++){
		boxLi[i].className = '';
	}
	boxLi[j].className = 'on';
	j++;
}
function mouseMove(obj,a){
	obj.onmouseover = function(){
		clearInterval(loop);
		j = a;
		move();
		loop = setInterval(move,3000);
	}
}
})();