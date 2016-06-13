<?php
/**
 * 手机支付方式
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
define('ImgPath','../data/upload/mobile/home/');
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
			
			$sql="select c.* from `shopnc_ecs_post` as c left join `shopnc_ecs_post_content` as d on c.id=d.pid where c.name like '%$key%' or c.brand like '%$key%' or d.content like '%$key%'";
			
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
    /*茶市行情列表*/
    public function chashi_quotationOp(){
        $quotationModel=Model("ecs_quotation");
        $brandId=isset($_GET['brandId'])?$_GET['brandId']:1;
        $quotationGoods=$quotationModel->where("brand_id='$brandId'")->select();
        //print_r($quotationGoods);
        Tpl::output('quotationGoods', $quotationGoods);
        Tpl::showpage('chashi.qutation.list');
    }
    /*添加茶市行情信息*/
    public function qutation_addOp(){
        $brandModel=Model("brand");
        $brands=$brandModel->field("brand_id,brand_name")->select();
        //print_r($brands);
        $html='';
        foreach($brands as $brand){
            $html.='<option value="'.$brand['brand_id'].'">'.$brand['brand_name'].'</option>';
        }
        Tpl::output('option', $html);
        Tpl::showpage('chashi.qutation.add');
    }
    /*保存新增加茶市行情信息*/
    public function qutation_saveOp(){
        $array=array();
        $array['brand_name']=$_POST['brand_name'];
        $array['brand_name']=$_POST['brand_name'];
        $array['brand_name']=$_POST['brand_name'];
    }
    /*首页图片管理*/
    public function home_picOp(){
        $homePicModel=Model("home_pic");
        $pics=$homePicModel->select();
        //print_r($pics);
        Tpl::output('pics', $pics);
        Tpl::showpage('home.pic.list');

    }
     /*首页图片编辑*/
     public function homepic_editorOp(){
         $id=$_GET['id'];
         $homePicModel=Model("home_pic");
         $pic=$homePicModel->where("id='$id'")->find();
         //print_r($pic);
         Tpl::output('pic', $pic);
         Tpl::showpage('homepic.editor');

    }
    /*首页图片更新*/
    public  function adv_saveOp(){
        $homePicModel=Model("home_pic");
        $data=array();
        $data['link']=trim($_POST['link']);
        $data['`order`']=trim($_POST['order']);
        $data['state']=trim($_POST['state']);
        $data['location']=trim($_POST['location']);
        if(is_uploaded_file($_FILES['image']['tmp_name'])){
            $path="../data/upload/mobile/home/";
            $file=$path.$_POST['imageback'];
            unlink($file);
            list(,$imageType)=explode("/",$_FILES['image']['type']);
            if(strtolower($imageType)=='jpeg') $imageType='jpg';
            $newfile=TIMESTAMP.'.'.$imageType;
            $isSaveSuccess=move_uploaded_file($_FILES['image']['tmp_name'],$path.$newfile);
            if($isSaveSuccess){
                $resizeImage	= new ResizeImage();
                $resizeImage->newImg(ImgPath.$newfile,60,60,0,"_60." , ImgPath);
                $resizeImage->newImg(ImgPath.$newfile,360,360,0,"_360." , ImgPath);
                $data['image']="http://www.chahuitong.com/data/upload/mobile/home/".TIMESTAMP.".".$imageType;
            }

        }else{
            $data['image']=$_POST['imageback'];
        }
        $array=array();
        $array['where']="id='{$_POST['id']}'";
        $result=$homePicModel->update($data,$array);
        if($result) {
            showMessage("更新成功");
        } else {
           // print_r($_POST);
           showMessage("更新失败");
        }
    }
    /*首页图片添加*/
    public function homepic_addOp(){

        Tpl::showpage('homepic.add');
    }
    /*保存新增加首页链接*/
    public  function adv_addOp(){
        $homePicModel=Model("home_pic");
        $data=array();
        $data['link']=trim($_POST['link']);
        $data['`order`']=trim($_POST['order']);
        $data['state']=trim($_POST['state']);
        $data['location']=trim($_POST['location']);
        if(is_uploaded_file($_FILES['image']['tmp_name'])){
            $path="../data/upload/mobile/home/";
            $file=$path.$_POST['imageback'];
            unlink($file);
            list(,$imageType)=explode("/",$_FILES['image']['type']);
            if(strtolower($imageType)=='jpeg') $imageType='jpg';
            $newfile=TIMESTAMP.'.'.$imageType;
            $isSaveSuccess=move_uploaded_file($_FILES['image']['tmp_name'],$path.$newfile);
            if($isSaveSuccess){
                $resizeImage	= new ResizeImage();
                $resizeImage->newImg(ImgPath.$newfile,60,60,0,"_60." , ImgPath);
                $resizeImage->newImg(ImgPath.$newfile,360,360,0,"_360." , ImgPath);
                $data['image']="http://www.chahuitong.com/data/upload/mobile/home/".TIMESTAMP.".".$imageType;
            }
        }
        $result=$homePicModel->insert($data);
        if($result) {
            showMessage("更新成功");
        } else {
            // print_r($_POST);
            showMessage("更新失败");
        }
    }
    /*删除首页图片*/
    public function  homepic_delOp(){
        $id=trim($_GET['id']);
        $homePicModel=Model("home_pic");
        $data=array();
        $data['id']=$id;
        $result=$homePicModel->where($data)->delete();
        if($result) {
            showMessage("删除成功");
        } else {
            // print_r($_POST);
            print_r($result);
            //showMessage("删除失败");
        }

    }

    public function testOp(){

        $path="../data/upload/mobile/home/";
        $newfile="1454377562.jpg";
        $resizeImage = new ResizeImage();
        $resizeImage->newImg($path . $newfile, 60, 60, 0, "_60.", $path);
        $resizeImage->newImg($path . $newfile, 360, 360, 0, "_360.", $path);
    }





}
