(function(){
var listnavA = tag('a',cN('listnav')[0]);
var B = true;
listnavA[0].addEventListener('click',function(e){
	e.preventDefault();
	listnavA[0].className = 'on';
	listnavA[1].className = '';
	id('qianggou').style.display = 'block';
	id('yugao').style.display = 'none';
},false);
listnavA[1].addEventListener('click',function(e){
	e.preventDefault();
	listnavA[1].className = 'on';
	listnavA[0].className = '';
	id('qianggou').style.display = 'none';
	id('yugao').style.display = 'block';
	if(B){
		yugao();
		B = false;
	}
},false);
daojishi('times','mark');
})();