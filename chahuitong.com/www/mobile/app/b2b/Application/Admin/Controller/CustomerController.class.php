<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * 客户控制器
 * @autho: Leslie Deng
 */
class CustomerController extends Controller {
	/**
	 * 客户首页
	 * 
	 * @author Leslie Deng
	 */
	public function index() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$customer = M ( "customer" );
			$com_id=$_SESSION["com_id"];
			$data = $customer->where("com_id=$com_id")->select ();
			$this->assign ( "data", $data );
			$this->display ( "Customer/index" );
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/**
	 * 删除指定客户，并删除流程
	 */
	public function delete() {
		$id=$_GET["id"];
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$customer=M("customer");
				if($customer->where("id=$id")->delete()){
					$this->success("删除成功");
					$process=M("process");
					$process->where("customer_id=$id")->delete();
					$first=M("first");
					$first->where("customer_id=$id")->delete();
				}else{
					$this->error("删除失败");
				}
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 编辑指定客户的流程信息 */
	public function update_d() {
		$id=$_GET["id"];
		$com_id=$_SESSION["com_id"];
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$process=M("process");
				$actor=M("actor");
				$data=$process->query("SELECT p.*,a.name as actor,a.user_type as utype,a1.name as actor1,a1.user_type as utype1,c.name as company,c.logo as logo
						from process p left join actor a on p.actor_id=a.id 
						left join actor a1 on p.actor_id1=a1.id
						left join company c on p.com_id=c.id where p.com_id=$com_id and p.customer_id=$id ORDER BY step");
				$data1=$actor->where("com_id=$com_id")->select();
				$this->assign("data",$data);
				$this->assign("data1",$data1);
				$this->display();
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 修改客户信息-跳转 */
	public function update_customer() {
		$id=$_GET["id"];
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$customer=M("customer");
				$data=$customer->where("id=$id")->find();
				$this->assign("data",$data);
				$this->display();
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 编辑客户信息--入库 */
	public function update_c_db() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$customer=D("customer");
				if($customer->create()){
					$res=$customer->save();
					if($res){
						$this->success("操作成功","./index");
					}else{
						$this->error("操作异常，或未更改资料");
					}
				}else{
					$this->error($customer->getError());
				}
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 添加客户信息 */
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
	
	/* 添加客户信息 */
	public function save_db() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$Customer=D("Customer");
				if($Customer->create()){
					$res=$Customer->add();
					if($res){
						$this->success("操作成功","./index");
						$process=D("Process");
						//当添加客户时，自动添加5个流程，但内容为空
						for($i=1;$i<6;$i++){
							$data["com_id"]=$_SESSION["com_id"];
							$data["customer_id"]=$res;
							$data["actor_id"]=0;
							$data["actor_id1"]=0;
							$data["address"]="";
							$data["content"]="";
							$data["process_date"]="";
							$data["step"]=$i;
							$process->add($data);
						}
						//当添加客户时，自动添加先睹为快，但内容为空
						$first=M("first");
						$data1["com_id"]=$_SESSION["com_id"];
						$data1["customer_id"]=$res;
						$data1["customer_id"]=$res;
						$first->add($data1);
					}else{
						$this->error("操作失败");
					}
				}else{
					$this->error($Customer->getError());
				}
			}
		}else {
			$this->redirect("Index/index");
		}
	}
}