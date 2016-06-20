<?php
/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array (
		/* 数据库配置 */
		'DB_TYPE' => 'mysql', // 数据库类型
		'DB_NAME' => 'damenghai', // 数据库名
		'DB_USER' => 'root', // 用户名
		'DB_HOST'   => '127.0.0.1', // 服务器地址
		'DB_PWD'    => 'Chaxinkeji2015',  // 密码
		'DB_PORT' => '3306', // 端口
		'DB_PREFIX' => '', // 数据库表前缀
		'SHOW_PAGE_TRACE' => false,
		

		/* URL配置 */
		'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
		'URL_MODEL' => 1, //URL模式
		'VAR_URL_PARAMS' => '', // PATHINFO URL参数变量
		'URL_PATHINFO_DEPR' => '/',  //PATHINFO URL分割符
		'savePath'=>'./Public/upload/com_logo/',//文件上傳存放的目錄

);


