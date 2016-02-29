<?php
/**
 * 手机支付方式
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class mb_chashiControl extends SystemControl{
    public function __construct(){
        parent::__construct();
    }

    public function indexOp() {
        $this->chashi_listOp();
    }

    public function chashi_listOp() {
		if (!empty($_POST['key'])){
			
			$key=addslashes($_POST['key']);
		
		  	$model=Model();
			
			$sql="select c.* from `33hao_ecs_post` as c left join `33hao_ecs_post_content` as d on c.id=d.pid where c.name like '%$key%' or c.brand like '%$key%' or d.content like '%$key%'";
			
			$mb_chashi_list=$model->query($sql);			
			
		}else{

        $model_mb_chashi = Model('ecs_post');
		 $condition=array();
		 $mb_chashi_list = $model_mb_chashi->getChashiList('', "*", 10,"recommend desc");
		 
		 Tpl::output('page',$model_mb_chashi->showpage());

		 }
		 //print_r($mb_chashi_list);
		 //Tpl::output('page',$model_mb_chashi->showpage());
        Tpl::output('mb_chashi_list', $mb_chashi_list);
        Tpl::showpage('mb_chashi.list');
    }
	

    /**
     * 编辑
     */
    public function chashi_editOp() {
        $chashi_id = intval($_GET["chashi_id"]);
        $ecs_post = Model('ecs_post');
        $chashi_info = $ecs_post->getChashiInfo(array('id' => $chashi_id));
		 $ecs_post_content=Model("ecs_post_content");
		 $chashi_info['content'] = $ecs_post_content->getChashiInfo(array('pid' => $chashi_id));
		 $ecs_post_content=Model("ecs_post_content");
		 
		 
		 
       Tpl::output('chashi_info', $chashi_info);
       Tpl::showpage('chashi.edit');
    }
	//删除
	public function chashi_delOp(){
		
		$chashi_id=intval($_GET["chashi_id"]);
		
		$ecs_post=Model("ecs_post");
		
		$result1=$ecs_post->delChashiInfo(array('id' => $chashi_id));
		
		$ecs_post_content=Model("ecs_post_content");
		
		$result2=$ecs_post_content->delChashiInfo(array('pid' => $chashi_id));
		
	    if($result1&&$result2){			
			showMessage("删除成功");
			}else{				
			showMessage("删除失败");	
	    			}
		
		}
	//ajax 批量删除
	public function chashiajax_delOp(){
		
		$chashi_id=intval($_GET["chashi_id"]);
		
		$ecs_post=Model("ecs_post");
		
		$result1=$ecs_post->delChashiInfo(array('id' => $chashi_id));
		
		$ecs_post_content=Model("ecs_post_content");
		
		$result2=$ecs_post_content->delChashiInfo(array('pid' => $chashi_id));
		
		$data=array();
		
	    if($result1&&$result2){	
		
		  $data['result']=1;
		  
		  $data['id']=$chashi_id;
		
		  echo json_encode($data)	;	
			
			}else{				
		
		  $data['result']=0;
		  
		  $data['id']=$chashi_id;
		
		  echo json_encode($data)	;	
			
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
     * 编辑保存
     */
	 
	 public function chashi_saveOp(){
		 
		  $info=array();		  
		  $info['brand']=addslashes($_POST['brand']);	
		  $info['name']=addslashes($_POST['name']);	
		  $info['price']=addslashes($_POST['price']);
		  $info['year']=addslashes($_POST['year']);	
		  $info['saleway']=addslashes($_POST['saleway']);	
		  $info['recommend']=intval($_POST['recommend']);	
		  $condition=array();
		  
		  $condition['id']=intval($_POST['id']);
		  
		  $ecs_post=Model("ecs_post");
		  
		  $result=$ecs_post->orderRecommend($info,$condition);
		  
		  $content=array();
		  
		  $content['content']=addslashes($_POST['content']);
		  
		  $ecs_post_content=Model("ecs_post_content");
		  
		  $condition=array();
		  
		  $condition['pid']=intval($_POST['id']);
		  
		  $result2=$ecs_post_content->contentUpdate($content,$condition);
		  
		  
		    if($result&&$result2){			
			showMessage("操作成功");
			}else{				
			showMessage("操作失败");	
	    			}		
		   
		   	
		    
		 
		 
		 
		 
		 
		 
		 
		 }
		 
	/*查找功能*/	 
	
	public function search(){
		
		$key=addslashes($_POST['search']);
		
		if($key==''){			
			return false;
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
}
