<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * 管理员控制器
 * @autho: Leslie Deng
 */
class AdminController extends Controller {
	/**
	 * 系统首页
	 * 
	 * @author Leslie Deng
	 */
	public function index() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$id=$_SESSION["com_id"];
			$admin = M ( "admin" );
			$data = $admin->where("com_id=$id")->select();
			$this->assign ( "data", $data );
			$this->display ( "Index/home" );
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/**
	 * 删除管理员
	 */
	public function delete() {
		$id=$_GET["admin_id"];
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$admin=M("admin");
				$data=$admin->where("id=$id")->find();
				if($data["admin_type"]!=1){
					if($admin->where("id=$id")->delete()){
						$this->success("删除成功");
					}else{
						$this->error("删除失败");
					}
				}else {
					$this->error("不能删除超级管理员");
				}
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 编辑管理员信息 */
	public function update_d() {
		$id=$_GET["admin_id"];
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$admin=M("admin");
				$data=$admin->where("id=$id")->find();
				$this->assign("data",$data);
				$this->display();
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 编辑管理员信息 */
	public function update_db() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$Admin=D("Admin");
				if($Admin->create($_POST,2)){
					$res=$Admin->save();
					if($res){
						$this->success("操作成功","./index");
					}else{
						$this->error($Admin->getError());
					}
				}else{
					$this->error($Admin->getError());
				}
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 添加管理员信息 */
	public function add_d() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$compnay=M("company");
				$data=$compnay->select();
				$this->assign("data",$data);
				$this->display();
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 添加管理员信息 */
	public function add_db() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$Admin=D("Admin");
				if($Admin->create($_POST,1)){
					if($Admin->add()){
						$this->success("操作成功","./index");
					}else{
						$this->error("操作失败");
					}
				}else{
					$this->error($Admin->getError());
				}
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/*
	 * 获取登录的管理员信息
	 */
	public function getAdmin(){
		$id=$_SESSION["admin_id"];
		$admin=M("admin");
		$vo=$admin->where("id=$id")->find();
		$this->ajaxReturn($vo);
	}
}