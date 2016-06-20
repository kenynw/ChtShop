<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 茶汇通社区控制器
 * @autho:jason lai
 * 2015.8.25
 */
class DiscuzController extends Controller { 

 
     /*社区首页*/
     public function index(){
	  
	   $this->display();
	  
	  
	  }



      /*社区用户中心*/
     public function member(){

      $member_id=$this->isLogin();	

      if(!$member_id){
     
      $this->error("您还未登陆","/wap/index.php/home/index/member");

      }	

      $member=M("member");

      $member_info=$member->where("member_id='$member_id'")->find();

     // print_r($member_info);

      $this->assign("member_info",$member_info);
	  
	   $this->display();
	  	  
	  
	   }	 
     /*获取用户信息列表页面*/
      public function memberContent(){

      $member_id=isset($_GET['id'])?intval($_GET['id']):3;

      //echo $member_id;
      
      $this->assign("member_id",$member_id);  
   
      $this->display();

      }

      /*活动页*/
      public  function actives(){

       $active_id=$_GET['id'];
       
       $this->assign("active_id",$active_id); 

       $this->display();

      }

      /*成员列表*/
      public function leaders(){


      $this->display();

      }

      /*活动详细页面*/
	  public  function activeDetail(){
		  
		  $active=M("discuz_active");
		  
		  $id=isset($_GET['id'])?intval($_GET['id']):1;
		  
		  $activeDetail=$active->where("active_id='$id'")->find();
		  	  
		  $this->assign("active",$activeDetail);
		 	  
		  $this->display();
		  		  
		  }


     /*用户发布和修改页*/

      public function contentEditor(){

      $this->display();

      }
	  /*添加活动*/
	  public function addActive(){
		  	  
		 $this->display(); 
		  		  
		  }

      /*首页领袖列表api*/

      public function home_page_leader_api(){

        $user_id=$user_id=!empty($this->isLoginApi($_POST['username'],$_POST['key']))?$this->isLoginApi($_POST['username'],$_POST['key']):'';

        $page=isset($_POST['page'])?intval($_POST['page']):'';

        $limit='';

        if($page==''){

        $limit=12;
                

        }else{


        $limit=(($page-1)*5).","."5";


        }

        $member=M("member");

        $leaders=array();

        if($user_id==''){

        $code=0;  

        $leaders=$member->order("guanzhu desc,member_id ASC")->limit($limit)->select();

        }else{

          $code=1;

         $members=$member->order("guanzhu desc,member_id ASC")->limit($limit)->select(); 

         $insterstModel=M("discuz_interest");

         $beInstered=$insterstModel->where("`uid`='$user_id'")->select();

         $insterList=array();

         foreach($beInstered as $value){


          array_push($insterList,$value['member_id']);


         }

         foreach($members as $member){

           if(in_array($member['member_id'],$insterList)){

             $member['beInstered']=1;

           }else{

             $member['beInstered']=0;

           }

            $leaders[]=$member;

          }


        }

        $array=array();

        $array['code']=200;

         $array['status']=$code;

        $array['content']=$leaders;



       echo json_encode($array); 


      }
	  /*今日新声*/
	  public  function last_news_api(){
		  
		  $contentModel=M("discuz_content");
		  
		  $content=$contentModel->where("uid='1'")->order("content_id desc")->find();
		  
		  $array=array();
		  
		  if($content){
			  
			  $memberModel=M("member");
			  
			  $memberInfo=$memberModel->field("member_name,member_avatar,guanzhu,rank")->where("member_id='1'")->find();
			  
			  $array['code']=200;
			  
			  $array['content']=$content;	
			  
			  $array['memberInfo']=$memberInfo;	  
			  
			  }else{
				  
			  $array['code']=404;
			  
			  $array['content']='获取不到数据';	  
				  			  
				  }
		  
		  
		  echo json_encode($array);
		  	  
		  }
		  
