<?php
namespace Admin\Model;
use Think\Model;
class CompanyModel extends Model {
	protected  $_validate = array(
		array('name','require','必须填写名字'), //默认情况下用正则进行验证
	);
	protected $_auto = array(
			
	);
}
?>