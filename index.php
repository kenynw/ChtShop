<?php
/**
 * 入口
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
$agent = $_SERVER['HTTP_USER_AGENT'];
if(strpos($agent,"comFront") || strpos($agent,"iPhone") || strpos($agent,"iOS") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") || strpos($agent,"UCWEB") || strpos($agent,"UCBrowser") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS") || strpos($agent,"mobile")){
	$site_url = strtolower('http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/index.php')).'/wap');
	@header('Location: '.$site_url);}
else{
	$site_url = strtolower('http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/index.php')).'/shop/index.php');
	@header('Location: '.$site_url);}