	  /*晒一晒*/	  
	  
	  public  function get_allperson_content_api(){
		  
		  $contentModel=M("discuz_content");
		  
		  $page=isset($_POST['page'])?intval($_POST['page']):'';
		  
		  if($page==''){
			  
		    $content=$contentModel->order("content_id desc")->limit(2)->select();
		  
			  
			  }else{
		  
		    $content=$contentModel->order("content_id desc")->limit(($page-1)*5,5)->select();
		  
			  }
			  
		$array=array();
		
		if($content){
			
			$memberModel=M("member");
			
			$data=array();
			
			foreach($content as $v){
				
				
				$value=$memberModel->field("member_name,member_avatar,guanzhu,rank")->where("member_id='{$v['uid']}'")->find();
				
				$v['memberInfo']=$value;
				
				$data[]=$v;
							
				}
			
			$array['code']=200;
			
			$array['content']=$data;
					
			}else{
				
			$array['code']=200;
			
			$array['content']=$content;
							
				}	
				
		echo json_encode($array);		  	  
		  }
		  

      /*获取客户发表内容列表*/

      public function member_content_api(){

        $member_id=isset($_POST['member_id'])?intval($_POST['member_id']):3;

        /*获取用户头像头衔关注度*/

        $memberModel=M("member");

        $memberInfo=$memberModel->field("member_avatar,member_name,rank,guanzhu")->where("member_id='$member_id'")->find();

        $page=isset($_POST['page'])?intval($_POST['page']):1;

        $contentModel=M("discuz_content");
		
        if($page==0){
			
	     $content=$contentModel->where("uid='$member_id'")->order("content_id desc")->select();
		
			}else{
				
        $content=$contentModel->where("uid='$member_id'")->order("content_id desc")->limit(($page-1)*5,5)->select();
		
		}

        $array=array();

        if($content){

         $array['code']=200;
         
         $array['content']=$content;

         $array['memberInfo']=$memberInfo; 

        }else{

         $array['code']=404;
         
         $array['content']="已经没有内容"; 

         $array['memberInfo']=$memberInfo;

        }

        echo json_encode($array);


      }

      /*关注客户接口*/

      public function add_insterst_api(){

        $user_id=$user_id=!empty($this->isLoginApi($_POST['username'],$_POST['key']))?$this->isLoginApi($_POST['username'],$_POST['key']):'';

        $member_id=isset($_POST['member_id'])?intval($_POST['member_id']):'';

        $array=array();

        $insterstModel=M("discuz_interest");


        if($user_id==$member_id||$user_id==''||$member_id==''){


        $array['code']=404;

        $array['content']='您未登录或者你不能关注自己本身';  

        echo json_encode($array);

        die();


        }

        $done=$insterstModel->where("uid='$user_id' and member_id='$member_id'")->find();

        if($done){
        
         $array['code']=404;

         $array['content']='已经关注过了';

         echo json_encode($array);

         die();

        }

        $data=array();

        $data['uid']=$user_id;

        $data['member_id']=$member_id;

        $data['interest_time']=date("Y-m-d h:i:s");


        $result=$insterstModel->add($data);

        if($result){

          $memberModel=M("member");

          $memberModel->where("member_id='$member_id'")->setInc("guanzhu",1);

          $array['code']=200;

          $array['content']="添加成功";

        }else{

         $array['code']=404;

         $array['content']="添加失败";

        }

        echo json_encode($array);





      }
	  
	  /*分享api*/
	  
	  function add_share_api(){
		  
		  $content_id=isset($_POST['content_id'])?intval($_POST['content_id']):1;
		  
		  $array=array();
		  
		  $contentModel=M("discuz_content");
		  
		  $result=$contentModel->where("content_id='$content_id'")->setInc("share",1);
		  
		  if($result){
			  
			  $array['code']=200;
			  
			  $array['content']='更新成功';
			  		  
			  }else{
				  
			  $array['code']=404;
			  
			  $array['content']='更新失败';  
				  
				  
				  }
				  
		  echo json_encode($array);		  
		  
		  	  
		  }

