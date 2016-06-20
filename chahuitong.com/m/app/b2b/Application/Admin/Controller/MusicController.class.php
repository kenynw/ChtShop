<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * 音乐控制器
 * @autho: Leslie Deng
 */
class MusicController extends Controller {
	
	
	/* 编辑音乐信息 */
	public function update_f() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$music=M("music");
				$id=$_SESSION["com_id"];
				$data=$music->where("com_id=$id")->find();
				$this->assign("data",$data);
				$this->display();
			}
		}else {
			$this->redirect("Index/index");
		}
	}
	
	/* 编辑音乐信息-入库 */
public function update_db() {
		$isLogin = isLogin ();
		if ($isLogin == 1) {
			$admin_id=isRight($_SESSION["admin_id"]);
			if($admin_id==3){
				$this->error("你没有权限执行此操作");
			}else {
				$music=M("music");
					import("ORG.Net.UploadFile");
					$upload = new \UploadFile();// 实例化上传类
					$upload->maxSize=6048576;//文件大小
					$upload->uploadReplace=TRUE;
					$upload->allowExts=array("mp3","png","jpg");//設置上傳文件的格式
					//將文件保存在指定文件夾中
					$upload->savePath=C("savePath");
					
					$upload->saveRule=$_POST["id"]."music1";
					$img=$upload->uploadOne($_FILES["music1"]);
					if(strlen($img[0]["savename"])>0){
						$top_img=$img[0]["savename"];
						$data["music1"]=$top_img;
					}
					$img=null;
					$upload->saveRule=$_POST["id"]."music2";
					$img=$upload->uploadOne($_FILES["music2"]);
					if(strlen($img[0]["savename"])>0){
						$top_img=$img[0]["savename"];
						$data["music2"]=$top_img;
					}
					$img=null;
					$upload->saveRule=$_POST["id"]."music3";
					$img=$upload->uploadOne($_FILES["music3"]);
					if(strlen($img[0]["savename"])>0){
						$top_img=$img[0]["savename"];
						$data["music3"]=$top_img;

					}
					$img=null;
					$upload->saveRule=$_POST["id"]."music4";
					$img=$upload->uploadOne($_FILES["music4"]);
					if(strlen($img[0]["savename"])>0){
						$top_img=$img[0]["savename"];
						$data["music4"]=$top_img;
					}
					$img=null;
					$upload->saveRule=$_POST["id"]."music5";
					$img=$upload->uploadOne($_FILES["music5"]);
					if(strlen($img[0]["savename"])>0){
						$top_img=$img[0]["savename"];
						$data["music5"]=$top_img;
					}
					//echo  $data["music1"]."--".$data["music2"]."--".$data["music3"]."--".$data["music4"]."--".$data["music5"];
					$data["id"]=$_POST["id"];
					$data["selected"]=$_POST["selected"];
					$res=$music->save($data);
					if($res){
						$this->success("操作成功");
					}else{
						$this->success("操作正常");
					}
			}
		}else {
			$this->redirect("Index/index");
		}
	}
}