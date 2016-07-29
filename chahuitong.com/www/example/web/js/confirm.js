(function(){
var shopcar = id('shopcar');
var box = tag('li',shopcar);
var jian = cN('jian',shopcar);
var jia = cN('jia',shopcar);
var genum = cN('num',shopcar);
for(var i = 0;i <box.length;i++){
	jjian(jian[i]);
	jjia(jia[i]);
	changeNum(genum[i]);
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
	var boxLi,danjia = 0,num = 1,youfei = 0;
	for(var j = 0;j < box.length;j++){
			boxLi = box[j];
			danjia = parseInt(tag('mark',boxLi)[0].innerText*100);
			num = cN('num',boxLi)[0].value;
			if(cN('youfei',boxLi)[0]){
				youfei = parseInt(cN('youfei',boxLi)[0].innerText * 100);
			}
			if(cN('mon',boxLi)[0]){
				cN('mon',boxLi)[0].innerText = (danjia * num + youfei) / 100;
			}
			zonghe += (danjia * num + youfei)/ 100;
	}
	id('heji').innerText = zonghe;
}
})();