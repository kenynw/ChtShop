<?php
/**
 * 商品
 *
 * by abc.com 多用户商城
 *
 *
 */
//by abc.com
//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
class goodsControl extends mobileHomeControl{

	public function __construct() {
        parent::__construct();
    }

    /**
     * 商品列表
     */
    public function goods_listOp() {
        $model_goods = Model('goods');
        $model_search = Model('search');

        //查询条件
        $condition = array();
        if(!empty($_GET['gc_id']) && intval($_GET['gc_id']) > 0) {
            $condition['gc_id'] = $_GET['gc_id'];
        } elseif (!empty($_GET['keyword'])) {
            $condition['goods_name|goods_jingle'] = array('like', '%' . $_GET['keyword'] . '%');
        }
        $condition['goods_commend'] = intval(empty($_GET['commend']) ? $_POST['commend'] : $_GET['commend']);

        //所需字段
        $fieldstr = "goods_id,goods_commonid,store_id,goods_name,goods_commend,goods_price,goods_marketprice,goods_image,goods_salenum,evaluation_good_star,evaluation_count";

        // 添加3个状态字段
        $fieldstr .= ',is_virtual,is_presell,is_fcode,have_gift';

        //排序方式
        $order = $this->_goods_list_order($_GET['key'], $_GET['order']);

        //优先从全文索引库里查找
        list($indexer_ids,$indexer_count) = $model_search->indexerSearch($_GET,$this->page);
        if (is_array($indexer_ids)) {
            //商品主键搜索
            $goods_list = $model_goods->getGoodsOnlineList(array('goods_id'=>array('in',$indexer_ids)), $fieldstr, 0, $order, $this->page, null, false);

            //如果有商品下架等情况，则删除下架商品的搜索索引信息
            if (count($goods_list) != count($indexer_ids)) {
                $model_search->delInvalidGoods($goods_list, $indexer_ids);
            }
            pagecmd('setEachNum',$this->page);
            pagecmd('setTotalNum',$indexer_count);
        } else {
            $goods_list = $model_goods->getGoodsListByColorDistinct($condition, $fieldstr, $order, $this->page);
        }
        $page_count = $model_goods->gettotalpage();

        //处理商品列表(抢购、限时折扣、商品图片、产地)
        $goods_list = $this->_goods_list_extend($goods_list);

        output_json(1, array('list' =>$goods_list), 'SUCCESS', mobile_page($page_count));
    }

    /**
     * 商品列表排序方式
     */
    private function _goods_list_order($key, $order) {
        $result = 'is_own_shop desc,goods_id desc';
        if (!empty($key)) {

            $sequence = 'desc';
            if($order == 1) {
                $sequence = 'asc';
            }

            switch ($key) {
                //销量
                case '1' :
                    $result = 'goods_salenum' . ' ' . $sequence;
                    break;
                //浏览量
                case '2' :
                    $result = 'goods_click' . ' ' . $sequence;
                    break;
                //价格
                case '3' :
                    $result = 'goods_price' . ' ' . $sequence;
                    break;
            }
        }
        return $result;
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
                $goods_list[$key]['group_flag'] = true;
            } else {
                $goods_list[$key]['group_flag'] = false;
            }

