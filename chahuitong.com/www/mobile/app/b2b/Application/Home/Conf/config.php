<?php
return array (
		/* 模板相关配置 */
		'TMPL_PARSE_STRING' => array (
				'_STATIC_' => __ROOT__ . '/Public/static',
				'_IMG_' => __ROOT__ . '/Public/' . MODULE_NAME . '/img',
				'_UPL_' => __ROOT__ . '/Public/'.'/upload/com_logo/',
				'_CSS_' => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
				'_JS_' => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
				'_ADMIN_' => __ROOT__ . '/Public/' . MODULE_NAME,
				'_DATA_' => __ROOT__ . '/Data' 
		) ,
		'DB_TYPE' => 'mysql', // 数据库类型
		'DB_NAME' => 'shopncb2b2c', // 数据库名
		'DB_USER' => 'root', // 用户名
		'DB_HOST'   => 'localhost', // 服务器地址
		'DB_PWD'    => 'Chaxinkeji2015',  // 密码
		'DB_PORT' => '3306', // 端口
		'DB_PREFIX' => 'shopnc_', // 数据库表前缀
);