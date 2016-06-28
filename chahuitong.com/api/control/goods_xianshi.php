<?php
/**
 * 限时抢购
 * User: Liao
 * Date: 16/4/19
 * Time: 下午9:19
 */

defined('InShopNC') or exit('Access Invalid!');
class xianshi_goodsControl extends mobileHomeControl {

    const XIANSHI_STATE_NORMAL = 1; // 正常

    const XIANSHI_STATE_CLOSE = 2; // 关闭

    const XIANSHI_STATE_CANCEL = 3; // 取消

    const XIANSHI_NAME_CURRENT = '今日抢购';

    /**
     * 获取今日抢购列表
     */
    public function current_listOp() {
        $model_xianshi_goods = Model('p_xianshi_goods');

        $field = 'xianshi_goods_id,xianshi_id,goods_id,store_id,xianshi_price,goods_name,goods_image,goods_price,start_time,end_time,state,xianshi_recommend';

        $order = 'xianshi_recommend desc';

        $condition = array();
        $condition['state'] = self::XIANSHI_STATE_NORMAL;
        $condition['start_time'] = array('lt', TIMESTAMP);
        $condition['end_time'] = array('gt', TIMESTAMP);
        $condition['xianshi_name'] = self::XIANSHI_NAME_CURRENT;
        $xianshi_goods_list = $model_xianshi_goods -> getXianshiGoodsList($condition, $this->page, $order, $field);

        // 如果后台没有及时设置商品,获取所有抢购商品
        if(empty($xianshi_goods_list)) {
            $condition = array(
                'state' => self::XIANSHI_STATE_NORMAL,
                'start_time' => array('lt', TIMESTAMP),
                'end_time' => array('gt', TIMESTAMP),
            );
            $xianshi_goods_list = $model_xianshi_goods -> getXianshiGoodsList($condition,$this->page);
        }

        $model_goods = Model('goods');
        foreach ($xianshi_goods_list as $key => $goods) {
            $goods_info = $model_goods -> getGoodsInfo(array('goods_id' => $goods['goods_id']), 'goods_salenum,goods_storage');
            $xianshi_goods_list[$key]['goods_salenum'] = $goods_info['goods_salenum'];
            $xianshi_goods_list[$key]['goods_storage'] = $goods_info['goods_storage'];
            $xianshi_goods_list[$key]['goods_image_url'] = cthumb($goods['goods_image'], 360, $goods['store_id']);
        }

        $page_count = $model_xianshi_goods -> gettotalpage();

        output_json(1, array('list' => $xianshi_goods_list), 'SUCCESS', mobile_page($page_count));
    }

}

?>