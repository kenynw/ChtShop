<?php
/**
 * cms首页
 *
 *
 *

 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
define("Goods_Img_Patch","http://www.chahuitong.com/data/upload/shop/store/goods/");
class tasters_recommendsControl extends mobileHomeControl{
    public function __construct() {
        parent::__construct();
    }

    public function indexOp(){
        //品茶师推荐
        $page=isset($_POST['page'])?intval($_POST['page']):1;
        //$page=isset($_GET['page'])?intval($_GET['page']):1;
        $sql="";
        //按目录分类进行筛选
        if(isset($_POST['byCatalog'])&&($_POST['byCatalog']==1)){
        $sql.=" order by gc_id desc";
        }elseif(isset($_POST['byCatalog'])&&($_POST['byCatalog']==0)){
            $sql.=" order by gc_id asc";
        }
        if(isset($_POST['gc_id'])){
            $sqlByGc='';
            $sqlByGc="and gc_id='".$_POST['gc_id']."'";
        }else{
            $sqlByGc='';
        }
        //按价格进行筛选
        if(isset($_POST['byPrice'])&&($_POST['byPrice']==1)){
            if(isset($_POST['byCatalog'])){
                $sql.=" , goods_price desc";
            }else{
                $sql.="order by goods_price desc";
            }

        }elseif(isset($_POST['byPrice'])&&($_POST['byPrice']==0)){
            if(isset($_POST['byCatalog'])){
                $sql.=" ,goods_price asc";
            }else{
                $sql.="order by goods_price asc";
            }

        }

        //按销量进行筛选
        if(isset($_POST['bySalenum'])&&($_POST['bySalenum']==1)){
            if(isset($_POST['byCatalog'])||isset($_POST['byPrice'])){
                $sql.=" , goods_salenum asc";
            }else{
                $sql.=" order by goods_salenum asc";
            }

        }elseif(isset($_POST['bySalenum'])&&($_POST['bySalenum']==0)){
            if(isset($_POST['byCatalog'])||isset($_POST['byPrice'])){
                $sql.=" , goods_salenum desc";
            }else{
                $sql.=" order by goods_salenum desc";
            }
        }

        //按季节 暂留 改成按 热度
        //按销量进行筛选
        if(isset($_POST['byClick'])&&($_POST['byClick']==0)){
            if(isset($_POST['byCatalog'])||isset($_POST['byPrice'])||isset($_POST['bySalenum'])){
                $sql.=" , goods_click asc";
            }else{
                $sql.=" order by goods_salenum asc";
            }

        }elseif(isset($_POST['byClick'])&&($_POST['byClick']==1)){
            if(isset($_POST['byCatalog'])||isset($_POST['byPrice'])||isset($_POST['bySalenum'])){
                $sql.=" , goods_click desc";
            }else{
                $sql.=" order by goods_click desc";
            }

        }


        //查询推荐商品有几个类别
        $goodsModel=Model();
        $data=array();
        if($page==1) {
            $gcsql = 'SELECT DISTINCT `gc_id` from shopnc_tasters_recommend as recommend left join shopnc_goods as goods ON recommend.recommend_goods_id=goods.goods_id';
            $catArray = $goodsModel->query($gcsql);
            $inString = '';
            foreach ($catArray as $value) {
                if($value['gc_id']!='') {
                    $inString .= $value['gc_id'] . ',';
                }
            }
            $inString = rtrim($inString, ',');
            $goodsClassModel = Model("goods_class");
            $gcInfo = $goodsClassModel->field("gc_id,gc_name")->where("gc_id in ($inString)")->select();
            //print_r($catArray);
            $data['goods_class']=$gcInfo;
        }
        //print_r($gcInfo);

        $condition=array();
        $condition['goods_verify']=1;
        $condition['goods_commend']=1;
        if($sql==''){
            //$sql = "select goods_id,goods_name,goods_image,goods_price,goods_promotion_price,goods_marketprice,goods_promotion_type,store_id from shopnc_goods where goods_verify='1' and goods_commend='1' order by goods_id desc limit " . (($page - 1) * 15) . ' , 15';
        $sql="select g.goods_id,g.goods_name,g.goods_image,g.goods_price,g.goods_promotion_price,g.goods_marketprice,g.goods_promotion_type,g.store_id,r.recommend_score,r.recommend_taste,r.recommend_light,r.recommend_aroma,r.recommend_leaf from shopnc_tasters_recommend as r left join shopnc_goods as g on r.recommend_goods_id=g.goods_id where g.goods_verify='1' and g.goods_commend='1' and r.recommend_state='1' $sqlByGc order by goods_id desc limit ".(($page - 1) * 15) . ' , 15';
        }else {
            $sql="select g.goods_id,g.goods_name,g.goods_image,g.goods_price,g.goods_promotion_price,g.goods_marketprice,g.goods_promotion_type,g.store_id,r.recommend_score,r.recommend_taste,r.recommend_light,r.recommend_aroma,r.recommend_leaf from shopnc_tasters_recommend as r left join shopnc_goods as g on r.recommend_goods_id=g.goods_id where g.goods_verify='1' and g.goods_commend='1' and r.recommend_state='1' $sqlByGc  $sql  limit ".(($page - 1) * 15) . ' , 15';
        }
        $tastersRecommends=$goodsModel->query($sql);
        $tempArray=array();
        $xianshiModel=Model("p_xianshi_goods");

        foreach($tastersRecommends as $value){
            list($imageNmae,$imageType)=explode('.',$value['goods_image']);
            $value['goods_image']=array();
            $value['goods_image']['original_pic']=Goods_Img_Patch.$value['store_id'].'/'.$imageNmae.'.'.$imageType;
            $value['goods_image']['bmiddle_pic']=Goods_Img_Patch.$value['store_id'].'/'.$imageNmae.'_360.'.$imageType;
            if($value['goods_promotion_price']!=0.00){
                $value['goods_price']=$value['goods_promotion_price'];
            }else{
                $value['goods_price']=$value['goods_price'];
            }
            /*获取促销价格*/
            $xianInfo=$xianshiModel->field("xianshi_price")->where("goods_id='".$value['goods_id']."' and ". TIMESTAMP.">start_time and ".TIMESTAMP."<end_time")->find();
            if($xianInfo){
                //$value['xianshi_price']=$xianInfo['xianshi_price'];
                $value['goods_price']=$xianInfo['xianshi_price'];
            }
            /*获取地址*/
            $sql="select a.goods_id ,v.attr_value_name from `shopnc_goods_attr_index` as a left join `shopnc_attribute_value` as v on a.attr_value_id=v.attr_value_id where ( v.attr_id BETWEEN 266 and 277) and a.goods_id='".$value['goods_id']."'";
            $areaInfo=$goodsModel->query($sql);
            if($areaInfo){
                $value['area']=$areaInfo[0]['attr_value_name'];
            }else{
                $value['area']='未知';
            }
            $tempArray[]=$value;
        }

        $data['tastersRecommends']=isset($tempArray)?$tempArray:'';
        if($tastersRecommends){
            output_json(1,$data,'查找成功');
        }else{
            outpu_json_error(0,'已经没有数据了');
        }

    }

    public function testOp(){

        echo "11111";
    }

}

?>