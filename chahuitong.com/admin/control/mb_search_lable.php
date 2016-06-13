<?php
/**
 * 免费样品管理
 *
 *
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class mb_search_lableControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('mobile');
    }
    //获取分类
    public function search_keyOp(){
        //获取目录
        //获取品牌

        //print_r($brand_array);
        //获取属性词汇
        //定义可选的 属性id

        //查找已添加标签
        $searchLableModel=model("search_lable");
        $choiceLables=$searchLableModel->order("lable_order desc")->page(20)->select();
        Tpl::output('page',$searchLableModel->showpage());
        Tpl::output('choiceLables',$choiceLables);
        Tpl::showpage('sampleLable.list');
    }
    //获取品牌,目录，属性值
    public function get_lable_textOp(){
        //$_POST['lable_type']=2;
        $data=array();
        if($_POST['lable_type']==1){
            $class_array = Model('goods_class')->getGoodsClassForCacheModel();
            $brandArray=array();
            $i=0;
            foreach($class_array as $value){
                $brandArray[$i]['name']=$value['gc_name'];
                $brandArray[$i]['value']=$value['gc_id'];
                $i++;
            }
            $data['code']=1;
            $data['data']['lable_type']=1;
            $data['data']['content']=$brandArray;
            $data['msg']='查询成功';


        }
        if($_POST['lable_type']==2){
        $legalAttrArray=array(3333,3332,3331,3330,3329,3328,3327,3326,3325,3324,3323,3322,3321,3320,3319,3318);
        $attributeValueModel=Model("attribute_value");
        $inLegaAttr=implode(",",$legalAttrArray);
        $attrValueArray=$attributeValueModel->where("attr_value_id in ($inLegaAttr)")->select();
        $attrArray=array();
        foreach($attrValueArray as $attrValue){
            $tempArray=explode("/",$attrValue['attr_value_name']);
            $attrArray=array_merge($tempArray,$attrArray);
        }
        $attrArray=array_unique($attrArray);
        $attrArrayNew=array();
        $i=0;
        foreach($attrArray as $key=>$value){
                $attrArrayNew[$i]['name']=$value;
                $attrArrayNew[$i]['value']=0;
            $i++;
         }

           $data['code']=1;
           $data['data']['lable_type']=2;
           $data['data']['content']=$attrArrayNew;
           $data['msg']='查找完成';
        }
        if($_POST['lable_type']==3){
            $brand_array=Model("brand")->field("brand_id,brand_name")->where("brand_apply='1'")->select();
            $brandArray=array();
            foreach($brand_array as $key=>$value){
               $brandArray[$key]['name']=$value['brand_name'];
               $brandArray[$key]['value']=$value['brand_id'];
            }
            $data['code']=1;
            $data['data']['lable_type']=3;
            $data['data']['content']=$brandArray;
            $data['msg']="查找完成";

        }
        if(!isset($_POST['lable_type'])){
            $data['code']=0;
            $data['data']='';
            $data['msg']='参数不正确'.$_POST['lable_type'];
        }

        echo json_encode($data);

    }
    //把关键词 写入到数据库
    public function insert_lable_keyOp(){
        $name=$_POST['name'];
        $value=$_POST['value'];
        $lable_type=$_POST['lable_type'];
        $lableModel=Model("search_lable");
        $condition=array();
        $condition['lable_text']=$name;
        $condition['lable_value']=$value;
        $condition['lable_type']=$lable_type;
        $alreadyExists=$lableModel->where("lable_text='$name' and lable_value='$value'")->find();
        if($alreadyExists){
            $data['code']=0;
            $data['data']='';
            $data['msg']=" 插入失败,已有此标签";
            echo json_encode($data);
            die();
        }
        $insertResult=$lableModel->insert($condition);
        $data=array();
        if($insertResult){
            $data['code']=1;
            $data['data']=$insertResult;
            $data['msg']="插入成功";
        }else{
            $data['code']=0;
            $data['content']='';
            $data['msg']='插入失败';
        }
        echo json_encode($data);
    }
    // 关键词排序
    public function sort_lableOp(){
        $lable_id=$_POST['lable_id'];
        $sort_num=$_POST['sort_num'];
        $data=array();
        if($lable_id==''||$sort_num==''){
            $data['code']=0;
            $data['data']='';
            $data['msg']='参数不完整';
            echo json_encode($data);
            die();
        }
        $lableModel=Model("search_lable");
        $condition=array();
        $condition['lable_order']=$sort_num;
        $upresult=$lableModel->where("lable_id='{$_POST['lable_id']}'")->update($condition);
        if($upresult){
            $data['code']=1;
            $data['data']=$upresult;
            $data['msg']='更新成功';
            echo json_encode($data);
            die();
        }else{
            $data['code']=0;
            $data['data']='';
            $data['msg']='更新失败';
            echo json_encode($data);
            die();
        }
    }
    //删除标签
    public function del_lableOp(){
        $lable_id=$_GET['lable_id'];
        $lableModel=Model("search_lable");
        $deleteResult=$lableModel->where("lable_id='$lable_id'")->delete();
        if($deleteResult){
            showmessage("删除完成");
        }else{
            showmessage("删除失败");
        }

    }
    //批量插入
    /*
    public function insert_all_attrOp(){
        $legalAttrArray=array(3333,3332,3331,3330,3329,3328,3327,3326,3325,3324,3323,3322,3321,3320,3319,3318);
        $attributeValueModel=Model("attribute_value");
        $inLegaAttr=implode(",",$legalAttrArray);
        $attrValueArray=$attributeValueModel->where("attr_value_id in ($inLegaAttr)")->select();
        $attrArray=array();
        foreach($attrValueArray as $attrValue){
            $tempArray=explode("/",$attrValue['attr_value_name']);
            $attrArray=array_merge($tempArray,$attrArray);
        }
        $attrArray=array_unique($attrArray);
        $attrArrayNew=array();
        $i=0;
        $lableModel=Model("search_lable");
        $condition=array();
        foreach($attrArray as $key=>$value){
            $condition['lable_text']=$value;
            $condition['lable_value']=0;
            $condition['lable_type']=2;
            $condition['lable_order']=0;
            $lableModel->insert($condition);

        }


    }
    */


}

?>