            //限时折扣
            if (isset($xianshi_list[$value['goods_id']]) && !$goods_list[$key]['group_flag']) {
                $goods_list[$key]['goods_price'] = $xianshi_list[$value['goods_id']]['xianshi_price'];
                $goods_list[$key]['xianshi_flag'] = true;
            } else {
                $goods_list[$key]['xianshi_flag'] = false;
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
     * 获取试茶师推荐列表
     *
     * @author Liao
     */
    public function recommend_listOp() {
        $condition = array();
        if(!empty($_GET['gc_id']) && intval($_GET['gc_id']) > 0) {
            $condition['gc_id'] = $_GET['gc_id'];
        }

        $fields = 'goods_id,goods_name,goods_image,goods_price,goods_promotion_price,goods_marketprice,goods_promotion_type,store_id,recommend_score,recommend_taste,recommend_light,recommend_aroma,recommend_leaf';

        $order = $this->_goods_list_order($_GET['key'], $_GET['order']);

        $model_goods = Model('goods');

        $goods_list = $model_goods -> getGoodsTastersList($condition, $fields, $order, $this->page);

        //处理商品列表(抢购、限时折扣、商品图片、产地)
        $goods_list = $this->_goods_list_extend($goods_list);

        $page_count = Model('tasters_recommends')->gettotalpage();

        output_json(1, array('list' => $goods_list), 'SUCCESS', mobile_page($page_count));
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

    /**
     * 商品详细页
     */
    public function goods_detailOp() {
        $goods_id = intval($_GET ['goods_id']);
        $version = intval($_GET['version']);

        // 商品详细信息
        $model_goods = Model('goods');
        $goods_detail = $model_goods->getGoodsDetail($goods_id);
		 
        if (empty($goods_detail)) {
            output_error('商品不存在');
        }

        if ($version >= 3) {
            $this->_goods_detail_v3();
        }

		 //添加浏览记录
        $model_mb_user_token = Model('mb_user_token');
        $key = $_POST['key'];
        if (empty($key)) $key = $_GET['key'];
        if (empty($key)) $_COOKIE['key'];
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        $member_id=$mb_user_token_info['member_id'];
        $model_member = Model('member');
        $member_info=$model_member->getMemberInfoByID($member_id);
        if(empty($member_info)){
            $seller_info = Model('seller')->getSellerInfo(array('member_id'=>$member_id));
            $store_id= $seller_info['store_id'];
        }
        $store_id=isset($store_id)? $store_id:0;
        Model('goods_browse')->addViewedGoods($goods_id,$member_id,$store_id);
        //end 浏览记录

        //推荐商品
        $model_store = Model('store');
        $hot_sales = $model_store->getHotSalesList($goods_detail['goods_info']['store_id'], 6);
        $goods_commend_list = array();
        foreach($hot_sales as $value) {
            $goods_commend = array();
            $goods_commend['goods_id'] = $value['goods_id'];
            $goods_commend['goods_name'] = $value['goods_name'];
            $goods_commend['goods_price'] = $value['goods_price'];
            $goods_commend['goods_image_url'] = cthumb($value['goods_image'], 240);
            $goods_commend_list[] = $goods_commend;
        }
        $goods_detail['goods_commend_list'] = $goods_commend_list;
        $store_info = $model_store->getStoreInfoByID($goods_detail['goods_info']['store_id']);
        $goods_detail['store_info']['store_id'] = $store_info['store_id'];
        $goods_detail['store_info']['store_name'] = $store_info['store_name'];
        $goods_detail['store_info']['member_id'] = $store_info['member_id'];
    	//显示QQ及旺旺 多用户商城
    	$goods_detail['store_info']['store_qq'] = $store_info['store_qq'];
	   $goods_detail['store_info']['store_ww'] = $store_info['store_ww'];
	   $goods_detail['store_info']['store_phone'] = $store_info['store_phone'];
        $goods_detail['store_info']['member_name'] = $store_info['member_name'];
        $goods_detail['store_info']['avatar'] = getMemberAvatarForID($store_info['member_id']);

        //商品详细信息处理
        $goods_detail = $this->_goods_detail_extend($goods_detail);
        if($_GET['version']){
            output_json(1,$goods_detail,'查询完成');
            die;
        }
        output_data($goods_detail);
    }

    /**
     * 商品详细信息处理
     */
    private function _goods_detail_extend($goods_detail) {
        //整理商品规格
        unset($goods_detail['spec_list']);
        $goods_detail['spec_list'] = $goods_detail['spec_list_mobile'];
        unset($goods_detail['spec_list_mobile']);

        //整理商品图片
        unset($goods_detail['goods_image']);
        $goods_detail['goods_image'] = implode(',', $goods_detail['goods_image_mobile']);
        unset($goods_detail['goods_image_mobile']);

        //商品链接
        $goods_detail['goods_info']['goods_url'] = urlShop('goods', 'index', array('goods_id' => $goods_detail['goods_info']['goods_id']));

        //整理数据
		/*yancang447*/
		 $goods_id = intval($_GET ['goods_id']);
		 $array=array(101344,101345,101355,101356,101456);
		 if(in_array($goods_id,$array)){
			 //print_r($goods_detail);
			 $goods_detail['goods_info']['goods_price']='';
			 $goods_detail['goods_info']['goods_promotion_price']='';
			 $goods_detail['goods_info']['goods_marketprice']='';
			 $goods_detail['goods_info']['promotion_price']='';
			 }		 
		 /*yacang447*/
        unset($goods_detail['goods_info']['goods_commonid']);
        unset($goods_detail['goods_info']['gc_id']);
        unset($goods_detail['goods_info']['gc_name']);
        unset($goods_detail['goods_info']['store_name']);
        unset($goods_detail['goods_info']['brand_id']);
        unset($goods_detail['goods_info']['brand_name']);
        unset($goods_detail['goods_info']['type_id']);
        unset($goods_detail['goods_info']['goods_image']);
        unset($goods_detail['goods_info']['goods_body']);
        unset($goods_detail['goods_info']['goods_state']);
        unset($goods_detail['goods_info']['goods_stateremark']);
        unset($goods_detail['goods_info']['goods_verify']);
        unset($goods_detail['goods_info']['goods_verifyremark']);
        unset($goods_detail['goods_info']['goods_lock']);
        unset($goods_detail['goods_info']['goods_addtime']);
        unset($goods_detail['goods_info']['goods_edittime']);
        unset($goods_detail['goods_info']['goods_selltime']);
        unset($goods_detail['goods_info']['goods_show']);
        unset($goods_detail['goods_info']['goods_commend']);
        unset($goods_detail['goods_info']['explain']);
        unset($goods_detail['goods_info']['cart']);
        unset($goods_detail['goods_info']['buynow_text']);
        unset($goods_detail['groupbuy_info']);
        unset($goods_detail['xianshi_info']);

        return $goods_detail;
    }

    /**
     * 商品详细页
     */
    public function goods_bodyOp() {
        $goods_id = intval($_GET ['goods_id']);

        $model_goods = Model('goods');

        $goods_info = $model_goods->getGoodsInfoByID($goods_id, 'goods_commonid');
        $goods_common_info = $model_goods->getGoodeCommonInfoByID($goods_info['goods_commonid']);

        Tpl::output('goods_common_info', $goods_common_info);
        Tpl::showpage('goods_body');
    }
	/**
     * 手机商品详细页
     *
     */
	public function wap_goods_bodyOp() {
        $goods_id = intval($_GET ['goods_id']);

        $model_goods = Model('goods');

        $goods_info =$model_goods->getGoodsInfoByID($goods_id, 'goods_id');
        $goods_common_info =$model_goods->getMobileBodyByCommonID($goods_info['goods_commonid']);
        Tpl:output('goods_common_info',$goods_common_info);
        Tpl::showpage('goods_body');
    }

    /**
     * 商品详情接口
     * @author Lai
     */
    private function _goods_detail_v3() {
        $goods_id = intval($_GET ['goods_id']);

        // 商品详细信息
        $model_goods = Model('goods');
        $goods_detail = $model_goods->getGoodsDetail($goods_id);

        if (empty($goods_detail)) {
            output_error('商品不存在');
        }

        //添加浏览记录
        $model_mb_user_token = Model('mb_user_token');
        $key = $_POST['key'];
        if (empty($key)) $key = $_GET['key'];
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        $member_id=$mb_user_token_info['member_id'];
        $model_member = Model('member');
        $member_info=$model_member->getMemberInfoByID($member_id);
        if(empty($member_info)){
            $seller_info = Model('seller')->getSellerInfo(array('member_id'=>$member_id));
            $store_id= $seller_info['store_id'];
        }
        $store_id=isset($store_id)? $store_id:0;
        Model('goods_browse')->addViewedGoods($goods_id,$member_id,$store_id);

        //商品详细信息处理
        $goods_detail = $this->_goods_detail_extend($goods_detail);

        //商品规格
        $spec_list = array();
        if (is_array($goods_detail['goods_info']['spec_name'])) {
            $spec = array();
            foreach($goods_detail['goods_info']['spec_name'] as $key => $value){
                $spec['spec_name'] = $value;

                if (is_array($goods_detail['goods_info']['spec_value'][$key]) && !empty($goods_detail['goods_info']['spec_value'][$key])) {
                    foreach($goods_detail['goods_info']['spec_value'][$key] as $k => $v) {
                        if($key !== 1) {
                            $spec['spec_value'][] = array(
                                'spec_value_text' => $v,
                                'goods_id' => $goods_detail['spec_list'][$k]);
                        }
                    }
                }
                $spec_list[] = $spec;
            }
        }

        $goods_detail['goods_info']['spec_value']=$spec_list;

        if (is_array($goods_detail['goods_info']['goods_spec'])) {
            $goods_detail['goods_info']['goods_spec'] = reset($goods_detail['goods_info']['goods_spec']);
        }

        $goods_attr=array();
        foreach($goods_detail['goods_info']['goods_attr'] as $value){
            $value=array_values($value);
            // $goods_attr[]=$value[0].','.$value[1];
            $goods_attr[]=array("attr_name"=>$value[0],"attr_value"=>$value[1]);
        }
        $goods_detail['goods_info']['goods_attr']=$goods_attr;

        // 是否收藏
        $model_mb_user_token = Model('mb_user_token');
        $key = empty($_GET['key']) ? $_POST['key'] : $_GET['key'];
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        if(!empty($mb_user_token_info)) {
            $model_favorite = Model('favorites');
            $goods_detail['goods_info']['is_favorite'] = $model_favorite->checkFavorites($goods_detail['goods_info']['goods_id'], 'goods', $mb_user_token_info['member_id']);
        }

        unset($goods_detail['goods_info']['spec_name']);
        unset($goods_detail['spec_list']);

        output_json(1,$goods_detail);
    }

    /**
     * 搜索热词
     */
    public function hot_searchOp() {
        $keywords_list = explode(',', C('hot_search'));
        output_json(1, $keywords_list);
    }

    /**
     * 商品评价列表
     */
    public function comments_listOp() {
        $goods_id  = intval($_GET['goods_id']);

        $model_evaluate_goods = Model('evaluate_goods');

        $condition  = array();
        $condition['geval_goodsid'] = $goods_id;
        $condition['geval_state'] = 0;

        $field = 'geval_id,geval_goodsid,geval_goodsname,geval_content,geval_isanonymous,geval_addtime,geval_frommemberid,geval_frommembername,geval_state,geval_image';

        $evaluate_list = $model_evaluate_goods->getEvaluateGoodsList($condition, $this->page, 'geval_id desc', $field);

        foreach ($evaluate_list as $key => $value) {
            $evaluate_list[$key]['geval_frommemberavatar'] = getMemberAvatarForID($value['geval_frommemberid']);
            $evaluate_list[$key]['add_time_text'] = date('Y-m-d H:i', $value['geval_addtime']);

            if ($value['geval_isanonymous'] == 1) {
                $evaluate_list[$key]['geval_frommembername'] = str_cut($value['geval_frommembername'],2).'***';
            }

            // 删除没用的字段,节省网络资源
            unset($evaluate_list[$key]['geval_isanonymous']);
            unset($evaluate_list[$key]['geval_addtime']);
            unset($evaluate_list[$key]['geval_frommemberid']);
            unset($evaluate_list[$key]['geval_isanonymous']);
        }

        $page_count = $model_evaluate_goods->gettotalpage();

        output_json(1, array('list' => $evaluate_list), 'SUCCESS', mobile_page($page_count));
    }

    /**
     * app请求商品详细接口
     * @author Lai
     */
    public function goods_detail_apiOp() {
        $goods_id = intval($_GET ['goods_id']);

        // 商品详细信息
        $model_goods = Model('goods');
        $goods_detail = $model_goods->getGoodsDetail($goods_id);
        if (empty($goods_detail)) {
            output_error('商品不存在');
        }
        //添加浏览记录
        $model_mb_user_token = Model('mb_user_token');
        $key = $_POST['key'];
        if (empty($key)) $key = $_GET['key'];
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        $member_id=$mb_user_token_info['member_id'];
        $model_member = Model('member');
        $member_info=$model_member->getMemberInfoByID($member_id);
        if(empty($member_info)){
            $seller_info = Model('seller')->getSellerInfo(array('member_id'=>$member_id));
            $store_id= $seller_info['store_id'];
        }
        $store_id=isset($store_id)? $store_id:0;
        Model('goods_browse')->addViewedGoods($goods_id,$member_id,$store_id);
        //end 浏览记录

        //推荐商品
        $model_store = Model('store');
        $hot_sales = $model_store->getHotSalesList($goods_detail['goods_info']['store_id'], 6);
        $goods_commend_list = array();
        foreach($hot_sales as $value) {
            $goods_commend = array();
            $goods_commend['goods_id'] = $value['goods_id'];
            $goods_commend['goods_name'] = $value['goods_name'];
            $goods_commend['goods_price'] = $value['goods_price'];
            $goods_commend['goods_image_url'] = cthumb($value['goods_image'], 240);
            $goods_commend_list[] = $goods_commend;
        }
        $goods_detail['goods_commend_list'] = $goods_commend_list;
        $store_info = $model_store->getStoreInfoByID($goods_detail['goods_info']['store_id']);
        $goods_detail['store_info']['store_id'] = $store_info['store_id'];
        $goods_detail['store_info']['store_name'] = $store_info['store_name'];
        $goods_detail['store_info']['member_id'] = $store_info['member_id'];
        //显示QQ及旺旺 多用户商城
        $goods_detail['store_info']['store_qq'] = $store_info['store_qq'];
        $goods_detail['store_info']['store_ww'] = $store_info['store_ww'];
        $goods_detail['store_info']['store_phone'] = $store_info['store_phone'];
        $goods_detail['store_info']['member_name'] = $store_info['member_name'];
        $goods_detail['store_info']['avatar'] = getMemberAvatarForID($store_info['member_id']);
        //商品详细信息处理
        $goods_detail = $this->_goods_detail_extend($goods_detail);
        //add by lai 去除spec_value  spec_name 键值 java oc 没办法处理 <<
        if (!empty($goods_detail['goods_info']['spec_value']) && is_array($goods_detail['goods_info']['spec_value'])) {
            $spec_array=array();
            foreach($goods_detail['goods_info']['spec_value'] as $key=>$value){
                foreach($value as $k=>$v){
                    //$spec_array[]=$goods_detail['goods_info']['spec_name'][$key].','.$v.','.$goods_detail['spec_list'][$k];
                    $spec_array[]=array("spec_name"=>$goods_detail['goods_info']['spec_name'][$key],"spec_value"=>$v,"goods_id"=>$goods_detail['spec_list'][$k]);
                }
            }
            $goods_detail['goods_info']['spec_value']=$spec_array;
        }
        $goods_attr=array();
        foreach($goods_detail['goods_info']['goods_attr'] as $value){
            $value=array_values($value);
               // $goods_attr[]=$value[0].','.$value[1];
            $goods_attr[]=array("attr_name"=>$value[0],"attr_value"=>$value[1]);
        }
        $goods_detail['goods_info']['goods_attr']=$goods_attr;
        //商品评价
        $evaluate_contion=array();
        $evaluate_contion['geval_goodsid']=$goods_id;
        $goods_evaluate_info = Model('evaluate_goods')->getEvaluateGoodsList($evaluate_contion,null,'geval_id desc',"geval_scores,geval_content,geval_isanonymous,geval_frommembername");
        $goods_detail['goods_evaluate_info']=$goods_evaluate_info;
        //print_r($goods_detail);
        //add by lai 去除spec_value  spec_name 键值 java oc 没办法处理 >>

        // 是否收藏
        $model_mb_user_token = Model('mb_user_token');
        $key = empty($_GET['key']) ? $_POST['key'] : $_GET['key'];
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        if(!empty($mb_user_token_info)) {
            $model_favorite = Model('favorites');
            $goods_detail['is_favorite'] = $model_favorite->checkFavorites($goods_detail['goods_info']['goods_id'], 'goods', $mb_user_token_info['member_id']);
        }

        output_json(1,$goods_detail);
    }

}
