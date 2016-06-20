<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * 先睹为快控制器
 * @autho: Leslie Deng
 */
class FirstController extends Controller {
	
	
	/* 编辑先睹为快信息 */
	public function update_f() {
		$id=$_GET["id"];
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$first=M("first");
				$data=$first->where("customer_id=$id")->find();
				$this->assign("data",$data);
				$this->display();
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 编辑先睹为快-入库 */
	public function update_db() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$First=M("first");
				if($First->create()){
					import("ORG.Net.UploadFile");
					$upload = new \UploadFile();// 实例化上传类
					$upload->maxSize=1048576;//文件大小
					$upload->uploadReplace=TRUE;
					$upload->allowExts=array("gif","png","jpg");//設置上傳文件的格式
					//將文件保存在指定文件夾中
					$upload->savePath=C("savePath");
					
					$upload->saveRule="img".$_POST["id"]."top_img";
					$img=$upload->uploadOne($_FILES["top_img"]);
					if(strlen($img[0]["savename"])>0){
						$top_img=$img[0]["savename"];
						$data["top_img"]=$top_img;
					}
					$img=null;
					$upload->saveRule="img".$_POST["id"]."bottom_img";
					$img=$upload->uploadOne($_FILES["bottom_img"]);
					if(strlen($img[0]["savename"])>0){
						$bottom_img=$img[0]["savename"];
						$data["bottom_img"]=$bottom_img;
					}
					$img=null;
					$upload->saveRule="img".$_POST["id"]."img1";
					$img=$upload->uploadOne($_FILES["img1"]);
					if(strlen($img[0]["savename"])>0){
						$bottom_img=$img[0]["savename"];
						$data["img1"]=$bottom_img;
					}
					$img=null;
					$upload->saveRule="img".$_POST["id"]."img2";
					$img=$upload->uploadOne($_FILES["img2"]);
					if(strlen($img[0]["savename"])>0){
						$bottom_img=$img[0]["savename"];
						$data["img2"]=$bottom_img;
					}
					$img=null;
					$upload->saveRule="img".$_POST["id"]."img3";
					$img=$upload->uploadOne($_FILES["img3"]);
					if(strlen($img[0]["savename"])>0){
						$bottom_img=$img[0]["savename"];
						$data["img3"]=$bottom_img;
					}
					$img=null;
					$upload->saveRule="img".$_POST["id"]."img4";
					$img=$upload->uploadOne($_FILES["img4"]);
					if(strlen($img[0]["savename"])>0){
						$bottom_img=$img[0]["savename"];
						$data["img4"]=$bottom_img;
					}
					$img=null;
					$upload->saveRule="img".$_POST["id"]."img5";
					$img=$upload->uploadOne($_FILES["img5"]);
					if(strlen($img[0]["savename"])>0){
						$bottom_img=$img[0]["savename"];
						$data["img5"]=$bottom_img;
					}
					$img=null;
					$upload->saveRule="img".$_POST["id"]."img6";
					$img=$upload->uploadOne($_FILES["img6"]);
					if(strlen($img[0]["savename"])>0){
						$bottom_img=$img[0]["savename"];
						$data["img6"]=$bottom_img;
					}
					$img=null;
					$upload->saveRule="img".$_POST["id"]."img7";
					$img=$upload->uploadOne($_FILES["img7"]);
					if(strlen($img[0]["savename"])>0){
						$bottom_img=$img[0]["savename"];
						$data["img7"]=$bottom_img;
					}
					$img=null;
					$upload->saveRule="img".$_POST["id"]."img8";
					$img=$upload->uploadOne($_FILES["img8"]);
					if(strlen($img[0]["savename"])>0){
						$bottom_img=$img[0]["savename"];
						$data["img8"]=$bottom_img;
					}
					$img=null;
					$upload->saveRule="img".$_POST["id"]."img9";
					$img=$upload->uploadOne($_FILES["img9"]);
					if(strlen($img[0]["savename"])>0){
						$bottom_img=$img[0]["savename"];
						$data["img9"]=$bottom_img;
					}
					$img=null;
					$upload->saveRule="img".$_POST["id"]."img10";
					$img=$upload->uploadOne($_FILES["img10"]);
					if(strlen($img[0]["savename"])>0){
						$bottom_img=$img[0]["savename"];
						$data["img10"]=$bottom_img;
					}
					$data["id"]=$_POST["id"];
					$data["words"]=$_POST["words"];
					$res=$First->save($data);
					if($res){
						$this->success("操作成功");
					}else{
						$this->success("操作正常");
					}
				}else{
					$this->error($First->getError());
				}
			}
		}else {
			$this->redirect("Index/index");
		}
	}
}