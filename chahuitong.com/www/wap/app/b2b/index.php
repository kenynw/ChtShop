<?php
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);
// 绑定Admin模块到当前入口文件
//define('BIND_MODULE','Admin'); // 定义默认模块

// 定义应用目录
define('APP_PATH','./Application/');
define('BUILD_DIR_SECURE', false);// 不生成目录安全文件

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';


// 亲^_^ 后面不需要任何代码了 就是如此简单