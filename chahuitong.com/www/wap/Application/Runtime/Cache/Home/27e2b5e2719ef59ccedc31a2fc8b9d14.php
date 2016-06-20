<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>填写核对购物信息</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/main.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/class.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/shopcart.css">
	<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/child.css">
</head>
<body>
    <header>
<a href="javascript:history.back()"><img src="/wap/Public/Home/img/fanhui.png"></a>确认订单
<a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div id="nav" class="nav" style="padding-bottom:3px;border-bottom:1px solid #999">
<span>1.购物车</span>&gt;<span class="on">2.确认</span>&gt;<span>3.付款</span>&gt;<span>4.完成</span>
</div>
    <div class="buy_step1" style="background:#FFF">
    
        <div class="buys1-cnt" id="container-fcode" style="display:none;">
           <h3 class="clearfix">使用F码购买商品</h3>
           <ul class="buys-ycnt">
                <li class="clearfix buys-yc-type">
                    <p class="clearfix">
                        <input type="text" class="mr5 h22" name="fcode" id="fcode" placeholder="输入F码" />
                    </p>
                    <p class="fcode_error_tip" style="display:none;color:red;"></p>
                </li>
           </ul>
        </div>

       <div class="buys1-cnt buys1-address-cnt">
           <h3 class="clearfix">收货人信息 <span class="btn-s btn-prink-s fright buys1-edit-address buys1-edit-btn">修改</span></h3>
           <ul class="buys-ycnt buys1-hide-detail">
                <li class="clearfix">
                    <span class="key fleft">姓名：</span>
                    <div class="value fleft" id="true_name"></div>
                </li>
                <li class="clearfix">
                    <span class="key fleft">详细地址：</span>
                    <div class="value fleft" id="address"></div>
                </li>
                <li class="clearfix">
                    <span class="key fleft">联系电话：</span>
                    <div class="value fleft" id="mob_phone"></div>
                </li>
           </ul>
           <ul class="buys1-hide-list buys-ycnt hide">
                <li id="addresslist">
                    <label class="new-address clr-d94">
                        <input type="radio" name="address" value="0" class="address-radio" id="new-address-button" />
                        使用新的地址信息
                    </label>
                    <div class="invoice-addcnt" id="new-address-wrapper" style="display:none;">
                        <div class="iadd-title">
                            收货人信息：
                        </div>
                        <div>
                            <p class="iadd-ip">姓名：<span class="opera-tips">(*必填)</span></p>
                            <p class="iadd-ip">
                                <input type="text" class="n-input h22 wp100" name="true_name" id="vtrue_name"/>
                            </p>
                            <p class="iadd-ip"> 手机号码:<span class="opera-tips">(*必填)</span></p>
                            <p class="iadd-ip">
                                <input type="tel" class="n-input h22 wp100" name="mob_phone" id="vmob_phone"/>
                            </p>
                           <!-- <p class="iadd-ip"> 电话号码:</p>
                            <p class="iadd-ip">
                                <input type="text" class="n-input h22 wp100" name="tel_phone" id="vtel_phone"/>
                            </p>-->
                        </div>
                        <div class="iadd-title"> 地址信息：</div>
                        <div>
                        	<p class="iadd-ip">省份：<span class="opera-tips">(*必填)</span></p>
                            <p class="iadd-ip">
						        <select class="select-30" name="prov" id="vprov">
									<option value="">请选择...</option>
						        </select>
                            </p>
                            <p class="iadd-ip">城市：<span class="opera-tips">(*必填)</span></p>
                            <p class="iadd-ip">
						 		<select class="select-30" name="city" id="vcity">
									<option value="">请选择...</option>
						        </select>
                            </p>
                            <p class="iadd-ip"> 区县：<span class="opera-tips">(*必填)</span></p>
                            <p class="iadd-ip">
						       	<select class="select-30" name="region" id="vregion">
									<option value="">请选择...</option>
						        </select>
                            </p>
                            <p class="iadd-ip"> 街道：<span class="opera-tips">(*必填)</span></p>
                            <p class="iadd-ip">
                                <input type="text" class="n-input h22 wp100" name="vaddress" id="vaddress">
                            </p>
                        </div>
                    </div>
                    <div class="error-tips"></div>
                </li>
                <li class="invoice_opeara">
                    <a href="javascript:void(0);" class="btn-prink save-address">保存地址信息</a>
                </li>
            </ul>
        </div>
        <div class="buys1-cnt">
           <h3 class="clearfix">支付方式</h3>
           <ul class="buys-ycnt">
                <li class="clearfix buys-yc-type">
                    <label id="online">
                        <input type="radio" name="buy-type" class="mr5" checked value="online" id="buy-type-online">在线支付
                    </label>
                    <label class="mt5" id="offline">
                        <input type="radio" name="buy-type" class="mr5" value="offline" id="buy-type-offline"/>货到付款
                    </label>
                </li>
           </ul>
        </div>
       <div class="buys1-cnt buys1-invoice-cnt" style="display:none">
           <h3 class="clearfix">发票信息 <span class="btn-s btn-prink-s buys1-edit-invoice buys1-edit-btn fright">修改</span></h3>
           <ul class="buys-ycnt buys1-hide-detail">
                 <li class="clearfix">
                    <div class="value fleft" id="inv_content"></div>
                </li>
           </ul>
            <ul class="buys1-hide-list buys-ycnt hide">
                <li id="invoice_add">
                    <label class="new-invoice clr-d94">
                        <input type="radio" name="invoice" value="0" class="inv-radio"/>
                        使用新的发票信息
                    </label>
                    <div class="invoice-addcnt">
                        <div class="iadd-title">发票抬头：</div>
                        <div class="iadd-item">
                            <label>
                                <input type="radio" checked="checked" name="inv_title_select" class="mr5" value="person" >个人
                            </label>
                            <label class="mt5">
                                <input type="radio" name="inv_title_select" class="mr5 inv-tlt-sle" value="company">
                                <span class="mr5">企业</span>
                                <input type="text" class="input-30 head-invoice" name="inv_title">
                            </label>
                        </div>
                        <div class="iadd-title">
                          	发票内容：
                        </div>
                        <p class="iadd-cnt">
                            <select class="select-30" id="inc_content" name='inv_content'>
                            </select>
                        </p>
                    </div>
                </li>
                <li class="invoice_opeara">
                    <a href="javascript:void(0);" class="btn-prink save-invoice">保存发票信息</a>
                    <a href="javascript:void(0);" class="btn-white no-invoice">不需要发票</a>
                </li>
            </ul>
       </div>
       <div class="buys1-cnt">
           <h3 class="clearfix">商品清单<!--  <span class="btn-s btn-prink-s fright" onclick="javascript:history.go(-1);">去购物车</span> --> </h3>
           <ul class="buys-ytable mt10" id="goodslist_before">
               <li id="deposit">
                  <div class="pre-deposit-wp hide">
                    <p class="clearfix hide" id="wrapper-usercbpay">
                        <label>
                            <input type="checkbox" class="mr5" id="usercbpay" />使用充值卡支付
                        </label>
                        (充值卡余额为<span class="pre-doposit-money clr-d94">￥<span id="available_rc_balance"></span></span>)
                    </p>
                    <p class="clearfix hide" id="wrapper-usepdpy">
                        <label>
                            <input type="checkbox" class="mr5" id="usepdpy" />使用预存款支付
                        </label>
                        (可用金额为<span class="pre-doposit-money clr-d94">￥<span id="available_predeposit"></span></span>)
                    </p>

                      <div id="pd" class="hide">
	                      <p class="clearfix">
	                          支付密码：<input type="password" class="mr5 h22" name="loginpassword" id="loginpassword" />
	                      </p>
	                      <p class="password_error_tip" style="display:none;color:red;"></p>
	                      <p>
	                          <span class="btn-s btn-yello-s" id="pguse">使用</span>
	                      </p>
                      </div>
                  </div>
               </li>
               <li class="bd-t-cc" style="display:none">
                   <div class="buys-order-total">
                       订单总金额：￥<span ></span>
                       <span id="online-total-wrapper">（需在线支付：￥<span id="online-total">0.00</span>）</span>
                   </div>
               </li>
               <li style="display:none">
                   <a href="javascript:void(0);" >提交订单</a>
               </li>
           </ul>
       </div>
       <nav>
    <div class="zongjine" style="  float: left;
  line-height: 55px;
  width: 67%;
  text-align: left;
  margin-left: 5%;
  color: #898989;"><div>总金额:￥<span><span class="total" id="total_price"></span></span></div></div>
    <div class="jiesuan post-order"  id="buy_step2">提交订单</div>
    </nav>
    </div>
    <input type="hidden" name="address_id">
    <input type="hidden" name="area_id">
    <input type="hidden" name="city_id">
    <input type="hidden" name="freight_hash">
    <input type="hidden" name="vat_hash">
    <input type="hidden" name="allow_offpay">
    <input type="hidden" name="offpay_hash">
    <input type="hidden" name="offpay_hash_batch">
	<input type="hidden" name="invoice_id">
	<input type="hidden" name="passwd_verify" value="0">
	<input type="hidden" name="total_price">
	<input type="hidden" name="available_rc_balance">
	<input type="hidden" name="available_predeposit">

    <script type="text/javascript" src="/wap/Public/Home/js/config.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/zepto.min.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/template.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/common.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/simple-plugin.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/common-top.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/buy_step1.js"></script>
    <script>
	
	window.onload=function(){
		if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
		$("header").hide();
		$(".header").hide();
		//$("#topss").css('display','none');
		//$(".focus").css("margin-top","0px");
		//alert("1111");
		//document.getElementById("topss").style.display="none";
	  }	
    };
	</script>
</body>
</html>