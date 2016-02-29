<?php

ini_set('date.timezone','Asia/Shanghai');

require_once "lib/WxPay.Api.php";
require_once "lib/WxPay.JsApiPay.php";

class wxpay{

    function submit($param){
        $this->order_sn = $param['order_sn'];    //支付单号
        $this->order_amount = $param['order_amount'];
        $this->order_type = $param['order_type'];
        $this->order_num = $param['order_num'];    //订单编号
        $totalFee = $this->order_amount*100;
        //①、获取用户openid
        $tools = new JsApiPay();
        $openId = $tools->GetOpenid();

        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody($this->order_sn);
        $input->SetAttach($this->order_sn);
        $input->SetOut_trade_no($this->order_sn.'-'.$this->order_type);
        $input->SetTotal_fee($totalFee);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($this->order_sn);
        $input->SetNotify_url(WxPayConfig::NOTIFY_URL);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        //echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
        //$this->printf_info($order);

        $jsApiParameters = $tools->GetJsApiParameters($order);
        if(array_key_exists("error_code_des", $jsApiParameters)){
            echo '<div style="text-align:center;font-size:34px;padding-top:350px;">'.$jsApiParameters['error_code_des'].'</div>';
            exit;
        }
        //获取共享收货地址js函数参数
        //$editAddress = $tools->GetEditAddressParameters();

        //③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
        /**
         * 注意：
         * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
         * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
         * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
         */
        //echo $jsApiParameters;
        echo '<html>
                <head>
                    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
	                <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
                    <title>微信安全支付</title>

                    <script type="text/javascript">

                        //调用微信JS api 支付
                        function jsApiCall()
                        {
                            WeixinJSBridge.invoke(
                                \'getBrandWCPayRequest\',
                            '.$jsApiParameters.',
                            function(res){
                                //alert(res.err_code+","+res.err_desc+","+res.err_msg);
                                if(res.err_msg=="get_brand_wcpay_request:cancel" || res.err_msg=="get_brand_wcpay_request:fail"){
									return;
				                }
				                if(res.err_msg == "get_brand_wcpay_request:ok" ) {
				                    var redirectUrl = "http://www.chahuitong.com/mobile/api/payment/wxpay/redirect_uri.php";
				                    //var orderUrl = "http://www.chahuitong.com/wap/index.php/Home/Index/orderList";
				                    location.href = redirectUrl;
				                    return false;   //不添加此项的话，会导致页面跳转失败
					            }
                                WeixinJSBridge.log(res.err_msg);
                            }
                        );
                        }

                        function callpay()
                        {
                            if (typeof WeixinJSBridge == "undefined"){
                                if( document.addEventListener ){
                                    document.addEventListener(\'WeixinJSBridgeReady\', jsApiCall, false);
                                }else if (document.attachEvent){
                                    document.attachEvent(\'WeixinJSBridgeReady\', jsApiCall);
                                    document.attachEvent(\'onWeixinJSBridgeReady\', jsApiCall);
                                }
                            }else{
                                jsApiCall();
                            }
                        }

                    </script>
                    <style>
                        *{margin:0;padding:0;}
                        body{background:#f5f5f5;text-align:center;width:100%;max-width:640px;margin:0 auto;}
                        h3{padding:15px 0;font-size:1.3em;}
                        h1{padding-bottom:30px;font-size:3.8em;}
                        .pay{background:#fff;width:80%;font-size:1.3em;text-align:left;margin:0 auto;line-height:75px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;padding:0 5%;}
                        .pay span{float:right;font-weight:700;}
                        button{margin-top:25px;margin-bottom:80px;color:#fff;font-size:1.5em;line-height:48px;border:none;background:#1b8b80;width:80%;border-radius:5px;}
                        p{color:#898989;font-size:0.9em;}
                        @media screen and (max-width:340px){
                        h3{font-size:1.1em;}
                        h1{font-size:3em;}
                        p{font-size:0.8em;}
                        a{text-decoration:none;color:#000;}
                    </style>
                </head>
                <body>
                <h3>茶汇通-订单编号<a href="javascript:;">'.$this->order_num.'</a></h3>
                <h1>￥'.number_format($this->order_amount,2).'</h1>
                <div class="pay">
                收款方<span>茶汇通</span>
                </div>
                <div align="center">
                    <button onclick="callpay()" >立即支付</button>
                </div>
                <p>支付安全由中国人民财产保险股份有限公司承保</p>
                </body>
            </html>';
    }


    //打印输出数组信息
    function printf_info($data)
    {
        foreach($data as $key=>$value){
            echo "<font color='#00ff55;'>$key</font> : $value <br/>";
        }
    }

}

?>

