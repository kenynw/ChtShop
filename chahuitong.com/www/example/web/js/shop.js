//daojishi('countdown','span');
function tuijianL(){
	var tuijiaList = cN('tuijia_list')[0];
	var num = tag('li',tuijiaList).length;
	var tuijianUl = tag('ul',tuijiaList)[0];
	tuijianUl.style.width = 112 * num + 'px';
	tuijianUl.style.left = 0;
	var x,x1;
	tuijiaList.addEventListener('touchstart',function(e){
		var touch = e.changedTouches[0];
		x = touch.pageX;
		x1 = x;
	},false);
	tuijiaList.addEventListener('touchmove',function(e){
		var touch = e.changedTouches[0];
		x1 = touch.pageX;
		if(x != x1){
			e.preventDefault();
			tuijianUl.style.left = parseInt(tuijianUl.style.left) - (x - x1) + 'px';
			x = x1;
		}
		if(parseInt(tuijianUl.style.left) < -(W /3 + W * 0.005) * num + W){
			tuijianUl.style.left = -(W /3 + W * 0.005) * num + W + 'px';
		}else if(parseInt(tuijianUl.style.left) > 0){
			tuijianUl.style.left = 0 + 'px';
		}
	},false);
};