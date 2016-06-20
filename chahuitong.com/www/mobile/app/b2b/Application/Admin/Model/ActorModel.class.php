<?php
namespace Admin\Model;
use Think\Model;
class ActorModel extends Model {
	protected  $_validate = array(
		//array('name', 'confirmName','此姓名已存在', 3, "callback"), 
	);
	protected $_auto = array(
			array("com_id","getComId",1,"callback"),
	);
	
	function getComId(){
		return $_SESSION["com_id"];
	}
	
	function confirmName($name){
		$actor=M("actor");
		$condition["id"]=$_SESSION["admin_id"];
		$condition["name"]=$name;
		$actor->where($condition)->find();
		if(count($actor)>1){
			return true;
		}else{
			return false;
		}
	}
}
?>