$(function (){
    var key = getcookie('key');
    if(key==''){
        window.location.href = WapSiteUrl+'/index.php/Home/Index/login';
    }else{
        //初始化页面数据
        function initCartList(){
             $.ajax({
                url:ApiUrl+"/index.php?act=member_cart&op=cart_list",
                type:"post",
                dataType:"json",
                data:{key:key},
                success:function (result){
                    if(checklogin(result.login)){
                        if(!result.datas.error){
							if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
		                 
		                    $("header").css('display','none');
		
	                            }
                            var rData = result.datas;
                            rData.WapSiteUrl = WapSiteUrl;
                            var html = template.render('cart-list', rData);
                            $("#cart-list-wp").html(html);
                            //删除购物车
                            $(".cart-list-del").click(delCartList);
                             //购买数量，减
                            $(".minus-wp").click(minusBuyNum);
                            //购买数量加
                            $(".add-wp").click(addBuyNum);
                            //去结算
                            $(".jiesuan").click(goSettlement);
                            $(".buynum").blur(buyNumer);
							//重新添加到购物车
							$("#inneed .box").click(addagain);
							//全部删除功能
							$("#roundedTwo").click(delAll);
							//全部添加功能
							$("#roundedTwo1").click(appAll)
							var money=$(".total_price").html();
							$('.total').html(money);
							//购物车个数
							var num=$("#cart-list-wp .cart-list .liebiao").length;
							$(".num").html(num);
                        }else{
                           alert(result.datas.error);
                        }
                    }
                }
            });
        }
        initCartList();
        //删除购物车
        function delCartList(){
            var  cart_id = $(this).attr("cart_id");			
			$(this).parent("div").css("background","none");
			var  liebiao=$(this).parent("div").parent().html();
			$(this).parent("div").parent().remove();
            $.ajax({
                url:ApiUrl+"/index.php?act=member_cart&op=cart_del",
                type:"post",
                data:{key:key,cart_id:cart_id},
                dataType:"json",
                success:function (res){
                    if(checklogin(res.login)){
                        if(!res.datas.error && res.datas == "1"){
							//alert();
                            initCartList();
							//liebiao;
							//alert(liebiao);
							$("#inneed").append("<li class='liebiao' id='"+cart_id+"'>"+liebiao+"</li>");
							//alert(h)
                        }else{
                            alert(res.datas.error);
                        }
                    }
                }
            });
        }
		
		//清空购物车
		function delAll(){

			$("#cart-list-wp .cart-list .liebiao .box .cart-list-del").each(function(){
				
			var cart_id=$(this).attr("cart_id");
				
			$(this).parent("div").css("background","none");
			var  liebiao=$(this).parent("div").parent().html();
			$(this).parent("div").parent().remove();
            $.ajax({
                url:ApiUrl+"/index.php?act=member_cart&op=cart_del",
                type:"post",
                data:{key:key,cart_id:cart_id},
                dataType:"json",
                success:function (res){
                    if(checklogin(res.login)){
                        if(!res.datas.error && res.datas == "1"){
							//alert();
                            initCartList();
							//liebiao;
							//alert(liebiao);
							$("#inneed").append("<li class='liebiao' id='"+cart_id+"'>"+liebiao+"</li>");
							$(".roundedTwo").attr("id","roundedTwo1");
							//alert(h)
                        }else{
                            alert(res.datas.error);
                         }
                      }
                    }
                       });
		
				
				})
	
			}
		//全选购物车
		function appAll(){

			$("#inneed .cart-list-del").each(function(){
				
			var cart_id=$(this).attr("cart_id");
				
			 $.ajax({
                url:ApiUrl+"/index.php?act=member_cart&op=cart_again",
                type:"post",
                data:{key:key,cart_id:cart_id},
                dataType:"json",
                success:function (res){
                    if(checklogin(res.login)){
                        if(!res.datas.error && res.datas == "1"){							                           
							//alert(cart_id)
							$("#"+cart_id).remove();
							$(".roundedTwo").attr("id","roundedTwo");
                        }else{
                            alert(res.datas.error);
                        }
                    }
                }
               });
		
				initCartList();
				})
	
			}	
				
        //购买数量减
        function minusBuyNum(){
            var self = this;
            editQuantity(self,"minus");
        }
        //购买数量加
        function addBuyNum(){
            var self = this;
            editQuantity(self,"add");
        }
        //购买数量增或减，请求获取新的价格
        function editQuantity(self,type){
            var sPrents = $(self).parents(".cart-litemw-cnt")
            var cart_id = sPrents.attr("cart_id");
            var numInput = sPrents.find(".buy-num");
            var buynum = parseInt(numInput.val());
            var quantity = 1;
            if(type == "add"){
                quantity = parseInt(buynum+1);
                // 
            }else {
                if(buynum >1){
                    quantity = parseInt(buynum-1);
                }else {
                    $.sDialog({
                        skin:"red",
                        content:'购买数目必须大于1',
                        okBtn:false,
                        cancelBtn:false
                    });
                    return;
                }
            }
            $.ajax({
                url:ApiUrl+"/index.php?act=member_cart&op=cart_edit_quantity",
                type:"post",
                data:{key:key,cart_id:cart_id,quantity:quantity},
                dataType:"json",
                success:function (res){
                    if(checklogin(res.login)){
                        if(!res.datas.error){
                            numInput.val(quantity);
                            sPrents.find(".goods-total-price").html(res.datas.total_price);
                            var goodsTotal = $(".goods-total-price");
                            var totalPrice = parseFloat("0.00");
                            for(var i = 0;i<goodsTotal.length;i++){
                                totalPrice += parseFloat($(goodsTotal[i]).html());
                            }
                            $(".total_price").html("￥"+totalPrice.toFixed(2));
							var money=$(".total_price").html();
							$('.total').html(money);
                        }else{
                           /* $.sDialog({
                                skin:"red",
                                content:res.datas.error,
                                okBtn:false,
                                cancelBtn:false
                            });*/
							alert(res.datas.error);
                        }
                    }
                }
            });
        }
		
		//重新添加到购物车
		function addagain(){			
			var  cart_id = $(this).find(".cart-list-del").attr("cart_id");						
			//alert(cart_id);			
            $.ajax({
                url:ApiUrl+"/index.php?act=member_cart&op=cart_again",
                type:"post",
                data:{key:key,cart_id:cart_id},
                dataType:"json",
                success:function (res){
                    if(checklogin(res.login)){
                        if(!res.datas.error && res.datas == "1"){							                           
							//alert(cart_id)
							$("#"+cart_id).remove();
                        }else{
                            alert(res.datas.error);
                        }
                    }
                }
            });
					
		}
		
		
		
		
		
        //去结算
        function goSettlement(){
            //购物车ID
            var cartIdArr = [];
            var cartIdEl = $(".cart-litemw-cnt");
            for(var i = 0;i<cartIdEl.length;i++){
                var cartId = $(cartIdEl[i]).attr("cart_id");
                var cartNum = parseInt($(cartIdEl[i]).find(".buy-num").val());
                var cartIdNum = cartId+"|"+cartNum;
                cartIdArr.push(cartIdNum);
            }
            var cart_id = cartIdArr.toString();
            window.location.href = WapSiteUrl + "/index.php/Home/Index/buy_step1?ifcart=1&cart_id="+cart_id;
        }
        //验证
        $.sValid.init({
            rules:{
                buynum:"digits"
            },
            messages:{
                buynum:"请输入正确的数字"
            },
            callback:function (eId,eMsg,eRules){
                if(eId.length >0){
                    var errorHtml = "";
                    $.map(eMsg,function (idx,item){
                        errorHtml += "<p>"+idx+"</p>";
                    });
                    $.sDialog({
                        skin:"red",
                        content:errorHtml,
                        okBtn:false,
                        cancelBtn:false
                    });
                }
            }  
        });
        function buyNumer(){
            $.sValid();
        }
    }
});