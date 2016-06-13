<?php
define('InShopNC','true');
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';
require_once 'lib/log_.php';

//初始化日志
$logHandler= new CLogFileHandler("logs/".date('Y-m-d').'.log');
$log = Log_::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log_::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}

	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log_::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();

		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			Log_::DEBUG("输入参数不正确");
			return false;
		}
		//查询订单，判断订单真实性
		/*
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			Log_::DEBUG("订单查询失败");
			return false;
		}
		*/
		$_GET['act'] = 'payment';
		$_GET['op']	= 'notify';
		$_GET['payment_code']	= 'wxpay';
		$_GET['transaction_id'] = $data["transaction_id"];
		$_GET['out_trade_no'] = $data["out_trade_no"];
		Log_::DEBUG("transaction_id：".$data["transaction_id"].",out_trade_no:".$data["out_trade_no"]);
		return true;
	}

}
/*$_GET['act'] = 'payment';
		$_GET['op']	= 'notify';
		$_GET['payment_code']	= 'wxpay';
		$_GET['transaction_id'] = '1001090963201510271353287132';
		$_GET['out_trade_no'] = '930499278446749068-r';
		require_once(dirname(__FILE__).'/../../../index.php');
exit;*/

Log_::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
require_once(dirname(__FILE__).'/../../../index.php');