      /*客户活动编辑接口*/
      public function active_editor_api(){

        $user_id=$user_id=!empty($this->isLoginApi($_POST['username'],$_POST['key']))?$this->isLoginApi($_POST['username'],$_POST['key']):'';

        $active_id=isset($_POST['active_id'])?intval($_POST['active_id']):'';

        $array=array();

        if($user_id==''||$active_id==''){

          $array['code']=404;

          $array['content']="参数错误";

          echo json_encode($array);

          die();

        }

        $discuzActiveModel=M("discuz_active");

        $content=$discuzActiveModel->where("`active_id`='$active_id' and `uid`='$user_id'")->find();

        if($content){

           $array['code']=200;

           $array['content']=$content;

        }else{

           $array['code']=404;

           $array['content']="删除的content_id,用户只能删除自己的帖子";
 

        }

        echo json_encode($array);
 
      }



      /*获取被关注者信息接口*/

      public function insterst_member_api(){

      	//$user_id=isset($_POST['user_id'])? intval($_POST['user_id']):3;

      	$user_id=!empty($this->isLoginApi($_POST['username'],$_POST['key']))?$this->isLoginApi($_POST['username'],$_POST['key']):3;

      	$page=isset($_POST['page'])?intval($_POST['page']):1;

      	$interest=M("discuz_interest");

      	$interest_members=$interest->field("member_id")->where("`uid`='$user_id'")->order("interest_time desc")->limit(($page-1)*5,5)->select();

      	$data=array();

      	if(!$interest_members){

      	$data['code']=404;
      	
      	$data['content']="没数据了";	

      	echo json_encode($data);

      	exit();



      	}

      	$in='';

      	foreach($interest_members as $member){

      	$in.=$member['member_id'].",";	

      	}

      	$in=rtrim($in,",");

      	$member_model=M("member");

      	$interest_person=$member_model->where("member_id in ($in)")->select();

      	//print_r($interest_person);

      	

      	if($interest_person){

      		$data['code']=200;

      		$data['content']=$interest_person;


      	}else{

      		$data['code']=404;

      		$data['content']="获取数据失败";



      	}

      	echo json_encode($data);


      }

      /*用于获取自己发布的话题*/

      public function get_user_topic_api(){

      	//$user_id=isset($_POST['user_id'])? intval($_POST['user_id']):3;

      	$user_id=$this->isLoginApi($_POST['username'],$_POST['key']);

      	$page=isset($_POST['page'])? intval($_POST['page']):1;

      	$discuz_content=M("discuz_content");

      	$content=$discuz_content->where("`uid`='$user_id'")->order("content_id desc")->limit(($page-1)*5,5)->select();

      	$array=array();

      	if($content){


          $array['code']=200;

          $array['content']=$content;


      	 }else{

      	  $array['code']=404;
      	  
      	  $array['content']="暂无数据";	

 
      	 }

      	 echo json_encode($array);


      }

      /*取消客户关注*/

      public function move_instersters(){

         //$user_id=isset($_POST['user_id'])?intval($_POST['user_id']):3;

      	 $user_id=$this->isLoginApi($_POST['username'],$_POST['key']);

         $member_id=isset($_POST['member_id'])?intval($_POST['member_id']):'';

         $array=array();

         if($member_id==''){
          
           $array['code']=404;

           $array['content']='客户id未设置';

           echo json_encode($array);

         }

         $discuz_interest=M("discuz_interest");

         $result=$discuz_interest->where("uid='$user_id' and member_id='$member_id'")->delete();

         if($result){

          $array['code']='200';

          $array['content']="删除成功";

         }else{

          $array['code']='200';

          $array['content']="删除失败";
       

         }

         echo json_encode($array);


      }

