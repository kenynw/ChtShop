function lunbo(node,T,W){
var box =id(node);
var box_ul = tag('ul')[0];
var box_li = tag('li',box_ul);
var width = box_li[0].offsetWidth;
var nodeNum = box_li.length;
var B = false;
if(nodeNum >= 2){
	box_ul.style.left = -W + 'px';
	var lifirst = box_li[0];
	var lilast = box_li[nodeNum - 1];
	var newNode = document.createElement("li");
	newNode.innerHTML = lifirst.innerHTML;
	box_ul.appendChild(newNode);
	var newNode2 = document.createElement("li");
	newNode2.innerHTML = lilast.innerHTML;
	box_ul.insertBefore(newNode2,lifirst);
	
	if(cN('top_list',box).length == 0){
		var topList = document.createElement('div');
		topList.className = 'top_list';
		topList.innerHTML = '<ul></ul>',
		box.appendChild(topList);
	}
	var topList = tag('ul',cN('top_list',box)[0])[0];
	for(var ii = 0;ii < nodeNum;ii++){
		var topLi = document.createElement('li');
		if(ii == 0){
			topLi.className = 'on';
		}
		topList.appendChild(topLi);
	}
	cN('top_list',box)[0].style.left = W / 2 - 11 * nodeNum / 2 + 'px';
}
var i = 1;
var j = 0;
var loop;
function yidong(){
	B = false;
	if(i == nodeNum){i = 0;}
	listC(tag('li',topList));
	tag('li',topList)[i].className = 'on';
	tm();
}
function tm(){
	if(B){
		if(j >= 1){
		j = 0;
		clearTimeout(loop);
		box_ul.style.left = -width * i + 'px';
		return;
		}
		box_ul.style.left = -width * (i + 1) + j * width + 'px';
	}else{
		if(j >= 1){
			j = 0;
			clearTimeout(loop);
			i++;
			if(i > nodeNum){
				i = 1;
			}
		box_ul.style.left = -width * i + 'px';
		return;
	}
	box_ul.style.left = -width * i - j * width + 'px';
	}
	j += 0.05;
	var loop = setTimeout(tm,20);
}
var looper = setInterval(yidong,T);
var x,x1,x2;
box.addEventListener('touchstart',function(e){
	clearInterval(looper);
	var touch = e.changedTouches[0];
	x = touch.pageX;
	x1 = x;
	x2 = x1;
},false);
box.addEventListener('touchmove',function(e){
	var touch = e.changedTouches[0];
	x2 = touch.pageX;
	if(x != x2){
		e.preventDefault();
		box_ul.style.left = parseInt(box_ul.style.left) - (x - x2) + 'px';
		x = x2;
	}
},false);
box.addEventListener('touchend',function(e){
	var xx = x1 - x2;
	if(xx > 10){
		j = xx / W;
		B = false;
		tm();
		if(i == nodeNum){i = 0;}
		listC(tag('li',topList));
		tag('li',topList)[i].className = 'on';
		looper = setInterval(yidong,T);
	}else if((x2 -x1) > 0){
		j = -xx / W;
		B = true;
		i--;
		if(i <= 0){
			i = nodeNum;
		}
		tm();
		listC(tag('li',topList));
		tag('li',topList)[i - 1].className = 'on';
		looper = setInterval(yidong,T);
	}else{
		looper = setInterval(yidong,T);
	}
	x1 = x2;
},false);
}