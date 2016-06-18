<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * 影楼（商户）控制器
 * @autho: Leslie Deng
 */
class CompanyController extends Controller {
	/**
	 * 影楼（商户）首页
	 * 
	 * @author Leslie Deng
	 */
	public function index() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$com_id=$_SESSION["com_id"];
			$company = M ( "company" );
			$data = $company->where("id=$com_id")->find();
			$this->assign ( "data", $data );
			$this->display ( "Company/index" );
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 修改影楼（商户）信息 */
	public function update_db() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$Company=D("Company");
				$id=$_POST['id'];
				import("ORG.Net.UploadFile");
				$upload = new \UploadFile();// 实例化上传类
				$upload->maxSize=1048576;//文件大小
				$upload->saveRule=$id;//规范上传影楼logo的名字
				$upload->uploadReplace=TRUE;
				$upload->allowExts=array("gif","png","jpg");//設置上傳文件的格式
				//將文件保存在指定文件夾中
				$upload->savePath=C("savePath");
				$infos=$_POST["logo1"];
				if($upload->upload()){
					$info=$upload->getUploadFileInfo();
						$infos="";
						for($i=0;$i<count($info);$i++){
							$infos=$info[$i]["savename"];
						}
				}
				$data["id"]=$id;
				$data["name"]=$_POST["name"];
				$data["logo"]=$infos;
				$data["homepage"]=$_POST['homepage'];
				$data["custom_service"]=$_POST['custom_service'];
				$data["manager"]=$_POST['manager'];
				if($Company->save($data)){
					$this->success("修改成功"."<br>"."Logo信息：".$upload->getErrorMsg());
				}else{
					$this->error("完成操作","./index");
				}
			}
		}else {
			$this->redirect("Index/index");
		}
	}
}