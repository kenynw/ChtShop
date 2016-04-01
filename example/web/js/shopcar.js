(function(){
var shopcar = id('shopcar');
var tol = id('tol');
var ddd = id('ddd');
var box = cN('box',shopcar);
var jian = cN('jian',shopcar);
var jia = cN('jia',shopcar);
var genum = cN('num',shopcar);
var bianji = id('bianji');
var wancheng = id('wancheng');
ddd.addEventListener('change',function(){
	for(var i = 0;i < box.length;i++){
		box[i].checked = true;
	}
	ddd.checked = true;
	tongji();
},false);
for(var i = 0;i <box.length;i++){
	changeTol(box[i]);
	jjian(jian[i]);
	jjia(jia[i]);
	changeNum(genum[i]);
}
function changeTol(obj){
	obj.addEventListener('change',function(){
		ddd.checked = false;
		tongji();
	},false);
}
function jjian(obj){
	obj.addEventListener('click',function(){
		var value = parseInt(tag('input',obj.parentNode)[0].value);
		value--;
		if(value <= 0){
			value = 1;
		}
		tag('input',obj.parentNode)[0].value = value;
		tongji();
	},false);
}
function jjia(obj){
	obj.addEventListener('click',function(){
		var input = tag('input',obj.parentNode)[0]
		var value = parseInt(input.value);
		value++;
		if(input.dataset.max && (value > input.dataset.max)){
			value = input.dataset.max;
		}
		tag('input',obj.parentNode)[0].value = value;
		tongji();
	},false);
}
function changeNum(obj){
	obj.addEventListener('change',function(){
		if(obj.value <= 0 || !obj.value){
			obj.value = 1;
		}else if(obj.dataset.max && (obj.value > obj.dataset.max)){
			obj.value = obj.dataset.max;
		}
		tongji();
	},false);
}
tongji();
function tongji(){
	var zonghe = 0;
	var boxLi,danjia = 0,num = 1;
	for(var j = 0;j < box.length;j++){
		if(box[j].checked){
			boxLi = box[j].parentNode.parentNode;
			danjia = parseInt(tag('mark',boxLi)[0].innerText*100);
			num = cN('num',boxLi)[0].value;
			zonghe += (danjia * num)/ 100;
		}
	}
	id('heji').innerText = zonghe;
}
bianji.addEventListener('click',function(e){
	e.preventDefault();
	bianji.style.display = 'none';
	wancheng.style.display = 'block';
	cN('heji')[0].style.display = 'none';
	id('jiesuan').style.display = 'none';
	id('move').style.display = 'block';
	id('shanchu').style.display = 'block';
},false);
wancheng.addEventListener('click',function(e){
	e.preventDefault();
	bianji.style.display = 'block';
	wancheng.style.display = 'none';
	cN('heji')[0].style.display = 'block';
	id('jiesuan').style.display = 'block';
	id('move').style.display = 'none';
	id('shanchu').style.display = 'none';
},false);
id('shanchu').addEventListener('click',function(e){
	e.preventDefault();
	removeLi();
},false);
function removeLi(){
	if(box.length > 0){
		for(var j = 0;j < box.length;j++){
			if(box[j].checked){
				var boxLi = box[j].parentNode.parentNode;
				boxLi.parentNode.removeChild(boxLi);
				tongji();
				setTimeout(removeLi,0);
				break;
			}
		}
	}else{
		kongShow();
	}
}
kongShow();
function kongShow(){
	if(id('shopcar') && tag('li',id('shopcar')).length){
		id('kong').style.display = 'none';
	}else{
		id('kong').style.display = 'block';
		bianji.style.display = 'none';
		wancheng.style.display = 'none';
		cN('tol')[0].style.display = 'none';
	}
}
})();