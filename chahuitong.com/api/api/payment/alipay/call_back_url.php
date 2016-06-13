<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 */
$raw_post_data = file_get_contents('php://input', 'r');
file_put_contents("1.txt",json_decode($raw_post_data,true));
$_GET['act'] = 'payment';
$_GET['op']	= 'return';
$_GET['payment_code']	= 'alipay';
require_once(dirname(__FILE__).'/../../../index.php');
?>
