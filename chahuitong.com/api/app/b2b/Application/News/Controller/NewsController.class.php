<?php
namespace News\Controller;
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
		/*app判断*/
		
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'android_client') ){
			
			$info=1;
			
			}else{
				
			$info=0;	
				}	
		$this->assign('headinfo',$info);
		
		
		/*end*/
		$typeid=$_GET["typeid"];
		$archives=M("archives");
		if(empty($typeid)){
			$sql="select a.id,a.litpic,from_unixtime(a.pubdate,'%Y-%m-%d') as pubdate,left(a.description,30) as description,a.typeid,a.title,a.writer,t.typename from archives a left join arctype t on a.typeid=t.id where arcrank=0 and typeid in (88,89,90,91,92) order by a.pubdate desc limit 0,5";
		}else{
			$typeid=intval($typeid);
			if($typeid>=88&&$typeid<=92){
				$sql="select a.id,a.litpic,from_unixtime(a.pubdate,'%Y-%m-%d') as pubdate,left(a.description,30) as description,a.typeid,a.title,a.writer,t.typename from archives a left join arctype t on a.typeid=t.id where arcrank=0 and typeid=$typeid  order by a.pubdate desc limit 0,5";
			}else{
				$this->error("参数有误~");
			}
		}
		$data=$archives->query($sql);
		$this->assign("host","http://www.damenghai.com/");
		$this->assign("data",$data);
		$this->display();
	}
	
	/*
	 * 此方法用于获取各栏目的文章，页面顶部点击时通过此方法
	 */
	public function getColumnArticles(){
		$typeid=$_POST["typeid"];
		$page=$_POST["page"];
		if(empty($page)){
			$page=0;
		}
		$archives=M("archives");
		if(empty($typeid)){
			$sql="select a.id,a.litpic,from_unixtime(a.pubdate,'%Y-%m-%d') as pubdate,left(a.description,30) as description,a.typeid,a.title,a.writer,t.typename from archives a left join arctype t on a.typeid=t.id where arcrank=0 and typeid in (88,89,90,91,92) order by a.pubdate desc limit $page,5";
		}else{
			$typeid=intval($typeid);
			if($typeid>=88&&$typeid<=92){
				$sql="select a.id,a.litpic,from_unixtime(a.pubdate,'%Y-%m-%d') as pubdate,left(a.description,30) as description,a.typeid,a.title,a.writer,t.typename from archives a left join arctype t on a.typeid=t.id where arcrank=0 and typeid=$typeid  order by a.pubdate desc limit $page,5";
			}else{
				$this->error("参数无效~");
			}
		}
		$data=$archives->query($sql);
		$this->assign("host","http://www.damenghai.com/");
		$this->assign("data",$data);
		$this->display("News/json");
	}
}