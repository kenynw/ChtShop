<?php
/**
 * 免费样品管理
 *
 *
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
define('ImgPath','../data/upload/shop/store/goods/2/');
class mb_sample_manageControl extends SystemControl{

    static $sampleModel;
	public function __construct(){
		parent::__construct();
		Language::read('mobile');
        if((!is_object(self::$sampleModel))){
            self::$sampleModel = Model("goods_sample");
        }

	}
    //样品列表页
    public function sample_listOp(){
        $state=isset($_GET['state'])? intval($_GET['state']):'';
        if(($state!='')&&(in_array($state,array(0,1,2),true))){
            $sampleList=self::$sampleModel->where("sample_state='$state'")->order("sample_id desc")->page(20)->select();
        }else{
            $sampleList=self::$sampleModel->order("sample_id desc")->page(20)->select();
        }
        Tpl::output('page',self::$sampleModel->showpage());
        Tpl::output('sampleList',$sampleList);
        Tpl::showpage('sampleList.list');
    }
    //样品添加
     public function sample_addOp(){
         $goods_id=$_GET['goods_id'];
         Tpl::output('goods_id',$goods_id);
         Tpl::showpage('sample.add');
     }
    // sample save method
    public function sample_saveOp(){
         //print_r($_POST);
         //print_r($_FILES);
        $data=array();
        $data['sample_name']=$_POST['sample_name'];
        $data['sample_origin_place']=$_POST['sample_origin_place'];
        $data['sample_weight']=$_POST['sample_weight'];
        $data['sample_freight']=$_POST['sample_freight'];
        $data['sample_limit_number']=$_POST['sample_limit_number'];
        $data['sample_start_time']=time();
        $data['sample_start_time']=strtotime($_POST['sample_start_time']);
        $data['sample_end_time']=strtotime($_POST['sample_end_time']);
        $data['sample_state']=1;
        $data['sample_link']=$_POST['sample_link'];
        if($data['sample_name']==''||$data['sample_link']==''){
            showmessage("样品名和样品关联产品id不能为空");
        }
        if($_POST['sample_image_hidden']){
            $data['sample_image']=$_POST['sample_image_hidden'];
        }else{
            $image='';
            $legitType=array('image/jpeg','image/png','image/gif');
            $resizeImage	= new ResizeImage();
            for($i=0;$i<6;$i++){
                if($_FILES['sample_image']['error'][$i]!==0) break;
                if(!in_array($_FILES['sample_image']['type'][$i],$legitType)) showmessage('图片类型不正确');
                $type=substr($_FILES['sample_image']['type'][$i],-3);
                if($type=='peg') $type='jpg';
                $name=time().'_'.$i.'.'.$type;
                $uploadResult=move_uploaded_file($_FILES['sample_image']['tmp_name'][$i],ImgPath.$name);
                if($uploadResult){
                    $resizeImage->newImg(ImgPath.$name,60,60,0,"_60." , ImgPath);
                    $resizeImage->newImg(ImgPath.$name,360,360,0,"_360." , ImgPath);
                    $image.=$name.',';
                }
            }
            $image= rtrim($image,',');
            $data['sample_image']=$image;
        }
        /*备份商品的价格<<*/
        $goodsModel=model("goods");
        $priceArray=$goodsModel->filed("goods_price,goods_promotion_price")->where("goods_id='".$_POST["goods_id"]."'")->find();
        $data['sample_bak_price']=$priceArray['goods_price'];
        $data['sample_bak_promotion_price']=$priceArray['goods_promotion_price'];
        /*备份商品的价格>>*/
       $insertResult=self::$sampleModel->insert($data);
       if($insertResult){
           //更改对应商品信息,价格设置为0,如果有运费设置运费;
           $condition=array();
           $condition['goods_id']=$_POST["goods_id"];
           $data=array();
           $data['goods_price']=0;
           $data['goods_freight']=$_POST['sample_freight'];
           $data['is_goods_sample']=1;
           $goodsModel->table("goods")->where($condition)->update($data);
           showmessage('添加成功');

       }else{
           showmessage('添加失败');

       }
    }
    //样品编辑页
    public function  sample_editorOp(){
       $sample_id=intval($_GET['sample_id']);
        if($sample_id=='') showmessage('参数不正确');
        $sampleInfo=self::$sampleModel->where("sample_id='$sample_id'")->find();
        if(!$sampleInfo) showmessage('参数不正确');
        Tpl::output("sampleInfo",$sampleInfo);
        Tpl::showpage("sampleEditor");

     }
    //method of update of sample control which to update the samole info
    public function sample_updateOp(){
        $data=array();
        $data['sample_name']=$_POST['sample_name'];
        $data['sample_origin_place']=$_POST['sample_origin_place'];
        $data['sample_weight']=$_POST['sample_weight'];
        $data['sample_freight']=$_POST['sample_freight'];
        $data['sample_limit_number']=$_POST['sample_limit_number'];
        $data['sample_start_time']=time();
        $data['sample_start_time']=strtotime($_POST['sample_start_time']);
        $data['sample_end_time']=strtotime($_POST['sample_end_time']);
        $data['sample_state']=1;
        if($_FILES['sample_image']['name'][0]!=''){
            $image='';
            $legitType=array('image/jpeg','image/png','image/gif');
            $resizeImage	= new ResizeImage();
            for($i=0;$i<6;$i++){
                if($_FILES['sample_image']['error'][$i]!==0) break;
                if(!in_array($_FILES['sample_image']['type'][$i],$legitType)) showmessage('图片类型不正确');
                $type=substr($_FILES['sample_image']['type'][$i],-3);
                if($type=='peg') $type='jpg';
                $name=time().'_'.$i.'.'.$type;
                $uploadResult=move_uploaded_file($_FILES['sample_image']['tmp_name'][$i],ImgPath.$name);
                if($uploadResult){
                    $resizeImage->newImg(ImgPath.$name,60,60,0,"_60." , ImgPath);
                    $resizeImage->newImg(ImgPath.$name,360,360,0,"_360." , ImgPath);
                    $image.=$name.',';
                }
             //print_r($_FILES['sample_image']);
            }
            $image= rtrim($image,',');
            $data['sample_image']=$image;
        }else{
            $data['sample_image']=$_POST['sample_image_hidden'];
        }
        $insertResult=self::$sampleModel->where("sample_id='".intval($_POST['sample_id'])."'")->update($data);
        if($insertResult){
            //print_r($_FILES['sample_image']);
            showmessage('更新成功');
        }else{
            showmessage('更新失败');

        }

    }
    //sample delete method
    public function sample_deleteOp(){
        $sample_id=intval($_GET['sample_id']);
        if($sample_id=='') showmessage('参数错误');
        $sampleInfo=self::$sampleModel->field("sample_image")->where("sample_id='$sample_id'")->find();
        if(!$sampleInfo) showmessage('参数错误');
        $imageString=$sampleInfo['sample_image'];
        //echo $imageString;
        $deleteResult= self::$sampleModel->where("sample_id='$sample_id'")->delete();
        if($deleteResult){
            $imageArray=explode(',',$imageString);
            foreach($imageArray as $image){
                unlink(ImgPath.$image);
            }
            showmessage(" 删除成功");

        }else{
            showmessage("删除失败");
        }


    }
    //method get goods info by goods_id
    public function get_info_by_goods_idOp(){
        $goods_id=isset($_POST['goods_id'])?$_POST['goods_id']:'';
        $array=array();
        if(!$goods_id||!is_numeric($goods_id)){
            $array['code']=404;
            $array['content']='商品id不合法'.$goods_id;
            echo json_encode($array);
            die();
        }
        $goodsModel=Model("goods");
        $goodsInfo=$goodsModel->field("goods_id,goods_commonid,goods_name")->where("goods_id='$goods_id'")->find();
        if(!$goodsInfo){
            $array['code']=404;
            $array['content']='查找不到数据,八成产品id不对';
            echo json_encode($array);
            die();
        }
        $data=array();
        $data['goods_name']=$goodsInfo['goods_name'];
        //find the images of goods
        $goodsImagesModel=Model("goods_images");
        $images=$goodsImagesModel->field("goods_image")->where("goods_commonid='".$goodsInfo['goods_commonid']."'")->select();
        //print_r($images);
        $imagesString='';
        foreach($images as $v){
         $imagesString.=$v['goods_image'].',';
        }
        $imagesString=substr($imagesString,0,-1);
        $data['goods_image']=$imagesString;
        $array['content']=$data;
        $array['code']=200;
        echo json_encode($array);

    }



}

?>
