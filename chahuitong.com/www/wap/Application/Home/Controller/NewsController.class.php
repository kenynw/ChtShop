<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 移动资讯端首页控制器
 * @autho: Leslie Deng 
 */
class NewsController extends Controller { 
	/*
	  *此方法用于跳转到移动端资讯首页，并显示最新的文章
	*/
	public function index(){
		
		$this->display();
	}
	
	/*
	 *详细页面
	 */
	
	
	public function detail(){
		
		$id=isset($_GET['article_id'])? intval($_GET['article_id']):1;
		//echo $id;
		$article=M("cms_article");
		
		$data=$article->where("article_id='$id'")->find();
		
		//print_r($data);
		
		$this->assign('data',$data);
		
		$this->display();
				
		
		}
		
	 /*新闻栏目api 接口*/	
	
	  public function newsApi(){
		  
		  $id=isset($_POST['id'])?intval($_POST['id']):80;
		  
		  $ableid=array(80,89,90,91,92);
		  
		  if(!in_array($id,$ableid)) echo json_encode(array('code'=>404,'content'=>'id输入不合法'));
		  
		  $article=M("cms_article");
		  
		  $array=array();
		  
		  $content=$article->field("article_id,article_image,article_publish_time,article_abstract,article_title")->where("article_class_id='$id'")->order("article_sort desc,article_publish_time desc")->limit(0,5)->select();
		  
		  if($content){
			  
			  $contents=array();
			  
			  foreach($content as $each){
				  
				  $each['article_image']=unserialize($each['article_image']);
				  
				  $each['article_publish_time']=str_replace('-','th.',date("d-M",$each['article_publish_time']));
				  
				  $contents[]=$each;
				  
				  }
			  
			  $array['content']=$contents;
			  
			  $array['code']=200;
			  
			  
			  }else{
				  
			  $array['content']='查询失败';
			  
			  $array['code']=404;	  
				 			  
				  
				  }
				  
			echo json_encode($array); 	  
		  	  
		  }
		  
	/*下滑显示更多api*/
	
	public function showMoreApi(){
		
		
		$id=isset($_POST['id'])?intval($_POST['id']):89;
		
		$page=isset($_POST['page'])?intval($_POST['page']):1;
		
		$article=M("cms_article");
		
		$content=$article->field("article_id,article_image,article_publish_time,article_abstract,article_title")->where("article_class_id='$id'")->order("article_sort desc,article_publish_time desc")->limit($page*5,5)->select();
		
		$array=array();
		
		if($content){
			
			 $contents=array();
			  
			  foreach($content as $each){
				  
				  $each['article_image']=unserialize($each['article_image']);
				  
				  $each['article_publish_time']=str_replace('-','th.',date("d-M",$each['article_publish_time']));
				  
				  $contents[]=$each;
				  
				  }
			  
			  $array['content']=$contents;
			  
			  $array['code']=200;
	
			}else{
				
		
		   $array['code']=404;
		   
		   $array['content']='已经没有内容了';		
				
				
				
				}
		
		 echo json_encode($array);
		 
		 unset($array);				
		
	}
	
	/*新闻详细*/
	
	public function newsDetailApi(){
		
		$article_id=isset($_POST['article_id'])?intval($_POST['article_id']):1;
		
		$article=M("cms_article");
		
		$content=$article->where("article_id='$article_id'")->find();
		
		$array=array();
		
		if($content){
			
			$array['code']=200;
			
			$array['content']=$content;		
			
			}else{
				
			$array['code']=404;
			
			$array['content']='暂无数据';		
				
				
				}
	
	      echo json_encode($array);
		
		}	
	
	
	
	
	
	
}