<?php
/**
 * 手机接口初始化文件
 *
 *
 
 */

define('APP_ID','mobile');
define('IGNORE_EXCEPTION', true);
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));

if (!@include(dirname(dirname(dirname(__FILE__))).'/global.php')) exit('global.php isn\'t exists!');
if (!@include(BASE_CORE_PATH.'/33hao.php')) exit('33hao.php isn\'t exists!');

if (!@include(BASE_PATH.'/config/config.ini.php')){
    exit('config.ini.php isn\'t exists!');
}

//框架扩展
require(BASE_PATH.'/framework/function/function.php');
if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');
define('API_SITE_URL',MOBILE_SITE_URL);
define('TPL_NAME',TPL_SHOP_NAME);
define('API_RESOURCE_SITE_URL',MOBILE_SITE_URL.DS.'resource');
define('API_TEMPLATES_URL',MOBILE_SITE_URL.'/templates/'.TPL_NAME);
define('BASE_TPL_PATH',BASE_PATH.'/templates/'.TPL_NAME);

Base::run();
