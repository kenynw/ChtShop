<?php
/**
 * cms首页
 *
 *
 *

 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
class flash_saleControl extends mobileHomeControl{
    public function __construct() {
        parent::__construct();
    }

    public function current_apiOp(){
        $model_xianshi_goods = Model('p_xianshi_goods');

        $field = 'xianshi_goods_id,xianshi_id,goods_id,store_id,xianshi_price,goods_name,goods_image,goods_price,start_time,end_time,state,xianshi_recommend';

        $order = 'xianshi_recommend desc';

        $condition['state'] = 1;
        $condition['start_time'] = array('lt', TIMESTAMP);
        $condition['end_time'] = array('gt', TIMESTAMP);
        $goods_list = $model_xianshi_goods -> getXianshiGoodsList($condition, $this->page, $order, $field);

        $model_goods = Model('goods');
        foreach ($goods_list as $key => $goods) {
            $goods_info = $model_goods -> getGoodsInfo(array('goods_id' => $goods['goods_id']), 'goods_salenum,goods_storage');
            $goods_list[$key]['goods_salenum'] = $goods_info['goods_salenum'];
            $goods_list[$key]['goods_storage'] = $goods_info['goods_storage'];

            // 商品URl
            $goods_list[$key]['goods_image_url'] = cthumb($goods['goods_image'], 360, $goods['store_id']);
        }

        output_json(1, $goods_list);
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
        $condition['state'] = 1;
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