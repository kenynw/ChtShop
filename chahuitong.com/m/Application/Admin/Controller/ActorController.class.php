<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * 店员角色控制器
 * @autho: Leslie Deng
 */
class ActorController extends Controller {
	/**
	 * 店员角色首页
	 * 
	 * @author Leslie Deng
	 */
	public function index() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$actor = M ( "actor" );
			$com_id=$_SESSION["com_id"];
			$data = $actor->where("com_id=$com_id")->select ();
			$this->assign ( "data", $data );
			$this->display ( "Actor/index" );
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/**
	 * 删除店员角色
	 */
	public function delete() {
		$id=$_GET["id"];
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$actor=M("actor");
				if($actor->where("id=$id")->delete()){
					$this->success("删除成功");
				}else{
					$this->error("删除失败");
				}
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 编辑管理员信息 */
	public function update_d() {
		$id=$_GET["id"];
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$actor=M("actor");
				$data=$actor->where("id=$id")->find();
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
				$Actor=D("Actor");
				if($Actor->create()){
					$res=$Actor->save();
					if($res){
						$this->success("操作成功","./index");
					}else{
						$this->error("操作异常，或未更改资料");
					}
				}else{
					$this->error($Actor->getError());
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
				$this->display();
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 添加管理员信息 */
	public function save_db() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$Actor=D("Actor");
				if($Actor->create()){
					if($Actor->add()){
						$this->success("操作成功","./index");
					}else{
						$this->error("操作失败");
					}
				}else{
					$this->error($Actor->getError());
				}
			}
		}else {
			$this->redirect("Index/index");
		}
	}
}