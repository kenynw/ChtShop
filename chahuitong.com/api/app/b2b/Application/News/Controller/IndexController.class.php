<?php
namespace News\Controller;
use Think\Controller;

/**
 * 移动端山头首页控制器
 * @autho: Leslie Deng 
 */
class IndexController extends Controller {
	/*
	  *此方法用于跳转到移动端山头首页(暂时这种方式跳转)
	*/
	
	/*判断是否是客户端*/
	
	
	public function index(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'android_client') ){
			
			$info=1;
			
			}else{
				
			$info=0;	
				}	
		$this->assign('headinfo',$info);
		$this->display();
	}
	public function wulong(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'android_client') ){
			
			$info=1;
			
			}else{
				
			$info=0;	
				}	
		$this->assign('headinfo',$info);
		$this->display();
	}
	public function hong(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'android_client') ){
			
			$info=1;
			
			}else{
				
			$info=0;	
				}	
		$this->assign('headinfo',$info);
		$this->display();
	}
	public function lv(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'android_client') ){
			
			$info=1;
			
			}else{
				
			$info=0;	
				}	
		$this->assign('headinfo',$info);
		$this->display();
	}
	public function hei(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'android_client') ){
			
			$info=1;
			
			}else{
				
			$info=0;	
				}	
		$this->assign('headinfo',$info);
		$this->display();
	}
	public function huang(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'android_client') ){
			
			$info=1;
			
			}else{
				
			$info=0;	
				}	
		$this->assign('headinfo',$info);
		$this->display();
	}
	public function bai(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'android_client') ){
			
			$info=1;
			
			}else{
				
			$info=0;	
				}	
		$this->assign('headinfo',$info);
		$this->display();
	}
	
	/*
	 *用于测试
	*/
	public function map(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'android_client') ){
			
			$info=1;
			
			}else{
				
			$info=0;	
				}	
		$this->assign('headinfo',$info);
		$this->display();
	}
	
	/*
	 *此方法用于跳转到移动端山头详情页
	 *注：如果在山头中无法找到指定id的文章，则去资讯类目中查找
	*/
	public function detail(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'android_client') ){
			
			$info=1;
			
			}else{
				
			$info=0;	
				}	
		$this->assign('headinfo',$info);
		$aid=$_GET["aid"];
		if($aid==null||$aid==""){
			$this->error("参数有误，无法访问");
		}
		$hill=M("hill_img");
		$data=$hill->where("aid='$aid'")->field("cyte,body,zuobiao,pics,mobile_img")->find();
		if($data!=null){
			$archives=M("archives");
			$title=$archives->where("id=$aid")->field("title")->find();
			$about=$archives->query("select id,title from archives where title like '%$title[title]%' limit 0,10");
			$this->assign("data",$data);
			$this->assign("about",$about);
			$this->assign("host","http://www.damenghai.com");
			$this->display();
		}else {
			$archives=M("archives");
			$data=$archives->query("select a.id,from_unixtime(a.pubdate,'%Y-%m-%d') as pubdate,a.goodpost,a.title,a.writer,ad.body from archives a left join addonarticle ad on a.id=ad.aid where id=$aid");
			if($data!=null){
				$this->assign("data",$data);
				$this->display("News/detail");
			}else{
				$this->error("文章找不到了，去找找程序员~");
			}
		}
	}
	
	/*
	 * 此方法用于四个印象，跳转到相应的印象首页，加载此栏目下的文章
	 */
	public function yinxiang(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'android_client') ){
			
			$info=1;
			
			}else{
				
			$info=0;	
				}	
		$this->assign('headinfo',$info);
		$typeid=intval($_GET["typeid"]);
		$archives=M("archives");
		$about=$archives->query("select id,title,from_unixtime(pubdate,'%Y-%m-%d') as pubdate from archives where typeid='$typeid' limit 0,20");
		$this->assign("typeid",$typeid);
		$this->assign("about",$about);
		$this->display();
	}
	
	
	/*山头新首页*/
	
	public function home(){
				
		$this->display();
		
		}
	
	
	
	
}