      /*获取客户评论信息*/

      public function get_comment_api(){

        $user_id=$this->isLoginApi($_POST['username'],$_POST['key']);

        $page=isset($_POST['page'])?$_POST['page']:1;  

        $commentModel=M("discuz_comment");

        $comment=$commentModel->where("`uid`='3' or `member_id`='3'")->order("id desc")->limit(($page-1)*5,5)->select();

        $array=array();

        if($comment){

           $memberModel=M("member");          

           $content=array();

           foreach($comment as $value){

            $member_id=$value['member_id'];

            $memberInfo=$memberModel->field("member_name,member_avatar")->where("`member_id`='$member_id'")->find();

            $value['member_name']=$memberInfo['member_name'];

            $value['member_avatar']=$memberInfo['member_avatar'];

            $reply_number=$commentModel->where("`reply_id`='{$value['id']}'")->count();

            $value['reply_number']=$reply_number;

            $content[]=$value;


           }


          $array['code']=200;

          $array['content']=$content;

         }else{
        
          $array['code']=$user_id; 

          $array['content']="已经没有数据了";

        }

        echo json_encode($array);


       }

      /*获取发的帖子的评论*/
      
      public function get_content_comment_api(){

        $content_id=isset($_POST['content_id'])?intval($_POST['content_id']):1;

        $array=array();

        $commentModel=M("discuz_comment");

        $content=$commentModel->where("content_id='$content_id'")->order("id desc")->select();

        if(!$content){

          $array['code']=404;
          
          $array['content']='暂无评论';  

          echo json_encode($array);

          die();

         }

         $info=array();

         $memberModel=M("member");

         foreach($content as $v){


          $v['memberInfo']=$memberModel->field("member_name,member_avatar,guanzhu,rank")->where("member_id='{$v['member_id']}'")->find();

          $info[]=$v;


         }

         $memberModel=M("member");

         $array['code']=200;
         
         $array['content']=$info;

         echo json_encode($array); 


       } 

       /*添加某条内容的评论*/
       public function add_content_comment_api(){

        $content_id=isset($_POST['content_id'])?intval($_POST['content_id']):'';

        $member_id=!empty($this->isLoginApi($_POST['username'],$_POST['key']))? $this->isLoginApi($_POST['username'],$_POST['key']):'';

        $array=array();

        if($content_id==''||$member_id==''){

          $array['code']=404;

          $array['content']='您还未登陆或者';

          echo json_encode($array);

          die();
        
         }

         $contentModel=M("discuz_content");

         $user_id=$contentModel->field("uid")->where("content_id='$content_id'")->find();

         $uid=$user_id['uid'];

         //$comment=addcslashes($_POST['comment']);

         if($_POST['comment']==""){

          $array['code']=404;

          $array['content']='评论内容不能为空';

          echo json_encode($array);

          die();

         }

         //$uid=intval($_POST['uid']);


         $data=array();

         $data['content_id']=$content_id;

         $data['comment']=htmlspecialchars($_POST['comment']);

         $data['uid']=$uid;

         $data['member_id']=$member_id;

         $data['comment_time']=date("Y-m-d H:i:s");

         $data['reply_to']=isset($_POST['reply_to'])?$_POST['reply_to']:'';

         $commentModel=M("discuz_comment");

         $result=$commentModel->add($data);

         if($result){
           
            $array['code']=200;

            $memberModel=M("member");
			/*评论加1*/
			
			$contentModel=M("discuz_content");
			
			$contentModel->where("content_id")->setInc('view',1);
					
			/**/

            $content=$memberModel->field("member_name,member_avatar,guanzhu,rank")->where("member_id='$member_id'")->find();

            $array['content']['memberInfo']=$content;

            $array['comment']=$data['comment'];
			
			 $array['time']=$data['comment_time'];
			 
			 $array['reply_to']=$data['reply_to'];

            //echo json_encode($array);

         }else{

            $array['code']=404;

            $array['content']='添加失败';
         }
         
         echo json_encode($array);
       }
	   
