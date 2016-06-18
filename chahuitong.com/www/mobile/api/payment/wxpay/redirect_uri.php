<?php
$_GET['act']	= 'payment';
$_GET['op']		= 'return';
$_GET['payment_code'] = 'wxpay';
require_once(dirname(__FILE__).'/../../../index.php');