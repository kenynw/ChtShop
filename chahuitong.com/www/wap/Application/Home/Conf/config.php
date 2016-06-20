<?php
return array(
    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '_STATIC_' => __ROOT__ . '/Public/static',
        '_IMG_' => __ROOT__ . '/Public/' . MODULE_NAME . '/img',
        '_UPL_' => __ROOT__ . '/Public/' . '/upload/com_logo/',
        '_CSS_' => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '_JS_' => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
        '_ADMIN_' => __ROOT__ . '/Public/' . MODULE_NAME,
        '_DATA_' => __ROOT__ . '/Data',
        '_SHOP_' => "http://www.chahuitong.com",
        '_UPLOAD_' => 'http://img.chahuitong.com'
    ),
    'SESSION_OPTIONS' => array('path' => '../data/session/')

);