<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * 客户流程控制器
 * @autho: Leslie Deng
 */
class ProcessController extends Controller {
	/**
	 * 客户流程首页
	 * 
	 * @author Leslie Deng
	 */
	public function index() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$process = M ( "process" );
			$com_id=$_SESSION["com_id"];
			$sql="SELECT p.id,p.step,p.address,p.process_date,p.content,a.name,a1.name
						FROM process p LEFT JOIN actor a ON p.actor_id=a.id 
						LEFT join actor a1 on p.actor_id1=a1.id
						left join company c on p.com_id=c.id where step=1 and com_id=$com_id";
			$data = $process->query($sql);
			$this->assign ( "data", $data );
			$this->display ( "Process/index" );
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 编辑角色信息 */
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
	
	/* 编辑流程信息 */
	public function update_db() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$Process=D("Process");
				if($Process->create()){
					$res=$Process->save();
					if($res){
						$this->success("操作成功");
					}else{
						$this->error("操作异常，或未更改资料");
					}
				}else{
					$this->error($Process->getError());
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