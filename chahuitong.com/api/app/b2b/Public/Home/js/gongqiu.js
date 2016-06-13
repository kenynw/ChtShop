window.onload=function(){
	var w=$('.pic').width();
	$('.pic').height(w);
	if(w>85){$('.details ul li').height(w+5);}
	$(".picimg").each(function(){
        var width=$(this).width();
		var height=$(this).height();
		var parentWidth=w;
		var parentHeight=w;
		var ratioWidth=parentWidth/width;
		var ratioHeight=parentHeight/height;
		if(height>parentHeight && width>parentWidth){
			if(height>width){
				$(this).width(parentWidth);
				$(this).height(height*ratioWidth);
			}else{
				$(this).height(parentHeight+2);
				$(this).width(width*ratioHeight);
			}
			width=$(this).width();
			height=$(this).height();
			if(height>width){
				$(this).css("top",(parentHeight-height)/2);
			}else{
				$(this).css("left",(parentWidth-width)/2);
			}
		}else{
			$(this).css("left",(parentWidth-width)/2);
			$(this).css("top",(parentHeight-height)/2);
		}
    });
};