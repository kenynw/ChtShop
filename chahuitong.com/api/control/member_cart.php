<?php
/**
 * 我的购物车
 *
 *
 *
 *

 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class member_cartControl extends mobileMemberControl
{

    public function __construct() {
        parent::__construct();
    }

    /**
     * 购物车列表
     */
    public function cart_listOp() {
        $model_cart = Model('cart');

        $condition = array('buyer_id' => $this->member_info['member_id']);
        $cart_list = $model_cart->listCart('db', $condition);
        $sum = 0;
        foreach ($cart_list as $key => $value) {
            $cart_list[$key]['goods_image_url'] = cthumb(
                $value['goods_image'], $value['store_id']
            );
            $cart_list[$key]['goods_sum'] = ncPriceFormat(
                $value['goods_price'] * $value['goods_num']
            );
            $sum += $cart_list[$key]['goods_sum'];
        }

        output_data(
            array('cart_list' => $cart_list, 'sum' => ncPriceFormat($sum))
        );
    }

    /**
     * 购物车添加
     */
    public function cart_addOp() {

        $goods_id = intval($_POST['goods_id']);
        $quantity = intval($_POST['quantity']);
        if ($goods_id <= 0 || $quantity <= 0) {
            output_error('参数错误');
        }

        $model_goods = Model('goods');
        $model_cart = Model('cart');
        $logic_buy_1 = Logic('buy_1');

        $goods_info = $model_goods->getGoodsOnlineInfoAndPromotionById(
            $goods_id
        );

        //验证是否可以购买
        if (empty($goods_info)) {
            output_error('商品已下架或不存在');
        }
        //add by lai 验证是否是免费茶样 <<
        if ($goods_info['is_goods_sample']) {
            $goodsSampleModel = Model("goods_sample");
            $goodsSampleInfo = $goodsSampleModel->where(
                "sample_link='" . $goods_info['goods_id'] . "'"
            )->find();
            if (!empty($goodsSampleInfo)) {
                //是否是正在进行茶样
                if (TIMESTAMP < $goodsSampleInfo["sample_start_time"]) {
                    if (isset($_POST['version'])) {
                        output_json(0, '', '免费茶样还未开始');
                        die();
                    } else {
                        output_error('免费茶样还未开始');
                    }
                }
                if (TIMESTAMP > $goodsSampleInfo["sample_end_time"]) {
                    if (isset($_POST['version'])) {
                        output_json(0, '', '免费茶样已经结束');
                        die();
                    } else {
                        output_error('免费茶样已经结束');
                    }
                }
                //是否已经领取过了
                $sql
                    = "select gs.goods_id,o.add_time from shopnc_order_goods as gs left join shopnc_order as o on gs.order_id=o.order_id where gs.goods_id=$goods_id and o.add_time>"
                    . $goodsSampleInfo["sample_start_time"] . " and o.add_time<"
                    . $goodsSampleInfo["sample_end_time"] . " and o.buyer_id='"
                    . $this->member_info['member_id'] . "'";
                $model = Model();
                $result = $model->query($sql);
                if ($result) {
                    if (isset($_POST['version'])) {
                        output_json(0, '', '您已经领取了免费茶样');
                        die();
                    } else {
                        output_error('您已经领取了免费茶样');
                    }
                }

            }

        }

        //end 验证免费茶样>>


        //抢购
        $logic_buy_1->getGroupbuyInfo($goods_info);

        //限时折扣
        $logic_buy_1->getXianshiInfo($goods_info, $quantity);

        if ($goods_info['store_id'] == $this->member_info['store_id']) {
            output_error('不能购买自己发布的商品');
        }
        if (intval($goods_info['goods_storage']) < 1
            || intval(
                $goods_info['goods_storage']
            ) < $quantity
        ) {
            output_error('库存不足');
        }

        $param = array();
        $param['buyer_id'] = $this->member_info['member_id'];
        $param['store_id'] = $goods_info['store_id'];
        $param['goods_id'] = $goods_info['goods_id'];
        $param['goods_name'] = $goods_info['goods_name'];
        $param['goods_price'] = $goods_info['goods_price'];
        $param['goods_image'] = $goods_info['goods_image'];
        $param['store_name'] = $goods_info['store_name'];

        $result = $model_cart->addCart($param, 'db', $quantity);
        if ($result) {
            if (isset($_POST['version'])) {
                output_json(1, '', '购物车加入完成');
                die();
            }
            output_data('1');
        } else {
            if (isset($_POST['version'])) {
                output_json(0, '', '购物车加入失败');
                die();
            }
            output_error('购物车加入失败');
        }
    }

    /**
     * 购物车删除
     */
    public function cart_delOp() {
        $cart_id = trim($_POST['cart_id'], ',');
        $cart_arr = explode(',', $cart_id);
        if (!empty($cart_id) && is_array($cart_arr)) {
            $model_cart = Model('cart');
            $condition = array();
            $condition['buyer_id'] = $this->member_info['member_id'];
            $condition['cart_id'] = array('in', $cart_arr);

            $model_cart->delCart('db', $condition);

            output_json(1, true);
        } else output_json(0, false, '参数错误');
    }

    //放回购物车函数
    public function cart_againOp() {
        $cart_id = intval($_POST['cart_id']);
        if ($cart_id > 0) {
            $condition = array();
            $condition['buyer_id'] = $this->member_info['member_id'];
            $condition['cart_id'] = $cart_id;
            //add by lai
            $cart_cache = Model();
            $sql
                = "insert into shopnc_cart select * from shopnc_cart_cache where cart_id='$cart_id' and buyer_id='{$condition['buyer_id']}'";
            $sql1
                = "delete from shopnc_cart_cache where cart_id='$cart_id' and buyer_id='{$condition['buyer_id']}'";
            @$cart_cache->query($sql);
            @$cart_cache->query($sql1);
            //end
            //$model_cart->delCart('db', $condition);

        }
        output_data('1');

    }

    /**
     * 更新购物车购买数量
     */
    public function cart_edit_quantityOp() {
        $cart_id = intval(abs($_POST['cart_id']));
        $quantity = intval(abs($_POST['quantity']));
        if (empty($cart_id) || empty($quantity)) {
            output_error('参数错误');
        }

        $model_cart = Model('cart');

        $cart_info = $model_cart->getCartInfo(
            array(
                'cart_id' => $cart_id,
                'buyer_id' => $this->member_info['member_id']
            )
        );

        //检查是否为本人购物车
        if ($cart_info['buyer_id'] != $this->member_info['member_id']) {
            output_error('参数错误');
        }

        //检查库存是否充足
        if (!$this->_check_goods_storage(
            $cart_info, $quantity, $this->member_info['member_id']
        )
        ) {
            output_error('库存不足');
        }

        $data = array();
        $data['goods_num'] = $quantity;
        $update = $model_cart->editCart(
            $data, array(
            'cart_id' => $cart_id, 'buyer_id' => $this->member_info['member_id']
        )
        );
        if ($update) {
            $return = array();
            $return['quantity'] = $quantity;
            $return['goods_price'] = ncPriceFormat($cart_info['goods_price']);
            $return['total_price'] = ncPriceFormat(
                $cart_info['goods_price'] * $quantity
            );
            $return['sum'] = $model_cart->cart_all_price;
            output_data($return);
        } else {
            output_error('修改失败');
        }
    }

    /**
     * 移动到收藏夹
     */
    public function move_favoritesOp() {
        $cart_id = trim($_POST['cart_id'], ',');
        $cart_arr = explode(',', $cart_id);
        if (!empty($cart_id) && is_array($cart_arr)) {
            $model_cart = Model('cart');
            $condition = array();
            $condition['buyer_id'] = $this->member_info['member_id'];
            $condition['cart_id'] = array('in', $cart_arr);
            $cart_list = $model_cart->listCart('db', $condition);
            if (empty($cart_list)) {
                output_json(0, false, '获取数据出错');
            }

            $result = $model_cart->delCart('db', $condition);
            if ($result) {
                $model_fav = Model('favorites');

                $condition = array();
                $condition['member_id'] = $this->member_info['member_id'];
                $condition['fav_type'] = 'goods';
                $condition['fav_time'] = TIMESTAMP;
                foreach ($cart_list as $key => $value) {
                    if (!$model_fav->checkFavorites(
                        $value['goods_id'], 'goods',
                        $this->member_info['member_id']
                    )
                    ) {
                        $condition['fav_id'] = $value['goods_id'];
                        $model_fav->addFavorites($condition);
                    }
                }
                output_json(1, true);

            } else {
                output_json(0, false);
            }
        } else {
            output_json(0, false, '参数错误');
        }

    }

    /**
     * 检查库存是否充足
     */
    private function _check_goods_storage($cart_info, $quantity, $member_id) {
        $model_goods = Model('goods');
        $model_bl = Model('p_bundling');
        $logic_buy_1 = Logic('buy_1');

        if ($cart_info['bl_id'] == '0') {
            //普通商品
            $goods_info = $model_goods->getGoodsOnlineInfoAndPromotionById(
                $cart_info['goods_id']
            );

            //抢购
            $logic_buy_1->getGroupbuyInfo($goods_info);

            //限时折扣
            $logic_buy_1->getXianshiInfo($goods_info, $quantity);

            $quantity = $goods_info['goods_num'];
            if (intval($goods_info['goods_storage']) < $quantity) {
                return false;
            }
        } else {
            //优惠套装商品
            $bl_goods_list = $model_bl->getBundlingGoodsList(
                array('bl_id' => $cart_info['bl_id'])
            );
            $goods_id_array = array();
            foreach ($bl_goods_list as $goods) {
                $goods_id_array[] = $goods['goods_id'];
            }
            $bl_goods_list
                = $model_goods->getGoodsOnlineListAndPromotionByIdArray(
                $goods_id_array
            );

            //如果有商品库存不足，更新购买数量到目前最大库存
            foreach ($bl_goods_list as $goods_info) {
                if (intval($goods_info['goods_storage']) < $quantity) {
                    return false;
                }
            }
        }
        return true;
    }

}
