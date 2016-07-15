<?php
defined('InShopNC') or exit('Access Invalid!');

$config = array();
$config['base_site_url']        = 'http://www.chahuitong.com';
$config['shop_site_url'] 		= 'http://www.chahuitong.com/shop';
$config['cms_site_url'] 		= 'http://www.chahuitong.com/cms';
$config['microshop_site_url'] 	= 'http://www.chahuitong.com/ms';
$config['circle_site_url'] 		= 'http://www.chahuitong.com/circle';
$config['admin_site_url'] 		= 'http://system.chahuitong.com';
$config['mobile_site_url'] 		= 'http://api.chahuitong.com';
$config['wap_site_url'] 		= 'http://m.chahuitong.com';
$config['chat_site_url'] 		= 'http://www.chahuitong.com/chat';
$config['node_site_url'] 		= 'http://www.chahuitong.com:8090';
$config['upload_site_url']		= 'http://img.chahuitong.com';
$config['resource_site_url']	= 'http://res.chahuitong.com';

# 系统版本号,安装时自动生成
$config['version'] 		= '201502020388';

# 系统安装日期,安装时自动生成
$config['setup_date'] 	= '2015-05-27 09:42:33';

# 是否开启 gzip 压缩
$config['gip'] 			= 0;

# 数据库连接驱动,支持 mysqli(默认),mysql
$config['dbdriver'] 	= 'mysqli';

# 数据库表前缀
$config['tablepre']		= 'shopnc_';

# 主数据库配置,只允许配置一台(单台数据库时,只配置主数据库即可)
$config['db']['1']['dbhost']       = 'localhost';
$config['db']['1']['dbport']       = '3306';
$config['db']['1']['dbuser']       = 'root';
$config['db']['1']['dbpwd']        = 'Chaxinkeji2015';
$config['db']['1']['dbname']       = 'shopncb2b2c';
$config['db']['1']['dbcharset']    = 'UTF-8';

# 如果没有从数据库,可以使用以下配置
$config['db']['slave']                  = $config['db']['master'];

# 系统缓存默认时间,单(秒),默认 1 小时
$config['session_expire'] 	= 3600;

# 语言包,默认 zh_cn(简体)
$config['lang_type'] 		= 'zh_cn';

# cookie 前缀,安装时自动生成
$config['cookie_pre'] 		= '1778_';

# 生成缩略图处理工具 可选为 gd(默认)或 im,分别代表 GD 库和 imagemagick
$config['thumb']['cut_type'] = 'gd';

# convert 可执行文件所在路径(位于 imagemagick 安装路径中),只有使用 imagemagick 才需要配置该项,使用 GD 留空即可
$config['thumb']['impath'] = '';

# 如果缓存类型设置为 memcache 或 redis,还需要配置下面的 memcache 或 redis 相关参数才会生效
$config['cache']['type'] 			    = 'file';
//$config['redis']['prefix']      	    = 'nc_';
//$config['redis']['master']['port']     	= 6379;
//$config['redis']['master']['host']     	= '127.0.0.1';
//$config['redis']['master']['pconnect'] 	= 0;
//$config['redis']['slave']      	        = array();

# 全文检索配置,支持 true(开启) 或 false(关闭),全文检索的详细配置,请参考本帮助的全文检索章节
# 需编辑 data\api\xs\app\shopnc.ini,将 server.index 和 server.search 值修改成自己的 IP 和端口
//$config['fullindexer']['open']      = false;
# 全文检索配置文件名(默认为 shopnc,不需要更改)
//$config['fullindexer']['appname']   = '33hao';

# 是否开启调式模式,支持 true(开启) 或 false(关闭) 系统错误日志位于: data/log 目录
$config['debug'] 			= false;

# 平台自营店店铺 ID
$config['default_store_id'] = '1';

# 是否开启伪静态,支持 true(开启) 或 false(关闭)
$config['url_model'] = true;

//如果店铺开启二级域名绑定的，这里填写主域名如shopnc.net
$config['subdomain_suffix'] = 'chahuitong.com';

//$config['session_type'] = 'redis';
//$config['session_save_path'] = 'tcp://127.0.0.1:6379';
$config['node_chat'] = true;
//流量记录表数量，为1~10之间的数字，默认为3，数字设置完成后请不要轻易修改，否则可能造成流量统计功能数据错误
$config['flowstat_tablenum'] = 3;
$config['sms']['gwUrl'] = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService';
$config['sms']['serialNumber'] = '';
$config['sms']['password'] = '';
$config['sms']['sessionKey'] = '';
$config['queue']['open'] = false;
$config['queue']['host'] = '127.0.0.1';
$config['queue']['port'] = 6379;
$config['cache_open'] = false;
$config['delivery_site_url']    = 'http://www.chahuitong.com/delivery';
return $config;
