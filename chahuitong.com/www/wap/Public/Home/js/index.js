$(function() {
	  	
	


    $.ajax({
        url: ApiUrl + "/index.php?act=index",
        type: 'get',
        dataType: 'json',
        success: function(result) {
			
            var data = result.datas;
			
            var html = '';
            $.each(data, function(k, v) {
                $.each(v, function(kk, vv) {
                    switch (kk) {
                        case 'adv_list':
                        case 'home3':
                            $.each(vv.item, function(k3, v3) {
                                vv.item[k3].url = buildUrl(v3.type, v3.data);
                            });
                            break;
                        case 'home1':
                            vv.url = buildUrl(vv.type, vv.data);
                            break;
                        case 'home2':
                        case 'home4':
                            vv.square_url = buildUrl(vv.square_type, vv.square_data);
                            vv.rectangle1_url = buildUrl(vv.rectangle1_type, vv.rectangle1_data);
                            vv.rectangle2_url = buildUrl(vv.rectangle2_type, vv.rectangle2_data);
                            break;
                    }
                    html += template.render(kk, vv);
                    return false;
                });
            });
			
            $("#main-container").html(html);

				TouchSlide({ 
					slideCell:"#focus",
					titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
					mainCell:".bd ul", 
					effect:"leftLoop", 
					autoPlay:false,//自动播放
					autoPage:true //自动分页
				});
				TouchSlide({ 
					slideCell:"#slideBox",
					titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
					mainCell:".bd ul", 
					effect:"leftLoop", 
					autoPage:true //自动分页
				});		
				$('#search-btn1').click(function(){
		
        var keyword = encodeURIComponent($('#key2').val());
        location.href = WapSiteUrl+'/index.php/Home/index/product_list?keyword='+keyword;
                  });
        }
		
		
		
		
    });
	
	if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
		$(".top").css('height','0');
		$("#topss").css('display','none');
		$(".nav1").css('display','none');
		//$(".focus").css("margin-top","0px");
		//alert("1111");
		//document.getElementById("topss").style.display="none";
	}


});

 