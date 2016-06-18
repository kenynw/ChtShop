<?php
/**
 * 提供给APP使用的微信支付统一下单接口
 * Created by PhpStorm.
 * User: wuzuming
 * Date: 2015/10/29
 * Time: 15:53
 */
ini_set('date.timezone','Asia/Shanghai');

require_once "lib/WxPay.Api.php";
require_once "lib/WxPay.JsApiPay.php";

$order_sn = '123456789101';
$order_type = 'r';
$totalFee = '1';
$notifyUrl = WxPayConfig::NOTIFY_URL;

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody($order_sn);
$input->SetAttach($order_sn);
$input->SetOut_trade_no($order_sn.'-'.$order_type);
$input->SetTotal_fee($totalFee);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag($order_sn);
$input->SetNotify_url($notifyUrl);
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
//$jsApiParameters = $tools->GetJsApiParameters($order);
$result = array();
if(isset($order['error_code_des'])){
    $result['code'] = '404';
    $result['prepay_id'] = $order['error_code_des'];
}else{
    $result['code'] = '200';
    $result['prepay_id'] = $order['prepay_id'];
}
$jsonResult = json_encode($result);
echo $jsonResult;
exit;