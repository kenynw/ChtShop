window.onload=function(){
	var pic=document.getElementsByName('pic');
	var winW = document.getElementById('focus').offsetWidth || document.body.offsetWidth;
	var realW=winW*0.75;
	var realH=realW;
	for(var i=0;i<pic.length;i++){
		var img=new Image();
		img.src=pic[i].src;
		var w=img.width;
		var h=img.height;
		if(w>h){
			pic[i].style.width=realW+'px';
			var newH=pic[i].offsetHeight;
			pic[i].style.marginTop=(realH-newH)/2+'px';
		}else{
			pic[i].style.height=realH+'px';
		}
	}
}