<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 首页控制器
 * @autho: Leslie Deng 
 */
class IndexController extends Controller {
	
	public $session=array();
	
	/*客户登陆页面*/
	public function login(){
		
		$this->display();
		
		}	
	/*客户登陆验证*/	
	public function checklogin(){
		
		 /*if(($_POST['username']=='')||($_POST['password']=='')){
			 
			 	 $this->Error('用户名或密码不能为空',"/mobile/user.php"); 
			 }
		 
		 $data['user_name']=trim($_POST['username']);
		 $data['password']=md5(trim($_POST['password']));
		 $user=M("ecs_users");
		 $result=$user->where($data)->find();
		 if($result){			 
			  if($result['checkid']==0){
					  checkChashi()   = $result['user_id'];
                      $_SESSION['user_name'] = $result['user_name'];
                      $_SESSION['email']     = $result['email'];
					 // print_r($result);
				  
				    $this->Error("您暂时未申请加入茶市场,请先加入茶市",__APP__."/Home/index/joinin"); 
				  }else{	
				      // print_r($result);				  
					  $_SESSION['user_chashi']=$result['user_id'];
					  checkChashi()   = $result['user_id'];
                      $_SESSION['user_name'] = $result['user_name'];
                      $_SESSION['email']     = $result['email'];	
					 // print_r($_SESSION);				  
					  $this->success("您已经登陆到茶市，请稍等",__APP__."/Home/index/index");
					  }			 
			 }else{				 
			          $this->Error("用户名或者密码错误","/mobile/user.php");
				 	 }*/
		  			 
					 
		   $sessid=substr($_COOKIE['ECS_ID'],0,32);	

		   $sess=M('ecs_sessions');	
		   
		   $data=$sess->where("sesskey='".$sessid."'")->find();	
		   
	       if($data&&($data['userid']!=0)){
			   
			   $session=unserialize($data['data']);
			   $session['user_id']=$data['userid'];
			   $user=M('ecs_users');
			   $info=$user->where("user_id='".$session['user_id']."'")->find();
			   if($info['checkid']==1){		
			   
			        $_SESSION['user_chashi']=$session['user_id'];
							   
				    $this->success("您已经登陆到茶市，请稍等",__APP__."/Home/index/index");
				   }else{
					   
					 $this->Error("请您先申请加入查市","/mobile/user.php?act=join");   
					   
					   }
			   			   
	   			   }else{
					   
					$this->Error("请您先登陆","/mobile/user.php");   
					   
					   
					   }
					 
		}
		
