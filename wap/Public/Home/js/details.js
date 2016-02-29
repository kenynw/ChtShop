window.addEventListener('load',function(){
	var W = document.body.clientWidth > 640 ? 640 : document.body.clientWidth;
	id('top').style.height = W * 10/ 24 + 'px';
	css(tag('ul',id('top'))[0],{height:W * 10/ 24 + 'px'});
	css(tag('li',tag('ul',id('top'))[0]),{height:W * 10/ 24 + 'px'});
	lunbo('top',3000,W);
},false);
(function(){
var canshu = id('canshu');
var canshuUl = tag('ul',cN('canshu')[0])[0];
var canshuLi = tag('li',canshuUl);
var num = canshuLi.length;
canshu.addEventListener('click',function(e){
	e.preventDefault();
	if(canshu.className != 'on'){
		canshu.className = 'on';
		css(canshuUl,{height:Math.ceil(num / 3) * 20 + 'px'});
		css(tag('img',canshu)[0],{transform:'rotate(-90deg)'});
	}else{
		canshu.className = '';
		css(canshuUl,{height:'40px'});
		css(tag('img',canshu)[0],{transform:'rotate(90deg)'});
	}
},false);
var list = id('list');
list.addEventListener('click',function(e){
	switch(e.target.dataset.ul){
		case 'details':
			moveOn();
			tag('li',list)[0].className = 'on';
			cN('details')[0].style.display = 'block';
			cN('pingjia')[0].style.display = 'none';
			break;
		case 'pingjia':
			moveOn();
			tag('li',list)[1].className = 'on';
			cN('details')[0].style.display = 'none';
			cN('pingjia')[0].style.display = 'block';
			break;
	}
},false);
function moveOn(){
	var listLi = tag('li',list);
	listC(listLi);
}
})();
(function(){
var pjImg = cN('pj_img');
id('show_img').style.height = window.innerHeight + 'px';
id('show_img').onclick = function(){
	id('show_img').style.display = 'none';
}
var num = pjImg.length;
var numImg;
if(num > 0){
	for(var i = 0;i < num;i++){
		numImg = tag('img',pjImg[i]);
		for(var j = 0;j < numImg.length;j++){
			imgClick(tag('img',pjImg[i])[j]);
		}
	}
}
function imgClick(obj){
	obj.onclick = function(){
		var node = obj.outerHTML;
		id('show_img').innerHTML = node;
		id('show_img').style.display = 'block';
	}
}
})();
(function(){
	var brandImg = tag('img',cN('brand')[0])[0];
	var i = 1;
	brandImg.addEventListener('click',function(){
		if(i%2 == 0){
			id('brand').style.display = 'block';
			css(brandImg,{transform:'rotate(90deg)'});
		}else{
			id('brand').style.display = 'none';
			css(brandImg,{transform:'rotate(-90deg)'});
		}
		i++;
	},false);
})();
(function(){
	var share = id('share');
	var fenxiang = id('fenxiang');
	var quxiao = id('quxiao');
	fenxiang.addEventListener('click',function(e){
		e.preventDefault();
		id('xuanze').style.display = 'none';
		share.style.display = 'block';
	},false);
	quxiao.addEventListener('click',function(e){
		e.preventDefault();
		share.style.display = 'none';
	},false);
})();
(function(){
var num = parseInt(id('num').innerText);
var pSpan = tag('span',id('leixing'));
for(var i = 0;i < pSpan.length;i++){
	spanChange(pSpan[i]);
}
function spanChange(obj){
	obj.addEventListener('click',function(){
		listC(pSpan);
		obj.className = 'on';
	},false);
}
id('jian').addEventListener('click',function(){
	if(num > 1){
		num--;
		id('num').innerText = num;
	}
},false);
id('jia').addEventListener('click',function(){
	num++;
	id('num').innerText = num;
},false);
id('close').addEventListener('click',function(){
	id('xuanze').style.display = 'none';
},false);
id('shopselect').addEventListener('click',function(e){
	e.preventDefault();
	id('xuanze').style.display = 'block';
},false);
})();
toTop();