<?php
/**
 * 首页
 *
 *
 *
 
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
class indexControl extends mobileHomeControl{

	public function __construct() {
        parent::__construct();
    }

    /**
     * 首页
     */
	public function indexOp() {
        //进入此版主页时，跳转到wap目录下的手机站点
        //redirect('/wap');
        //以下为原本的代码
        $model_mb_special = Model('mb_special'); 
        $data = $model_mb_special->getMbSpecialIndex();
        $this->_output_special($data, $_GET['type']);
	}

    /**
     * 专题
     */
	public function specialOp() {
        $model_mb_special = Model('mb_special'); 
        $data = $model_mb_special->getMbSpecialItemUsableListByID($_GET['special_id']);
        $this->_output_special($data, $_GET['type'], $_GET['special_id']);
	}

    /**
     * 输出专题
     */
    private function _output_special($data, $type = 'json', $special_id = 0) {
        $model_special = Model('mb_special');
        if($type == 'html') {
            $html_path = $model_special->getMbSpecialHtmlPath($special_id);
            if(!is_file($html_path)) {
                ob_start();
                Tpl::output('list', $data);
                Tpl::showpage('mb_special');
                file_put_contents($html_path, ob_get_clean());
            }
            header('Location: ' . $model_special->getMbSpecialHtmlUrl($special_id));
            die;
        } else {
            //猜你喜欢
            $model_mb_user_token = Model('mb_user_token');
            $key = $_POST['key'];
            if(empty($key)) {
                $key = $_GET['key'];
            }
            $mb_user_token_info = $model_mb_user_token -> getMbUserTokenInfoByToken($key);

            $model_browse = Model('goods_browse');
            $field_goods = 'goods_id,goods_commonid,store_id,goods_name,goods_price,goods_image';
            $guess_list = $model_browse -> getGuessLikeGoods($mb_user_token_info['member_id'], $this->page, $field_goods);

            $guess_list = $this->_goods_list_extend($guess_list);
            $data['guess_list'] = $guess_list;

            output_data($data);
        }
    }

    /**
     * android客户端版本号
     */
    public function apk_versionOp() {
        $model_setting = Model('setting');
		$mobile_apk = $model_setting->getRowSetting('mobile_apk');
        $mobile_apk_version = $model_setting->getRowSetting('mobile_apk_version');
        $mobile_version_info = $model_setting->getRowSetting('mobile_version_info');

        $data = array(
            'url' => $mobile_apk['value'],
            'info' => $mobile_version_info['value'],
            'version' => $mobile_apk_version['value']
        );
        $data['if_update'] = $mobile_apk_version['value'] !== $_GET['version'];

        output_json(1, $data);
    }

    /**
     * 处理商品列表(抢购、限时折扣、商品图片、产地)
     */
    private function _goods_list_extend($goods_list) {
        //获取商品列表编号数组
        $commonid_array = array();
        $goodsid_array = array();
        foreach($goods_list as $key => $value) {
            $commonid_array[] = $value['goods_commonid'];
            $goodsid_array[] = $value['goods_id'];
        }

        //促销
        $groupbuy_list = Model('groupbuy')->getGroupbuyListByGoodsCommonIDString(implode(',', $commonid_array));
        $xianshi_list = Model('p_xianshi_goods')->getXianshiGoodsListByGoodsString(implode(',', $goodsid_array));
        foreach ($goods_list as $key => $value) {
            //抢购
            if (isset($groupbuy_list[$value['goods_commonid']])) {
                $goods_list[$key]['goods_price'] = $groupbuy_list[$value['goods_commonid']]['groupbuy_price'];
            }

            //限时折扣
            if (isset($xianshi_list[$value['goods_id']]) && !$goods_list[$key]['group_flag']) {
                $goods_list[$key]['goods_price'] = $xianshi_list[$value['goods_id']]['xianshi_price'];
            }

            //商品图片url
            $goods_list[$key]['goods_image_url'] = cthumb($value['goods_image'], 360, $value['store_id']);

            //产地
            $goods_list[$key]['origin'] = $this->_goods_origin($value['goods_id']);

            unset($goods_list[$key]['store_id']);
            unset($goods_list[$key]['goods_commonid']);
            unset($goods_list[$key]['nc_distinct']);
        }

        return $goods_list;
    }

    /**
     * 获取商品产地
     *
     * @author Liao
     */
    public function _goods_origin($goods_id) {
        $origin_name = '';
        $condition['goods_id'] = $goods_id;
        $condition['attr_id'] = array('between', '266,277');
        $goods_attr_list = Model('goods_attr_index')->getGoodsAttrIndexList($condition, 'attr_value_id');
        if(!empty($goods_attr_list)) {
            $attr_name_array = Model('attribute')->getAttributeValueList($goods_attr_list[0], 'attr_value_name');
            $origin_name = $attr_name_array[0]['attr_value_name'];
        }
        return $origin_name;
    }

}
