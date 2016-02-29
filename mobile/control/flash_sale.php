<?php
/**
 * cms首页
 *
 *
 *

 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
define("IMAGE_PACH","http://www.chahuitong.com/data/upload/shop/store/goods/2/");
class flash_saleControl extends mobileHomeControl{
    const XIANSHI_GOODS_STATE_CANCEL = 0;
    const XIANSHI_GOODS_STATE_NORMAL = 1;
    public function __construct() {
        parent::__construct();
    }

    public function current_apiOp(){
        $flashSaleModel = Model('p_xianshi_goods');
        $condition = array();
        $condition['state'] = self::XIANSHI_GOODS_STATE_NORMAL;
        $condition['start_time'] = array('lt', TIMESTAMP);
        $condition['end_time'] = array('gt', TIMESTAMP);
        $flashGoods=$flashSaleModel->where($condition)->order("xianshi_recommend desc")->page(5)->select();
        $goodsModel=Model("goods");
        $flashTemp=array();
        foreach($flashGoods as $goods){
            //商品缩率图图片
            list($imageName,$imageType)=explode('.',$goods['goods_image']);
            $goods['goods_image']=array();
            $goods['goods_image']['original_pic']=IMAGE_PACH.$imageName.'.'.$imageType;
            $goods['goods_image']['bmiddle_pic']=IMAGE_PACH.$imageName.'_360.'.$imageType;
            //商品总量和 销售 begin
            $xianshiExtraInfo=$goodsModel->field("goods_salenum,goods_storage")->where("goods_id='".$goods['goods_id']."'")->find();
            $goods['goods_salenum']=$xianshiExtraInfo['goods_salenum'];
            $goods['goods_storage']=$xianshiExtraInfo['goods_storage'];
            //商品总量和 销售 end
            $flashTemp[]=$goods;
        }
        //print_r($flashGoods);
        if($flashTemp){
            output_json(1,$flashTemp,'查找成功');
        }else{
            output_json(0,$flashTemp,'没有数据了');
        }

    }

    public function coming_apiOp(){
        $flashSaleModel = Model('p_xianshi_goods');
        //获取明日的起点时间秒数和 结束时间秒数
        //先获取今日的起点时间，加上秒速，就是明日的起点时间
        $todayStartTime=date("Y-m-d 00:00:00",time());
        $todayStartSeconds=strtotime($todayStartTime);
        //明日的时间起点
        $tomorowStartSeconds=$todayStartSeconds+(24*60*60);
        $tomorowEndSeconds=$tomorowStartSeconds+(24*60*60);
        $condition = array();
        $goodsModel=Model("goods");
        $condition['state'] = self::XIANSHI_GOODS_STATE_NORMAL;
        $condition['start_time'] = array('lt', $tomorowStartSeconds);
        $condition['end_time'] = array('gt', $tomorowEndSeconds);
        $flashGoods=$flashSaleModel->where($condition)->order("xianshi_recommend desc")->page(5)->select();
        $flashTemp=array();
        foreach($flashGoods as $goods){
            list($imageName,$imageType)=explode('.',$goods['goods_image']);
            $goods['goods_image']=array();
            $goods['goods_image']['original_pic']=IMAGE_PACH.$imageName.'.'.$imageType;
            $goods['goods_image']['bmiddle_pic']=IMAGE_PACH.$imageName.'_360.'.$imageType;
            //商品总量和 销售begin
            $xianshiExtraInfo=$goodsModel->field("goods_salenum,goods_storage")->where("goods_id='".$goods['goods_id']."'")->find();
            $goods['goods_salenum']=$xianshiExtraInfo['goods_salenum'];
            $goods['goods_storage']=$xianshiExtraInfo['goods_storage'];
            //商品总量和 销售end
            $flashTemp[]=$goods;
        }
        if($flashTemp){
            output_json(1,$flashTemp,'查找成功');
        }else{
            output_json(0,$flashTemp,'没有数据了');
        }

    }

}

?>