<?php

namespace Admin\Controller;

use Think\Controller;
/**
 * 公共控制器
 * @autho: Leslie Deng
 */
class PublicController extends Controller {
	/**
	 * 系统首页
	 * @author Leslie Deng
	 */
	public function index() {
		$
		$isLogin=isLogin();
		if($isLogin==1){
			$this->redirect("Admin/index");
		}else{
		$this->display();
		}
	}
	
	/**
	 * 管理员登录
	 */
	public function login(){
		if(!$_POST){
			$this->error("非法操作");
		}
		$name=$_POST['name'];
		$password=$_POST['password'];
		$admin=M("admin");
		$condition["login_name"]=$name;
		$condition["password"]=$password;
		$condition["admin_status"]=1;
		$result=$admin->where($condition)->find();
		if(count($result)>0){
			$_SESSION["admin"]=$result["login_name"];
			$_SESSION["admin_id"]=$result["id"];
			$_SESSION["admin_status"]=$result["admin_status"];
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	
	/**
	 * 管理员退出
	 */
	public function out(){
		unset($_SESSION["admin"]);
		unset($_SESSION["admin_id"]);
		unset($_SESSION["admin_status"]);
		$this->redirect("Index/index");
	}
	
	/**
	 * 进入管理员后台
	 */
	public function home(){
		//进入后台时，判断是否登录
		$isLogin=isLogin();
		if($isLogin==0){
			$this->redirect("Index/index");
		}else{
			$admin=M("admin");
			$data=$admin->select();
			$this->assign("data",$data);
			$this->display();
		}
	}
}