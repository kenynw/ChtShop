<?php
/**
 * 社区管理控制器
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class mb_shequControl extends SystemControl{
    public function __construct(){
        parent::__construct();
    }

    public function indexOp() {
        $this->shequ_listOp();
    }

    public function shequ_listOp() {
		
		if (!empty($_POST['key'])){
			
			$key=addslashes($_POST['key']);
		
		  	$model=Model();
			
			$sql="SELECT `uid`,`content`,`time` FROM `shopnc_discuz_content` where `content` like %$key% ORDER BY `content_id` DESC";
			
			$mb_shequ_list=$model->query($sql);			
			
		}else{

        $model_mb_shequ = Model('mb_shequ_content');
				
		 $condition=array();
		 
		 if(isset($_GET['member_id'])) $condition['uid']=$_GET['member_id'];
		 
		 $mb_shequ_list = $model_mb_shequ->getShequList($condition, "*", 10,"content_id desc");
		 
		 $member=Model("member");
		 
		 $array=array();
		 
		 foreach($mb_shequ_list as $v){
			 
			 $name=$member->getMemberInfo("member_id='{$v['uid']}'",'member_name');
			 
			 $v['name']=$name['member_name'];
			 
			 $imagearray=explode(",",$v['image']);
			 
			 $string='';
			 
			 foreach($imagearray as $image){
				 
				 $string.="<img src='../data/upload/qunzi/$image'  width='25' height='25' >";			 
				 
				 }
			$v['image']=$string;	 
			 			 
			 $array[]=$v;
			 	 
			 }
		 
		 
		 
		 Tpl::output('page',$model_mb_shequ->showpage());

		 }
		 
		 //print_r($mb_shequ_list);
		 
		 Tpl::output('page',$model_mb_shequ->showpage());
        
		 Tpl::output('mb_shequ_list', $array);
		 
		 Tpl::output('member_id', $_GET['member_id']);
		
        Tpl::showpage('mb_shequ.list');
    }
	

    /**
     * 社区微博-晒一晒编辑
     */
    public function shequ_editorOp() {
		 //echo  1;
		 //exit();
        $content_id = intval($_GET["content_id"]);
        $shequ= Model('mb_shequ_content');
        $shequ_info = $shequ->getShequInfo(array('content_id' => $content_id));	
       
	    //print_r($shequ_info);
	    Tpl::output('shequ_info', $shequ_info);
        Tpl::showpage('shequ.editor');
    }
	/**
     * 社区微博-晒一晒编辑
     */
    public function shequ_addOp() {
	    Tpl::output('member_id', $_GET['member_id']);
        Tpl::showpage('shequ.add');
    }
	/**
     * 社区微博-晒一晒添加
     */
    public function shequ_insertOp() {
	    $shequModel=Model("mb_shequ_content");
		$data=array();
		$data['uid']=isset($_POST['uid'])?$_POST['uid']:1;
		$data['title']=$_POST['title'];
		$data['share']=$_POST['share'];
		$data['comment']=$_POST['comment'];
		$data['view']=$_POST['view'];
		$data['time']=date("Y-m-d H:i:s");
		$data['content']=$_POST['content'];
		$imageUrl='';	
		  $allowArray=array("image/gif","image/jpeg","image/pjpeg","image/png");
		  for($i=1;$i<=6;$i++){
			  if(!isset($_FILES['image'.$i])) continue;
			  if(!in_array($_FILES['image'.$i]['type'],$allowArray)) continue;
			  $type=substr($_FILES['image'.$i]['name'],-3);
			  $name=time().'_'.$i.".".$type;			  
	         $isUpSuccess=move_uploaded_file($_FILES['image'.$i]['tmp_name'],"../data/upload/qunzi/".$name); 
			  if($isUpSuccess) $imageUrl.=$name.',';
			  }	 
		  $imageUrl=rtrim($imageUrl,",");
		  $data['image']=$imageUrl;	  		
		$result=$shequModel->contentAdd($data);
		if($result){			
			showMessage("添加成功");			
			}else{			
			showMessage("添加失败");	
				}		
    }
	//删除
	public function shequ_delOp(){
		
		$content_id=intval($_GET["content_id"]);
		
		$shequModel=Model("mb_shequ_content");
		
		$result1=$shequModel->delShequInfo(array('content_id' => $content_id));
		
	    if($result1){		
			
			showMessage("删除成功");
			
			}else{		
					
			showMessage("删除失败");	
			
	    			}
		
		}
	//微博ajax 批量删除
	public function shequajax_delOp(){
		
		$content_id=intval($_GET["content_id"]);
		
		$shequModel=Model("mb_shequ_content");
		
		$result=$shequModel->delShequInfo(array('content_id' => $content_id));
				
		$data=array();
		
	    if($result){	
		
		  $data['result']=1;
		  
		  $data['id']=$content_id;
		
		  echo json_encode($data)	;	
			
			}else{				
		
		  $data['result']=0;
		  
		  $data['id']=$content_id;
		
		  echo json_encode($data)	;	
			
	    			}
		
		}
	//活动 ajax 批量删除
	public function activeajax_delOp(){		
		$active_id=intval($_GET["active_id"]);	
		$activeModel=Model("discuz_active");		
		$result=$activeModel->delActiveInfo(array('active_id' => $active_id));				
		$data=array();		
	    if($result){			
		  $data['result']=1;		  
		  $data['id']=$active_id;		
		  echo json_encode($data)	;			
			}else{						
		  $data['result']=0;		  
		  $data['id']=$active_id;		
		  echo json_encode($data)	;				
	    			}		
		}
	/*社区活动添加*/
	public function active_addOp(){		
		Tpl::showpage('active.add');		
		}
	/*社区活动添加*/
	public function active_editorOp(){
		$activeId=$_GET['active_id'];	
		$activeModel=Model("discuz_active");
		$condition=array();
		$condition['active_id']=$activeId;
		$activeInfo=$activeModel->getActiveInfo($condition);	
		//print_r($activeInfo);
		Tpl::output('activeInfo', $activeInfo);	
		Tpl::showpage('active.editor');		
		}
	/*社区活动更新*/
	public function active_updateOp(){
		$activeModel=Model('discuz_active');
		$data=array(); 
		$condition=array();
		$condition['active_id']=$_POST['active_id'];
		$data['active_title']=$_POST['active_title'];
		$data['location']=$_POST['location'];
		$data['join_time']=$_POST['join_time'];
		$data['last_time']=$_POST['last_time'];
		$data['object']=$_POST['object'];
		$data['number']=$_POST['number'];
		$data['content']=$_POST['content'];
		//$data['uid']=1;
		//print_r($_POST);
		//exit();
		$imageUrl='';	
		  $allowArray=array("image/gif","image/jpeg","image/pjpeg","image/png");
		  for($i=1;$i<=6;$i++){
			  if(!isset($_FILES['image'.$i])) continue;
			  if(!in_array($_FILES['image'.$i]['type'],$allowArray)) continue;
			  $type=substr($_FILES['image'.$i]['name'],-3);
			  $name=time().'_'.$i.".".$type;			  
	         $isUpSuccess=move_uploaded_file($_FILES['image'.$i]['tmp_name'],"../data/upload/qunzi/".$name); 
			  if($isUpSuccess) $imageUrl.=$name.',';
			  }	 
		  $imageUrl=rtrim($imageUrl,",");
		  $data['pics']=$imageUrl!=''?$imageUrl:$_POST['pics'];	  
		//print_r($data);			
		$result=$activeModel->activeUpdate($data,$condition);
		if($result){
			showMessage("更新成功");			
			}else{
			showMessage("更新失败");
				}				
		
		}				
	/*社区活动保存*/
	public function active_saveOp(){
		$activeModel=Model('discuz_active');
		$data=array(); 
		$data['active_title']=$_POST['active_title'];
		$data['location']=$_POST['location'];
		$data['join_time']=$_POST['join_time'];
		$data['last_time']=$_POST['last_time'];
		$data['object']=$_POST['object'];
		$data['number']=$_POST['number'];
		$data['content']=$_POST['content'];
		$data['uid']=1;
		//print_r($_POST);
		//exit();
		$imageUrl='';	
		  $allowArray=array("image/gif","image/jpeg","image/pjpeg","image/png");
		  for($i=1;$i<=6;$i++){
			  if(!isset($_FILES['image'.$i])) continue;
			  if(!in_array($_FILES['image'.$i]['type'],$allowArray)) continue;
			  $type=substr($_FILES['image'.$i]['name'],-3);
			  $name=time().'_'.$i.".".$type;			  
	         $isUpSuccess=move_uploaded_file($_FILES['image'.$i]['tmp_name'],"../data/upload/qunzi/".$name); 
			  if($isUpSuccess) $imageUrl.=$name.',';
			  }	 
		  $imageUrl=rtrim($imageUrl,",");
		  $data['pics']=$imageUrl;	  
		//print_r($_FILES);			
		$result=$activeModel->activeAdd($data);
		if($result){
			showMessage("添加成功");			
			}else{
			showMessage("添加失败");
				}			
		}			
    /*排序*/		
	public function chashiajax_recommendop(){
		
		$id=intval($_POST['id']);
		
		$recommend=intval($_POST['recommend']);
		
		$data=array();
		
		if($id==''||$recommend==''){
			
	    $data['state']="error";
		
		$data['info']="排序数字必须为数字";
		
		echo json_encode($data);
		
		 exit();
					
			}
			
	  $post=Model("ecs_post");
	  
	  $data['recommend']=$recommend;
	  
	  $condition['id']=$id;
	  
	  $result=$post->orderRecommend($data,$condition);		
	  
	  if($result){
		  
		$data['state']="right";
		
		$data['info']=$id;
		
		echo json_encode($data);
		  
		  
		  }else{
			  
		$data['state']="error";
		
		$data['info']=$id;
		
		echo json_encode($data);	  
			  
			  }

		
		}	

   /*掩藏*/		
   
    public function chashi_hiddenOp(){
		
		$id=intval($_GET['chashi_id']);
		
	   $post=Model("ecs_post");
	  
	   $data['recommend']=-1;
	  
	   $condition['id']=$id;
	  
	   $result=$post->orderRecommend($data,$condition);	
	   
	   if($result){			
			showMessage("隐藏成功");
			}else{				
			showMessage("掩藏失败");	
	    			}	
		
		}
		
	 /*掩藏*/		
   
    public function chashi_showOp(){
		
		$id=intval($_GET['chashi_id']);
		
	   $post=Model("ecs_post");
	  
	   $data['recommend']=0;
	  
	   $condition['id']=$id;
	  
	   $result=$post->orderRecommend($data,$condition);	
	   
	   if($result){			
			showMessage("操作成功");
			}else{				
			showMessage("操作失败");	
	    			}			
		}
		
	 /*编辑信息*/
	 
	 public function editorOp(){
		 
		 $id=isset($_GET['chashi_id'])?intval($_GET['chashi_id']):1;
		 
		 $post=Model("ecs_post");
		 
		 $condition=array();
		 
		 $condition['id']=$id;
		 
		 $info=$post->getChashiInfo($condition);
		 
		 $ecs_post_content=Model("ecs_post_content");
		 
		 $condition=array();
		 
		 $condition['pid']=$id;
		 
		 $content=$ecs_post_content->getChashiInfo($condition);
		 
		 
		 Tpl::output('info', $info);
		 
		 Tpl::output('content', $content);
       
	     Tpl::showpage('mb_chashi.editor');
 
		 
		 }
		 
	 	 
	 
    /**
     * 社区修改保存
     */
	 
	 public function shequ_saveOp(){
		 
		  $info=array();		  
		  $info['title']=addslashes($_POST['title']);	
		  $info['share']=addslashes($_POST['share']);	
		  $info['comment']=addslashes($_POST['comment']);
		  $info['view']=addslashes($_POST['view']);	
		  $info['share']=addslashes($_POST['share']);	
		  $info['content']=htmlspecialchars($_POST['content']);
		  $imageUrl='';	
		  $allowArray=array("image/gif","image/jpeg","image/pjpeg","image/png");
		  for($i=1;$i<=6;$i++){
			  if(!isset($_FILES['image'.$i])) continue;
			  if(!in_array($_FILES['image'.$i]['type'],$allowArray)) continue;
			  $type=substr($_FILES['image'.$i]['name'],-3);
			  $name=time().'_'.$i.".".$type;			  
	         $isUpSuccess=move_uploaded_file($_FILES['image'.$i]['tmp_name'],"../data/upload/qunzi/".$name); 
			  if($isUpSuccess) $imageUrl.=$name.',';
			  }	 
		  $imageUrl=rtrim($imageUrl,",");
		  $info['image']=$imageUrl;	  				  		 
		  $condition=array();		  
		  $condition['content_id']=intval($_POST['content_id']);		  
		  $shequModel=Model("mb_shequ_content");		  
		  //$result=$shequModel->contentUpdate($info,$condition);
		  $result=$shequModel->where($condition)->update($info);
		    if($result){	
			 //print_r($_FIELS);					
			showMessage("操作成功");		
			}else{							
			showMessage("操作失败");				
	    			}		
		   		 
		 }
	/*添加今日新声*/
	public function mb_newsaddOp(){
		
		  $info=array();		  
		  $info['title']=addslashes($_POST['title']);	
		  $info['uid']=1;	
		  $info['share']=addslashes($_POST['share']);	
		  $info['comment']=addslashes($_POST['comment']);
		  $info['view']=addslashes($_POST['view']);	
		  $info['share']=addslashes($_POST['share']);	
		  $info['time']=date("Y-m-d H:i:s");	
		  $info['content']=htmlspecialchars($_POST['content']);		  			  
		  $shequModel=Model("mb_shequ_content");
		  $imageUrl='';	
		  $allowArray=array("image/gif","image/jpeg","image/pjpeg","image/png");
		  for($i=1;$i<=6;$i++){
			  if(!isset($_FILES['image'.$i])) continue;
			  if(!in_array($_FILES['image'.$i]['type'],$allowArray)) continue;
			  $type=substr($_FILES['image'.$i]['name'],-3);
			  $name=time().'_'.$i.".".$type;			  
	         $isUpSuccess=move_uploaded_file($_FILES['image'.$i]['tmp_name'],"../data/upload/qunzi/".$name); 
			  if($isUpSuccess) $imageUrl.=$name.',';
			  }	 
		  $imageUrl=rtrim($imageUrl,",");	  
		  $info['image']=$imageUrl;	   
		  $result=$shequModel->newsAdd($info);		  
         // echo $result;
		    if($result){						
			showMessage("操作成功");		
			}else{							
			showMessage("操作失败");				
	    			}				
		}	 
	/*社区领袖*/
	public function mb_leaderOp(){					
		$memberModel=Model("member");		
		$members=$memberModel->getMemberList('', "*", 10,"guanzhu desc");
		//print_r($members);	
		Tpl::output('page',$memberModel->showpage());	
		Tpl::output('members', $members);		
       Tpl::showpage('mb_leader.list');		
		}
	/*社区今日新声管理*/
	public function mb_lastnewsOp(){
		
		 $model_mb_shequ = Model('mb_shequ_content');
				
		 $condition=array();
		 
		 $condition['uid']=1;
		 
		 $mb_shequ_list = $model_mb_shequ->getShequList($condition, "*", 10,"content_id desc");
		 
		 $member=Model("member");
		 
		 $array=array();
		 
		 foreach($mb_shequ_list as $v){
			 
			 $name=$member->getMemberInfo("member_id='{$v['uid']}'",'member_name');
			 
			 $v['name']=$name['member_name'];
			 
			 $imagearray=explode(",",$v['image']);
			 
			 $string='';
			 
			 foreach($imagearray as $image){
				 
				 $string.="<img src='../data/upload/qunzi/$image'  width='25' height='25' >";			 
				 
				 }
			$v['image']=$string;	 
			 			 
			 $array[]=$v;
		 }
		 
		 Tpl::output('page',$model_mb_shequ->showpage($condition));
        
		 Tpl::output('mb_shequ_list', $array);
		
        Tpl::showpage('lastnews.list');		
		}
	/*新增今日新声*/
	public function lastnews_addOp(){

        Tpl::showpage('lastnews.add');
   			
		}			 		 
	/*查找功能*/	 
	
	public function search(){
		
		$key=addslashes($_POST['search']);
		
		if($key==''){			
			return false;
			}
					
		}
	/*活动信息管理*/
	public function mb_activeOp(){
		$activeModel=Model("discuz_active");
		$actives=$activeModel->getActiveList('', "*", 10,"active_id desc");
		Tpl::output('page',$activeModel->showpage());
		Tpl::output('actives',$actives);
		Tpl::showpage('mb_active.list');				
		}	
	/*删除活动信息*/
	public function active_delOp(){		
		$active_id=intval($_GET["active_id"]);		
		$activeModel=Model("discuz_active");		
		$result=$activeModel->delActiveInfo(array('active_id' => $active_id));	
	    if($result){					
			showMessage("删除成功");			
			}else{						
			showMessage("删除失败");				
	    			}		
		}	
	 	 
    public function payment_saveOp() {
        $payment_id = intval($_POST["payment_id"]);

        $data = array();
        $data['payment_state'] = intval($_POST["payment_state"]);

        switch ($_POST['payment_code']) {
            case 'alipay':
                $payment_config = array(
                    'alipay_account' => $_POST['alipay_account'],
                    'alipay_key' => $_POST['alipay_key'],
                    'alipay_partner' => $_POST['alipay_partner'],
                );
                break;
            case 'wxpay':
                $payment_config = array(
                    'wxpay_partner' => $_POST['wxpay_partner'],
                    'wxpay_key' => $_POST['wxpay_key'],
                );
                break;
            default:
                showMessage(L('param_error'), '');
        }
        $data['payment_config'] = $payment_config;

        $model_mb_payment = Model('mb_payment');

        $result = $model_mb_payment->editMbPayment($data, array('payment_id' => $payment_id));
        if($result) {
            showMessage(Language::get('nc_common_save_succ'), urlAdmin('mb_payment', 'payment_list'));
        } else {
            showMessage(Language::get('nc_common_save_fail'), urlAdmin('mb_payment', 'payment_list'));
        }
    }	
	/*活动人数统计*/
	public function active_join_detailOp(){
		$ative_id=$_GET['active_id'];
		$activeModel=Model("discuzActiveMember");
		$condition=array();
		$condition['active_id']=$ative_id;
		$persons=$activeModel->getActiveList($condition);		
		Tpl::output('persons',$persons);
		Tpl::showpage('discuzActiveList.list');	
		
		
		}
	
	
}
