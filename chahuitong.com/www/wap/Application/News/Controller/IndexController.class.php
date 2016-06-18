<?php
namespace News\Controller;
use Think\Controller;

/**
 * 移动端资讯首页控制器
 * @autho: Leslie Deng 
 */
class IndexController extends Controller {
	/*
	  *此方法用于跳转到移动端资讯首页
	*/
	public function index(){
		$this->display();
	}
	
		
		/*
		 * 个人的发布产品
		 */
	public function myList(){
		  $mypost=M('ecs_post');
		   $info=$mypost->limit(2)->order("id desc")->select();
		   $this->assign("data",$info);
		   $this->display();
		}	
		
	 /*
	  * 产品详情页
	 */
	 public function info(){
		
		 $id=isset($_GET['id'])? $_GET['id']:1;
		 
		 $post_content=M('ecs_post_content');
		 
		 $detail=$post_content->where("pid=".$id)->find();
		 
		 if($detail['depic']!=''){
			 
			  $array=explode(',',$detail['depic']);
			  print_r($array);
			  
			  if(isset($array[0])&&($array[0]!='')){
				  
				  $detail['img'][]=$array[0];
				  }
			  if(isset($array[1])&&($array[1]!='')){
				  
				  $detail['img'][]=$array[1];
				  }	 
			  if(isset($array[2])&&($array[2]!='')){
				  
				  $detail['img'][]=$array[3];
				  }		   		  
			 }
		$this->display();
		}	
		
}
