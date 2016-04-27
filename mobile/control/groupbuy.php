<?php
/**
 * 团购,抢购,免费茶样
 * User: Sgun
 * Date: 16/4/27
 * Time: 下午1:54
 */
defined('InShopNC') or exit('Access Invalid!');
class groupbuyControl extends mobileHomeControl {

    /**
     * 审核中
     */
    const GROUPBUY_STATE_REVIEW = 10;

    /**
     * 正常
     */
    const GROUPBUY_STATE_NORMAL = 20;

    /**
     * 审核失败
     */
    const GROUPBUY_STATE_REVIEW_FAIL = 30;

    /**
     * 管理员关闭
     */
    const GROUPBUY_STATE_CANCEL = 31;

    /**
     * 已结束
     */
    const GROUPBUY_STATE_CLOSE = 32;

    public function __construct()
    {
        parent::__construct();

        if (intval(C('groupbuy_allow')) !== 1) {
            output_json(0, array(), '该功能暂时关闭');
        }
    }

    /**
     * 免费茶样详情
     *
     */
    public function sample_infoOp()
    {
        $model_groupbuy = Model('groupbuy');
        $model_goods = Model('goods');

        $groupbuy_info = $model_groupbuy->getGroupbuyOnlineInfo(array('groupbuy_name' => array('like', '%免费茶样%')));

        if (empty($groupbuy_info)) {
            $groupbuy_info = $model_groupbuy->getGroupbuyOnlineInfo(array('class_id' => 4));
        }

        if (empty($groupbuy_info)) {
            $condition['state'] = array('in', array(self::GROUPBUY_STATE_REVIEW, self::GROUPBUY_STATE_NORMAL));
            $condition['groupbuy_name'] = array('like', '%免费茶样%');
            $field = 'groupbuy_id,groupbuy_name,start_time,end_time,goods_id,goods_commonid,goods_name,store_id,groupbuy_price,upper_limit,state';
            $groupbuy_list = $model_groupbuy->getGroupbuyExtendList($condition, $this->page, 'end_time desc', $field, 1);
            $groupbuy_info = $groupbuy_list[0];
        }

        if ($this->_is_bought($groupbuy_info['groupbuy_id'])) {
            $groupbuy_info['button_text'] = '已领取';
        }

        $goods_image_list = $model_goods->getGoodsImageList(array('goods_commonid' => $groupbuy_info['goods_commonid']), 'goods_image');
        foreach ($goods_image_list as $key => $value) {
            $goods_image_list[$key]['goods_image_small'] = cthumb($value['goods_image'], '240', $groupbuy_info['store_id']);
            $goods_image_list[$key]['goods_image_mid'] = cthumb($value['goods_image'], '360', $groupbuy_info['store_id']);
        }

        $groupbuy_info['goods_image_list'] = $goods_image_list;

        output_json(1, $groupbuy_info);
    }

    /**
     * @param $group_id
     * @return bool
     */
    private function _is_bought($group_id)
    {
        $model_mb_user_token = Model('mb_user_token');
        $key = $_POST['key'];
        if (empty($key)) {
            $key = $_GET['key'];
        }
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);

        if (!empty($mb_user_token_info) && intval($group_id) > 0) {
            $model_order = Model('order');
            $condition = array();
            $condition['goods_type'] = 2;
            $condition['promotions_id'] = $group_id;
            $condition['buyer_id'] = $mb_user_token_info['member_id'];
            $order_goods_list = $model_order->getOrderGoodsList($condition, '*', 0, $this->page);
            if (!empty($order_goods_list)) {
                $order_id_array = array();
                foreach ($order_goods_list as $value) {
                    $order_id_array[] = $value['order_id'];
                }
                $order_list = $model_order->getNormalOrderList(array('order_id' => array('in', $order_id_array)));
                if (!empty($order_list)) return true;
            }
        }
        return false;
    }

}