	   /*添加点赞*/
	   public  function add_zan_api(){
		   
		   $content_id=intval($_POST['content_id']);
		   
		   //$usernmae=$_POST['username'];
		   
		   //$key=$_POST['key'];
		   
		   $user_id=$this->isLoginApi($_POST['username'],$_POST['key']);
		   
		   $array=array();
		   
		   if($content_id==''){
			   
			   $array['code']=404;
			   
			   $array['content']='帖子id不能为空';	
			   
			   echo json_encode($array);	  
			   
			   die(); 
			   		   
			   }
		   
		   if($user_id==''){
			   
			   $array['code']=404;
			   
			   $array['content']='您还未登陆';	
			   
			   echo json_encode($array);	  
			   
			   die(); 
			   
			   }
			   
		  $zanModel=M("discuz_zan");
		  
		  $already=$zanModel->where("uid='$user_id' and content_id='$content_id'")->find();	
		  
		  if($already){
			  
			   $array['code']=404;
			   
			   $array['content']='您已经点过赞了';	
			   
			   echo json_encode($array);	  
			   
			   die(); 
			   		  
			  }   
		  
		  $contentModel=M("discuz_content");	 
		  
		  $result=$contentModel->where("content_id='$content_id'")->setInc("view",1);  
		  
		  if($result){
			  
			  $array['code']=200;
			  
			  $array['content']='点赞成功';
			  
			  $data=array();
			  
			  $data['uid']=$user_id;
			  
			  $data['content_id']=$content_id;
			  
			  $zanModel->add($data);
			  			  
			  }else{
				  
			  $array['code']=404;
			  
			  $array['content']='点赞失败';  
				  
				  }
			   
			echo json_encode($array);   
			 			   
		   	   
		   }

       /*获取客户参加活动信息*/ 

       public function get_active_api(){

        $user_id=!empty($this->isLoginApi($_POST['username'],$_POST['key']))? $this->isLoginApi($_POST['username'],$_POST['key']):3;

        $page=isset($_POST['page'])?intval($_POST['page']):1;

        $activeMemberModel=M("discuz_active_member");

        $ins=$activeMemberModel->field("active_id")->where("member_id='$user_id' and `status`='1'")->select();

        $in='';

        foreach($ins as $v){

          $in.=$v['active_id'].',';

         }

         $in=rtrim($in,',');

         $activeModel=M("discuz_active");

         $content=$activeModel->where("`active_id` in ($in) or `uid`='$user_id'")->order("`time` desc")->limit(($page-1)*5,5)->select();

         $array=array();

         if($content){

          $array['code']=200;

          $array['content']=$content;

          $array['uid']=$user_id;

         }else{

          $array['code']=404;

          $array['content']='已经没有数据了';

         } 

         echo json_encode($array);


      }

     /*删除客户发布的信息*/

     public function del_content_api(){

      $content_id=isset($_POST['content_id'])?intval($_POST['content_id']):6;

      $user_id=$this->isLoginApi($_POST['username'],$_POST['key']);

      $array=array();

       if($content_id==''||$user_id==''){

       $array['code']=404;

       $array['content']='参数无效';

       echo json_encode($array);

       die();

       }

       $contentModel=M("discuz_content");

       $result=$contentModel->where("`content_id`='$content_id'")->delete();

        if($result){

        $array['code']=200;

        $array['content']='删除成功';


       }else{

        $array['code']=404;

        $array['content']='删除失败';


       }

        echo json_encode($array);

       
     }




     /*取消客户活动*/ 

