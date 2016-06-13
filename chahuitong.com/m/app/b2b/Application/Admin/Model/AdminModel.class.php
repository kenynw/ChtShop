<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model {
	protected  $_validate = array(
		array('login_name', '', '此用户名已被系统注册', 0, 'unique', 1), 
	);
	
	protected $_auto = array(
		array('com_id','getComId',1,'callback'),
	);
	
	function getComId(){
		return $_SESSION["com_id"];
	}
}
?>