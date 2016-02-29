<?php
	/* 判读是否已登录 */
    function isLogin(){
		if(!empty($_SESSION["admin"])&&!empty($_SESSION["admin_id"])){
			return 1;
		}else{
			return 0;
		}
	}
	
	/* 判断权限 */
	function isRight($admin_id){
		$admin=M("admin");
		$data=$admin->where("id=$admin_id")->find();
		if(count($data)>0){
			return $data["admin_type"];
		}else{
			return -1;
		}
	}
	
	/*判断是否能进入茶市*/
	function checkChashi(){
				  			
		   $sessid=substr($_COOKIE['ECS_ID'],0,32);	

		   $sess=M('ecs_sessions');	
		   
		   $data=$sess->where("sesskey='".$sessid."'")->find();	
		   
		    if($data&&($data['userid']!=0)){
			   
			   $session=unserialize($data['data']);
			    $session['user_id']=$data['userid'];
			   $user=M('ecs_users');
			   $info=$user->where("user_id='".$session['user_id']."'")->find();
			   if($info['checkid']==1){		
							return $session['user_id'];   
				   }else{					   
					  return false;   
					     }			   			   
	   			   }else{					   
				      return false;					   
					   }	
		}
	/*根据id 调取ecs_post表中的图片*/	
	function get_img($id){
		
		if(is_numeric($id)){
			
			$post=M("ecs_post");
			
			$pic=$post->field('pic')->where("id=$id")->find();
            
			echo $pic['pic']; 		
			}
		
		}
		/*根据id 调取ecs_post表中的图片*/	
	function get_name($id){
		
		if(is_numeric($id)){
			
			$post=M("ecs_post");
			
			$pic=$post->field('name')->where("id=$id")->find();
            
			echo $pic['name']; 		
			}
		
		}	
	function get_user($cid){
		
		if(is_numeric($cid)){
			
			$post=M("ecs_users");
			
			$pic=$post->field('user_name')->where("user_id=$cid")->find();
            
			echo $pic['user_name']; 		
			}
		
		}	
	/*查询ecs_post_news信息中 未读取个数*/
	
	function isRead($pid,$cid){
		
		     $news=M('ecs_post_news');
		
		
		}
	/*模板减法运算*/	
	function template_substract($a,$b){  
    echo(intval($a)-intval($b));  
}  	

   /*获取新闻列表中的回复*/
   
    function myreply($fid){
		
		 if(is_numeric($fid)){
			
			 $fid=intval($fid);
			 
			 $news=M('ecs_post_news');
			 
			 $reply=$news->where("cid='".$_SESSION['user_id']."' and fid='$fid'")->find(); 
			 
			  if($reply['content']){
				  
				  echo "<font style='color:#CCC'>{$reply['content']}</font>";
				  
				  
				  }else{
					echo "<font style='color:#CCC'>还未回复</font>"; 
					  
					  }
		 
			 }

		}
	
	
	
		
		
?>