     public function del_active_api(){


       $user_id=$this->isLoginApi($_POST['username'],$_POST['key']);

       $active_id=isset($_POST['active_id'])?intval($_POST['active_id']):'';

       $array=array();

       if($active_id==''||$user_id==''){

       $array['code']=404;

       $array['content']='参数无效';

       echo json_encode($array);

       die();

       }

       $discuzMemberModel=M("discuz_active_member");

       $data['status']=0;

       $result=$discuzMemberModel->where("`active_id`='$active_id' and `member_id`='$user_id'")->save($data);

       if($result){

        $array['code']=200;

        $array['content']='删除成功';


       }else{

        $array['code']=404;

        $array['content']='删除失败';


       }

       echo json_encode($array);

      }   
	  
	  /*获取所有人活动api*/
	  
	  public function get_allperson_active_api(){
		  
		  $activeModel=M("discuz_active");
		  
		  $page=isset($_POST['page'])?intval($_POST['page']):1;
		  
		  if($page==0){
		  
		  $actives=$activeModel->order("active_id  desc")->select();
		  
		  }else{
			  
		  $actives=$activeModel->order("active_id  desc")->limit(($page-1)*8,8)->select();	  
			  
			  }
			 
		  $array=array();	  
		
		  if($actives){
			  
			  $memberModel=M("member");
			  
			  $content=array();
			  
			  foreach($actives as $v){
				  
				  $memberInfo=$memberModel->field("member_name,member_avatar,guanzhu,rank")->where("member_id='{$v['uid']}'")->find();
				  
				  $v['memberInfo']=$memberInfo;
				  
				  $content[]=$v;
				   				  
				  }		  
			  
			  $array['code']=200;
			  
			  $array['content']=$content;
			  		 		  
			  }else{
				  
			  $array['code']=404;
			  
			  $array['content']='获取不到数据';	  
				 				  
				  }	  
	        
			echo json_encode($array); 	  
		  
		  }
		  
	 /*参与活动api*/
	 public function join_active_api(){
		 
		 $user_id=$this->isLoginApi(addslashes($_POST['username']),addslashes($_POST['key']));
		 
		 $array=array();
		 
		 if($user_id==''){
			 
			 $array['code']=404;
			 
			 $array['content']='您还未登陆';
			 
			 echo json_encode($array);
			 
			 die();
			 		 
			 }
		 
		 $telphone=$_POST['telphone'];
		 
		 $data=array();
		 
		 $data['telphone']=$telphone;
		 
		 $data['member_name']=addslashes($_POST['username']);	 
		 
		 $data['join_time']=date("Y-m-d H:i:s");
		 
		 $data['member_id']=$user_id;
		 
		 $data['status']=1;
		 
		 $data['active_id']=intval($_POST['active_id']);
		 
		 $active_member=M("discuz_active_member");
		 
		 $result=$active_member->add($data);
		 
		 if($result){
			 
			 $data['code']=200;
			 
			 $data['content']='添加成功';
			 			 
			 }else{
				 
			 $data['code']=200;
			 
			 $data['content']='添加成功';
				 
				 
				 }
			 
		  echo json_encode($data); 
		 
		 }	  
		 
	  /*保存活动*/
	  function save_content_api(){
		  
		  $uid=$this->isLoginApi(addslashes($_POST['username']),addslashes($_POST['key']));
		  
		  $array=array();
		  
		  if(!$uid){
			  
			  $array['code']=404;
			  
			  $array['content']='您还未登陆';
			  
			  echo json_encode($array);
			  
			  die();			  
			  
			  }
			 
			$data=array();
			
			$data['uid']=$uid;
			
			$data['title']=addslashes($_POST['tile']);
			
			$data['content']=addslashes($_POST['content']);
			
			$data['time']=date("Y-m-d H:i:s");
			
			$data['share']=0;
			
			$data['view']=0;
			
			$data['comment']=0;
			
		    $images=isset($_POST['pics'])?json_decode($_POST['pics']):json_decode($_POST['images']);
		  
		    $pics='';
		  
		   foreach($images as $key=>$v){
			  
			  $pics.="$key,";
			  
			  file_put_contents("/data/upload/qunzi/$key",base64_decode($v));
			  		  		  
			  }
		  
		   $pics=rtrim($pics,','); 
		  
		   $data['pics']=$pics;
		   
		   $contentModel=M("discuz_content");
		   
		   $result=$contentModel->add($data);
		   
		   if($result){
			   
			   $array['code']=200;
			   
			   $array['content']='上传成功';
			   			   
			   }else{
				   
			   $array['code']=404;
			   
			   $array['content']='上传失败';
 				   
				   }
				   
				   
	     echo json_encode($array);
		  
		  }	 
		 