	/*信息提交页面*/
	public function post(){
		if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}		
		$this->display();
		
		}	
		
	/*已登陆客户申请加入茶室*/
	public function joinin(){
		
		 $this->display();
	
		}		
	/*
	  *此方法用于跳转到客户端首页
	*/
	public function index(){
			if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}	
		$post=M("ecs_post");
		/*分页*/
		 $count=$post->count();
		 $Page= new \Think\Page($count,10);
		 $show= $Page->show();
		
		if(isset($_GET['order'])&&($_GET['order']==1)){
		$all=$post->order("recommend desc,id desc")->limit($Page->firstRow.','.$Page->listRows)->select();
		      }else{
			$all=$post->order("id asc")->limit($Page->firstRow.','.$Page->listRows)->select();	  
				  }
		//$sale=$post->order("id desc")->limit(10)->where("saleway=1")->select();
		//$buy=$post->order("id desc")->limit(10)->where("saleway=2")->select();
		$this->assign('page',$show);// 赋值分页输出
		$this->assign("all",$all);
		//$this->assign("sale",$sale);
		//$this->assign("buy",$buy);
		
		$this->display();
	}
	
	public function sale(){
			if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}	
		$post=M("ecs_post");
		/*分页*/
		 $count=$post->count();
		 $Page= new \Think\Page($count,10);
		 $show= $Page->show();
		if(isset($_GET['order'])&&($_GET['order']==1)){
		$sale=$post->order("id desc")->limit($Page->firstRow.','.$Page->listRows)->where("saleway=1")->select();
		      }else{
			$sale=$post->order("id asc")->limit($Page->firstRow.','.$Page->listRows)->where("saleway=1")->select();	  
				  }
		//$sale=$post->order("id desc")->limit(10)->where("saleway=1")->select();
		//$buy=$post->order("id desc")->limit(10)->where("saleway=2")->select();
		//$this->assign("all",$all);
		$this->assign('page',$show);
		$this->assign("all",$sale);
		//$this->assign("buy",$buy);
		
		$this->display();
	}
	
		public function buy(){
			if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}	
		$post=M("ecs_post");
		$count=$post->count();
		$Page= new \Think\Page($count,10);
		if(isset($_GET['order'])&&($_GET['order']==1)){
		$buy=$post->order("id desc")->limit($Page->firstRow.','.$Page->listRows)->where("saleway=2")->select();
		      }else{
			$buy=$post->order("id asc")->limit($Page->firstRow.','.$Page->listRows)->where("saleway=2")->select();	  
				  }
		//$sale=$post->order("id desc")->limit(10)->where("saleway=1")->select();
		//$buy=$post->order("id desc")->limit(10)->where("saleway=2")->select();
		//$this->assign("all",$all);
		$this->assign('page',$show);
		$this->assign("all",$buy);
		//$this->assign("buy",$buy);
		
		$this->display();
	}
	
	/*
	 * 信息入库
	 */
	public function post_save(){
		
		if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
		$post=M("ecs_post");
		if($_POST['name']==''){
			$this->Error('请输入品牌名',"post");
			
			}
			
		$result=$post->create();
		if($result){
			
			  $time=time();			  
			  $pic='';			  
			  $depic='';			
			  if(is_uploaded_file($_FILES['img1']['tmp_name'])){
				  
				  $name=$_FILES['img1']["name"];
				  $type=$_FILES['img1']["type"];//上传文件的类型 
                  $size=$_FILES['img1']["size"];//上传文件的大小
				  if($size>(2*1014*1024)){
					  $this->Error('请上传小于2M的图片',"index");					  
					  }
				  switch ($type){ 
                   case 'image/pjpeg':$okType=true; 
                     break; 
                   case 'image/jpeg':$okType=true; 
                     break; 
                   case 'image/gif':$okType=true; 
                    break; 
                   case 'image/png':$okType=true; 
                     break; 
                      } 
					if($okType){
					 $imgtype=substr($_FILES['img1']['name'],-3);
					 
					 $newname=$time."_1.".$imgtype;
					 $pic=$time."_1.".$imgtype;
					 $depic.=$time."_1.".$imgtype.',';
					 
					 move_uploaded_file($_FILES['img1']["tmp_name"],'./Public/upload/'.$newname);	
						
						}
				  }	
			  if(is_uploaded_file($_FILES['img2']['tmp_name'])){
				  
				  $name=$_FILES['img2']["name"];
				  $type=$_FILES['img2']["type"];//上传文件的类型 
                  $size=$_FILES['img2']["size"];//上传文件的大小
				  if($size>(2*1014*1024)){
					  $this->Error('请上传小于2M的图片',"index");					  
					  }
				  switch ($type){ 
                   case 'image/pjpeg':$okType=true; 
                     break; 
                   case 'image/jpeg':$okType=true; 
                     break; 
                   case 'image/gif':$okType=true; 
                    break; 
                   case 'image/png':$okType=true; 
                     break; 
                      } 
					if($okType){
					 $imgtype=substr($_FILES['img2']['name'],-3);
					 
					 $newname=$time."_2.".$imgtype;
					 $depic.=$time."_2.".$imgtype.',';
					 
					 move_uploaded_file($_FILES['img2']["tmp_name"],'./Public/upload/'.$newname);	
						
						}
				  }	
			   if(is_uploaded_file($_FILES['img3']['tmp_name'])){
				  
				  $name=$_FILES['img3']["name"];
				  $type=$_FILES['img3']["type"];//上传文件的类型 
                  $size=$_FILES['img3']["size"];//上传文件的大小
				  if($size>(2*1014*1024)){
					  $this->Error('请上传小于2M的图片',"index");					  
					  }
				  switch ($type){ 
                   case 'image/pjpeg':$okType=true; 
                     break; 
                   case 'image/jpeg':$okType=true; 
                     break; 
                   case 'image/gif':$okType=true; 
                    break; 
                   case 'image/png':$okType=true; 
                     break; 
                      } 
					if($okType){
					 $imgtype=substr($_FILES['img3']['name'],-3);
					 
					 $newname=$time."_3.".$imgtype;
					 $depic.=$time."_3.".$imgtype;
					 
					 move_uploaded_file($_FILES['img3']["tmp_name"],'./Public/upload/'.$newname);	
						
						}
				  }	
				$post->pic=$pic;				
				$post->user_id=checkChashi();
				$post->addtime=date("Y-m-d H:i");
				$id=$post->add();  				
				$content=M("ecs_post_content");				
				$data['pid']=$id;
				$data['content']=$_POST['content'];
				$data['depic']=$depic;			
				$cid=$content->add($data);	
				
				if($id&&$cid){
					$this->success('新增成功', 'Index/index');
					//$this->redirect("Index/index");
					}
			}else{
				
			exit($post->Error().'数据提交失败');	
				}
		}	
		
		/*
		 * 个人的发布产品
		 */
	public function myList(){
		   if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
		   $mypost=M('ecs_post');
		   $user_id=checkChashi();
		   $info=$mypost->where("user_id='".$user_id."'")->select();
		   //print_r($info);
		   $this->assign("data",$info);
		   $this->display();
		}	
		
	
		
		
		/*
		 * 产品详情页
		 */
		 
	public function info(){
	    	
		if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
		 $id=isset($_GET['id'])&&is_numeric($_GET['id'])? $_GET['id']:1;
		 
		 
		 $post_content=M('');
		 
		 $sql="select c.id,c.addtime,c.brand,c.name,c.year,c.address,c.price,c.weight,c.unit,c.timeout,c.phone,c.saleway,d.depic,d.content from `ecs_post` as c left join `ecs_post_content` as d on c.id=d.pid where c.id='$id'";
		 
		 $detail=$post_content->query($sql);
		 
		 $detail=$detail[0];
		 
		// print_r($detail);
		 
		 if($detail['depic']!=''){
			 
			  $array=explode(',',$detail['depic']);
			 // print_r($array);
			  
			  if(isset($array[0])&&($array[0]!='')){
				  
				  $detail['img'][]=$array[0];
				  }
			  if(isset($array[1])&&($array[1]!='')){
				  
				  $detail['img'][]=$array[1];
				  }	 
			  if(isset($array[2])&&($array[2]!='')){
				  
				  $detail['img'][]=$array[2];
				  }		   		  
			 }
		//print_r($detail);	 
			 
		$this->assign('detail',$detail);	 
		$this->display();
		}	
		
		/*联系买卖人员*/
		
		function contact(){			
			if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
			
			 $id=isset($_GET['id'])&&is_numeric($_GET['id'])? $_GET['id']:1;
			 
			 $post=M("ecs_post");
			 
			 $detail=$post->where("id=".$id)->find();
			 
			 $this->assign('detail',$detail);
			 
			 $this->assign('uid',checkChashi());
             
			 $this->display(); 
			    		
			}
		/*保存客户买卖交易留言*/
		public function newssave(){
			
			if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
			if($_POST['uid']==$_POST['cid']){
				
				$this->Error('抱歉这是您自己产品不需要留言',__APP__."/Home/index/index");
				
						
				}
			
			 $data['tile']=$_POST['title'];
			 
			 $data['content']=$_POST['content'];
			 
			 $data['uid']=$_POST['uid'];
			 
			 $data['cid']=checkChashi();
			 
			 $data['pid']=$_POST['pid'];
			 
			 $data['fid']=isset($_POST['fid'])&&is_numeric($_POST['fid'])? intval($_POST['fid']):0;
			 $data['addtime']=date("Y-m-d H:i:s");
			 
			 $news=M("ecs_post_news");
			 
			 $result=$news->add($data);
			 
			 if($result){
				
				$this->success('提交成功',__APP__.'/Home/index/index'); 
				 
				 }else{
					 
					 $this->error('提交失败',__APP__.'/Home/index/info/id/'.'/'.$_POST['pid']);
					 
					 }
		
			}	
			/*个人接受到的新信息*/
		
	 public function news(){
		   if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
		 
		 $uid=checkChashi();
		 
		 
		 
		 $news=M('');
		 
		 /*$sql="select cid,pid,sum(isRead) as readed,count(*) as total from ecs_post_news where uid ='".checkChashi()."' group by pid";*/
		 
		 $sql="select cid,uid,distinct pid from ecs_post_news where uid='".$uid."' or cid='".$uid."'";
		 
		 $newslist= $news->query($sql);
	 
		  //print_r($newslist);
		  
		  $this->assign('own',checkChashi());
		 
		  $this->assign('newslist',$newslist);
		  
		  $this->assign('httpinfo', $_SERVER['HTTP_USER_AGENT']);
	 
		  $this->display();		
		 
		 }	
		 
		/*查看某个产品的不同客户的留言*/ 
		
		 function newslist(){

			$cid=isset($_GET['cid'])&& is_numeric($_GET['cid'])? intval($_GET['cid']):1;
			$pid=isset($_GET['pid'])&& is_numeric($_GET['pid'])? intval($_GET['pid']):1;
			 
			$news=M("ecs_post_news");
			
			$newslist=$news->where("cid='$cid' and pid='$pid'")->order("id desc")->limit(10)->select();
			
			//print_r($newslist);
			 $this->assign('own',checkChashi());
			
			$this->assign('newslist',$newslist);
			
			$this->display();
		 
			 }
		/*消息页面详细内容*/	
		
		public  function newsdetail(){
			
			 $id=isset($_GET['id'])&& is_numeric($_GET['id'])? intval($_GET['id']):1;
			 		 
			 
			 $news=M("ecs_post_news");
			 
			 $data['isRead']=1;
			 
			 $news->where("id=$id")->save($data);
			 
			 $info=$news->where("id=$id")->find();
			 
			 $this->assign('own',checkChashi());
			 
			 $this->assign('info',$info);
			 
			 $this->display();
		
			
			} 
			
	   /*回复个人消息*/	
	   public  function reply(){
		   
		   if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
			
			 $pid=isset($_GET['pid'])&&is_numeric($_GET['pid'])? $_GET['pid']:1;
			 
			 $fid=isset($_GET['fid'])&&is_numeric($_GET['fid'])? $_GET['fid']:1;
			 
			 $news=M("ecs_post_news");
			 
			 $detail=$news->where("id=".$fid)->find();
			 
			 $this->assign('detail',$detail);

		 	 $this->assign('pid',$pid);
			 
			 $this->assign('fid',$fid);
			 
			 $this->assign('uid',checkChashi());
             
			 $this->display(); 
   
		   
		   }	
			
	
		
		/*
		 * 删除个人发布的产品
		 */
		public function delete(){
			if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
			$id=$_GET["id"];
		    $post=M('ecs_post');
		    $post_content=M('ecs_post_content');
		    $result=$post->where("id='$id'")->delete();		  
		    if($result!=false){
				//$post_content->where("pid=$id")->delete();
				echo 1;		    	
		    }else{
		    		echo -1;
		    }
		}
		
	public function search(){
		
		if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
		
		$this->display();
		
		}	
    public function find(){
		
		if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
		
		$key=trim($_POST['key']);
		
		$search=M();
		
		$sql="select c.* from `ecs_post` as c left join `ecs_post_content` as d on c.id=d.pid where c.name like '%$key%' or c.brand like '%$key%' or d.content like '%$key%' ";
		
		$result=$search->query($sql);
		
		$this->assign('data',$result);
		
		$this->display();
		
		
		
		}		
		
		
		
		
		
}