	  /*保存活动*/
	  function save_active_api(){
		  
		  $uid=$this->isLoginApi(addslashes($_POST['username']),addslashes($_POST['key']));
		  
		  $array=array();
		  
		  if(!$uid){
			  
			  $array['code']=404;
			  
			  $array['content']='您还未登陆';
			  
			  echo json_encode($array);	
			  
			  die();	  
			  
			  }
		  
		  $data=array();
		  
		  $data['active_title']=json_decode($_POST['active_title']);
		  
		  $data['location']=json_decode($_POST['location']);
		  
		  $data['join_time']=json_decode($_POST['join_time']);
		  
		  $data['last_time']=json_decode($_POST['last_time']);
		  
		  $data['tplphone']=json_decode($_POST['telphone']);
		  
		  $data['content']=json_decode($_POST['content']);
		  
		  $data['free']=json_decode($_POST['free']);
		  
		  $data['time']=date("Y-m-d H:i:s");
		  
		  $data['uid']=$uid;
		  
		  $images=isset($_POST['pics'])?json_decode($_POST['pics']):json_decode($_POST['images']);
		  
		  $pics='';
		  
		  foreach($images as $key=>$v){
			  
			  $pics.="$key,";
			  
			  file_put_contents("/data/upload/qunzi/$key",base64_decode($v));
			  		  		  
			  }
		  
		  $pics=rtrim($pics,','); 
		  
		  $data['pics']=$pics;
		  
		  $activeModel=M("discuz_active");
		  
		  $result=$activeModel->add($data);	
		  
		  if($result){
			  
			  $array['code']=200;
			  
			  $array['content']='添加成功';
			  		  
			  }else{
				  
			  $array['code']=404;
			  
			  $array['content']='添加失败';
			  		  	  		  
				  }  
				  
			 echo json_encode($array);	  
		  
		  
		  }	 
		  


	  
     /*客户是否登陆检测*/
     private function isLogin(){
	  
	  $username=$_COOKIE['username'];
	  
	  $key=$_COOKIE['key'];
	  
	  if(empty($username)||empty($key)){
		  		  
		 return 0;
		  
		 die();
		  
		  }
		
	   $token=M("mb_user_token");
	   
	   $result=$token->where("member_name='$username' and token='$key'")->find();
	   
	   if($result){
		   
		   return $result['member_id'];
		   
		   }else{
			   
		  return 0;	   
			   
			   }
		  
	  
	  }	  

	  /*客户端登陆api*/

	 private function isLoginApi($username,$key){
	  
	 	
	   $token=M("mb_user_token");
	   
	   $result=$token->where("member_name='$username' and token='$key'")->find();
	   
	   if($result){
		   
		   return $result['member_id'];
		   
		   }else{
			   
		   return 0;	   
			   
			   }
		  
	  
	  }	  
	  
	 /*TEST*/
	 
	 public function postSave(){
		 		 
		      $file_base64 = preg_replace('/data:.*;base64,/i', '', $_POST['pic1']);
			  
             $file_base64 = base64_decode($file_base64);
			 
			  echo $file_base64;

             file_put_contents("/data/upload/qunzi/23.jpg", $file_base64);
				 
		 } 
  
	  
	  
	
	
}