<?php

/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/6/25
 * Time: 下午3:45
 */
class member_fleaControl extends mobileMemberControl
{

    public function __construct() {
        parent::__construct();
    }

    public function indexOp() {
        /**
         * 实例化闲置物品模型
         */
        $model_store_goods = Model('flea');
        /**
         * 闲置分页
         */
        $page = new Page();
        $page->setEachNum($this->page);
        $page->setStyle('admin');
        $search_array['member_id'] = $this->member_info['member_id'];
        $search_array['keyword'] = trim($_GET['keyword']);
        $search_array['order'] = 'goods_id desc';
        $list_goods = $model_store_goods->listGoods($search_array, $page);

        if (is_array($list_goods) and !empty($list_goods)) {
            foreach ($list_goods as $key => $val) {
                $list_goods[$key]['goods_image'] = fleaThumb($val['goods_image']);
                $list_goods[$key]['goods_add_time'] = date('Y.m.d H:i', $val['goods_add_time']);
            }

        }

        $page_count = $page->getTotalPage();
        output_json(1, array('list' => $list_goods), 'SUCCESS', mobile_page($page_count));
    }

    public function flea_listOp() {
        //加载模型
        $flea_model = Model('flea');

        $condition = array();
//        $condition['goods_show'] = 1;
        $condition['pic_input'] = 2;
        $condition['body_input'] = 2;
        $condition['order'] = 'goods_tag desc, goods_click desc, goods_id desc';

        $field = 'goods_id, goods_name, member_id, goods_image, goods_tag, goods_store_price, goods_show, goods_click, goods_commend, goods_add_time, goods_body, flea_pname, flea_pphone';

        $page = new Page();
        $page->setEachNum($this->page);
        $page->setStyle('admin');
        $goods_list = $flea_model->listGoods($condition, $page, $field);
        if ($goods_list) {
            $goods_list = $this->_get_extend_goods($goods_list);
        }

        $page_count = $page->getTotalPage();
        output_json(1, array('list' => $goods_list), 'SUCCESS', mobile_page($page_count));
    }

    public function flea_detailOp() {
        $goods_id = intval(empty($_GET['goods_id']) ? $_POST['goods_id'] : $_GET['goods_id']);
        if ($goods_id <= 0) {
            $member_info = array();
            $member_info['member_id'] = $this->member_info['member_id'];
            $member_info['member_mobile'] = $this->member_info['member_mobile'];
            $member_info['member_truename'] = $this->member_info['member_truename'];
            $member_info['member_areainfo'] = $this->member_info['member_areainfo'];
            output_json(1, $member_info);
        }

        $model_store_goods = Model('flea');
        $condition = array();
        $condition['goods_id'] = $goods_id;
        $condition['goods_show'] = 1;
        $goods_info = $model_store_goods->getGoodsInfo($condition);

        if (empty($goods_info)) {
            output_json(0, $goods_info, Language::get('error_no_goods'));
        }

        // 用户头像处理
        $goods_info['member_avatar'] = getMemberAvatarForID($goods_info['member_id']);
        $goods_info['belong_me'] = $goods_info['member_id'] == $this->member_info['member_id'] ? true : false;

        // 标签处理
        if ($goods_info['goods_tag']) {
            $goods_info['goods_tag'] = str_replace(', ', ' ', $goods_info['goods_tag']);
        }

        // 日期处理
        $goods_info['goods_add_time'] = date('Y-m-d H:i');

        // 描述处理
        $abstract = preg_replace(
            '/<[^>]*>|\s+/', '', $goods_info['goods_body']
        );
        if (!$abstract) {
            $goods_info['goods_body'] = Language::get('flea_no_explain');
        }

        // 是否收藏
        $model_favorites = Model('flea_favorites');
        $goods_info['favorite'] = $model_favorites->checkFavorites($goods_id,'flea',$this->member_info['member_id']);

        /**
         * 商品多图
         */
        $condition = array();
        $condition['image_store_id'] = $goods_info['member_id'];
        $condition['item_id'] = $goods_info['goods_id'];
        $condition['image_type'] = 12;
        $field = 'file_thumb, file_name, store_id, upload_type, item_id';
        $desc_image = $model_store_goods->getListImageGoods($condition, $field);
        if (is_array($desc_image)){
            foreach ($desc_image as $k=>$v) {
                $desc_image[$k]['thumb_small'] 	= fleaThumb($v['file_name']);
                $desc_image[$k]['thumb_mid'] 	= fleaThumb($v['file_name'], '640');
                $desc_image[$k]['thumb_max'] 	= fleaThumb($v['file_name'], '1280');
            }
        }

        if (!empty($desc_image) && is_array($desc_image)) {
            $image_default_key = 0;
            foreach ($desc_image as $key => $val) {
                if ($goods_info['goods_image'] == $val['thumb_small']) {
                    $image_default_key = $key;
                }
            }
            if ($image_default_key > 0) {//将封面图放到第一位显示
                $desc_image_0 = $desc_image[0];
                $desc_image[0] = $desc_image[$image_default_key];
                $desc_image[$image_default_key] = $desc_image_0;
            }

            $goods_info['desc_image'] = $desc_image;
        }

        /**
         * 得到商品咨询信息
         */
        $consult = Model('flea_consult');
        $field
            = 'member_id,consult_id,goods_id,consult_content,consult_addtime,consult_reply,consult_reply_time';
        $consult_list = $consult->getConsultList(
            array('goods_id' => $goods_id, 'order' => 'consult_id desc'), '',
            'seller', $field
        );
        if ($consult_list) {
            foreach ($consult_list as $key => $value) {
                $consult_list[$key]['member_avatar'] = getMemberAvatarForID(
                    $value['member_id']
                );
                $consult_list[$key]['consult_addtime'] = $this->_time_comb(
                    $value['consult_addtime']
                );
            }
        }
        $goods_info['consult_list'] = empty($consult_list) ? array()
            : $consult_list;

        /**
         * 浏览次数更新
         */
        $model_store_goods->updateGoods(
            array('goods_click' => ($goods_info['goods_click'] + 1)), $goods_id
        );

        output_json(1, $goods_info);
    }

    /**
     * 保存闲置物品
     */
    public function save_goodsOp() {
        /**
         * 清除前一天冗余图片数据
         */
        $model_upload = Model('flea_upload');
        $upload_array = array();
        $upload_array['store_id'] = $this->member_info['member_id'];
        $upload_array['upload_type'] = '12';
        $upload_array['item_id'] = '0';
        $upload_array['upload_time_lt'] = time() - 24 * 60 * 60;
        $model_upload->delByWhere($upload_array);
        unset($upload_array);

        if (empty($_POST['goods_name'])) {
            output_json(0, 0, Language::get('error_title_null'));
        }

        /**
         * 实例化店铺商品模型
         */
        $model_store_goods = Model('flea');
        $goods_array = array();
        $goods_array['goods_name'] = $_POST['goods_name'];
        $goods_array['gc_id'] = $_POST['cate_id'];
        $goods_array['gc_name'] = $_POST['cate_name'];
        $goods_array['member_id'] = $this->member_info['member_id'];
        $goods_array['member_name'] = $this->member_info['member_name'];
        $goods_array['flea_pname'] = $_POST['flea_pname'];
        $goods_array['flea_area_id'] = $_POST['area_id'];
        $goods_array['flea_area_name'] = $_POST['area_info'];
        $goods_array['flea_pphone'] = $_POST['flea_pphone'];
        $goods_array['goods_tag'] = $_POST['goods_tag'];
        $goods_array['goods_store_price'] = $_POST['price'];
        $goods_array['goods_show'] = '1';
        $goods_array['goods_commend'] = 0;
        $goods_array['goods_body'] = $_POST['g_body'];
        $goods_array['goods_keywords'] = empty($_POST['seo_keywords'])
            ? $_POST['goods_tag'] : $_POST['seo_keywords'];
        $goods_array['goods_description'] = empty($_POST['seo_description'])
            ? $_POST['goods_name'] . ',' . str_cut($_POST['g_body'], 120)
            : $_POST['seo_description'];
        $state = $model_store_goods->saveGoods($goods_array);
        if ($state) {
            /**
             * 更新闲置物品多图
             */
            $upload_array = array();
            $upload_array['store_id'] = $this->member_info['member_id'];
            $upload_array['item_id'] = '0';
            $upload_array['upload_type_in'] = "'12','13'";
//            $upload_array['upload_id_in']	= "'".implode("','", $_POST['goods_file_id'])."'";
            $model_upload->updatebywhere(
                array('item_id' => $state), $upload_array
            );

            /**
             * 商品封面图片修改
             */
            if (!empty($_POST['goods_file_id'])) {
                $image_info = $model_store_goods->getListImageGoods(
                    array('upload_id' => intval($_POST['goods_file_id']))
                );
                $goods_image = $image_info[0]['file_name'];
                $model_store_goods->updateGoods(
                    array('goods_image' => $goods_image), $state
                );
            }
            output_json(1, $state);
        } else {
            output_json(0, 0, '添加超时,请重试');
        }
    }

    /**
     * 上传图片
     */
    public function image_uploadOp() {
        if ($_POST['upload_id'] != '') {
            $model_store_goods = Model('flea');
            $model_store_goods->dropImageGoods(
                array('upload_id' => intval($_POST['upload_id']))
            );
        }

        /**
         * 上传图片
         */
        $upload = new UploadFile();
        $upload_dir = ATTACH_MALBUM . DS . $this->member_info['member_id'] . DS;
        $upload->set('default_dir', $upload_dir . $upload->getSysSetPath());
        $thumb_width = '240,640,1280';
        $thumb_height = '2048,1048,1280';
        $upload->set('max_size', C('image_max_filesize'));
        $upload->set('thumb_width', $thumb_width);
        $upload->set('thumb_height', $thumb_height);
        $upload->set('fprefix', $this->member_info['member_id']);
        $upload->set('thumb_ext', '_240,_640,_1280');

        $result = $upload->upfile('image');
        if ($result) {
            $_POST['pic'] = $upload->getSysSetPath() . $upload->file_name;
            $_POST['pic_thumb'] = $upload->getSysSetPath()
                . $upload->thumb_image;
        } else {
            output_json(0, array(), '图片上传失败');
        }

        /**
         * 图片数据入库
         */
        $model_upload = Model('flea_upload');
        $insert_array = array();
        $insert_array['file_name'] = $_POST['pic'];
        $insert_array['file_thumb'] = $_POST['pic_thumb'];
        $insert_array['file_size'] = intval($_FILES['image']['size']);
        $insert_array['upload_time'] = time();
        $insert_array['item_id'] = intval($_POST['item_id']);
        $insert_array['store_id'] = $this->member_info['member_id'];
        $insert_array['upload_type'] = 12;
        $insert_array['upload_id'] = $model_upload->add($insert_array);

        output_json(1, $insert_array);
    }

    /**
     * 删除闲置物品
     */
    public function drop_goodsOp() {

        /**
         * 检查商品是否属于店铺
         */
        $goods_id = trim(
            empty($_POST['goods_id']) ? $_GET['goods_id'] : $_POST['goods_id']
        );
        if (empty($goods_id)) {
            output_json(0, false, Language::get('wrong_argument'));
        }

        /**
         * 实例化闲置物品模型
         */
        $model_store_goods = Model('flea');
        //统计确认的数量
        $para = array();
        $para['member_id'] = $this->member_info['member_id'];
        $para['goods_id'] = $goods_id;
        $goods_info = $model_store_goods->getGoodsInfo($para);
        if (empty($goods_info)) {
            output_json(0, false, '商品不存在');
        }

        $state = $model_store_goods->dropGoods(
            $goods_id, $this->member_info['member_id']
        );
        if ($state) {
            output_json(1, $state, '删除成功');
        } else {
            output_json(0, false, '删除失败');
        }
    }

    /**
     * 删除闲置物品
     */
    public function drop_ImageOp() {
        /**
         * 检查商品是否属于店铺
         */
        $upload_id = trim(
            empty($_POST['upload_id']) ? $_GET['upload_id']
                : $_POST['upload_id']
        );
        if (empty($upload_id)) {
            output_json(0, false, Language::get('wrong_argument'));
        }

        /**
         * 实例化闲置物品模型
         */
        $model_store_goods = Model('flea');
        $state = $model_store_goods->dropImageGoods(
            array('upload_id' => $upload_id)
        );

        if ($state) {
            output_json(1, $state, '删除成功');
        } else {
            output_json(0, false, '删除失败');
        }
    }

    /**
     * 编辑闲置物品保存
     */
    public function edit_goodsOp() {
        $goods_id = intval($_POST['goods_id']);

        if (empty($_POST['goods_name'])) {
            output_json(0, 0, Language::get('error_title_null'));
        }

        /**
         * 实例化闲置物品模型
         */
        $model_store_goods = Model('flea');
        $goods_array = array();
        $goods_array['goods_name'] = $_POST['goods_name'];
        if (intval($_POST['cate_id']) != 0) {
            $goods_array['gc_id'] = $_POST['cate_id'];
            $goods_array['gc_name'] = $_POST['cate_name'];
        }
        $goods_array['flea_pname'] = $_POST['flea_pname'];
        $goods_array['flea_pphone'] = $_POST['flea_pphone'];
        $goods_array['flea_area_id'] = $_POST['area_id'];
        $goods_array['flea_area_name'] = $_POST['area_info'];
        $goods_array['goods_tag'] = $_POST['goods_tag'];
        $goods_array['goods_store_price'] = $_POST['price'];
        $goods_array['goods_show'] = '1';
        $goods_array['goods_commend'] = 0;
        $goods_array['goods_body'] = $_POST['g_body'];
        $goods_array['goods_keywords'] = empty($_POST['seo_keywords']) ? $_POST['goods_tag'] : $_POST['seo_keywords'];
        $goods_array['goods_description'] = empty($_POST['seo_description']) ? $_POST['goods_name'] . ',' . str_cut($_POST['g_body'], 120) : $_POST['seo_description'];
        $state = $model_store_goods->updateGoods($goods_array, $goods_id);
        if ($state) {
            /**
             * 闲置物品封面图片修改
             */
            if (!empty($_POST['goods_file_id'])) {
                $image_info = $model_store_goods->getListImageGoods(
                    array('upload_id' => intval($_POST['goods_file_id']))
                );
                $goods_image = $image_info[0]['file_thumb'];
                $model_store_goods->updateGoods(
                    array('goods_image' => $goods_image), $goods_id
                );
            }
            output_json(1, $state);
        } else {
            output_json(0, 0, '添加超时,请重试');
        }
    }

    /**
     * 闲置物品咨询添加
     */
    public function save_consultOp() {
        $goods_id = intval(
            empty($_GET['goods_id']) ? $_POST['goods_id'] : $_GET['goods_id']
        );
        if ($goods_id <= 0) {
            output_json(1, array(), Language::get('wrong_argument'));
        }
        if (trim($_POST['content']) === "") {
            output_json(0, array(), Language::get('error_content_null'));
        }

        $goods = Model('flea');
        $condition = array();
        $condition['goods_id'] = $goods_id;
        $goods_info = $goods->getGoodsInfo($condition);
        if (empty($goods_info)) {
            output_json(0, $goods_info, '商品不存在');
        }

        /**
         * 接收数据并保存
         */
        $input = array();
        $input['seller_id'] = $goods_info['member_id'];
        $input['member_id'] = $_POST['hide_name']
            ? 0
            : (empty($this->member_info['member_id']) ? 0
                : $this->member_info['member_id']);
        $input['goods_id'] = $goods_id;
        $input['consult_content'] = $_POST['content'];
        $input['type_name'] = 'flea';
        $model_consult = Model('flea_consult');
        if ($result = $model_consult->addConsult($input)) {
            /*	闲置物品表增加评论次数	*/
            $condition['commentnum']['value'] = '1';
            $condition['commentnum']['sign'] = 'increase';
            $goods->updateGoods($condition, $goods_id);

            $field = 'consult_id, goods_id, member_id, consult_content, consult_addtime, consult_reply';
            $consult = $model_consult->getOneById($result);
            $consult['member_avatar'] = getMemberAvatarForID(
                $consult['member_id']
            );
            $consult['consult_addtime'] = $this->_time_comb(
                $consult['consult_addtime']
            );

            output_json(1, $consult, '留言发布成功');
        } else {
            output_json(0, array(), '留言发布超时');
        }
    }

    /**
     * 获取类别列表
     */
    public function class_listOp() {
        $id = intval(
            empty($_POST['class_id']) ? $_GET['class_id'] : $_POST['class_id']
        );

        $model_goods_class = Model('flea_class');
        $condition = array();
        $condition['gc_show'] = 1;
        $condition['gc_parent_id'] = $id;
        $goods_class = $model_goods_class->getClassList($condition);
        foreach ($goods_class as $key => $value) {
            $child_list = $model_goods_class->getNextLevelGoodsClassById(
                $value['gc_id']
            );
            if (!empty($child_list)) {
                $goods_class[$key]['has_child'] = true;
            } else {
                $goods_class[$key]['has_child'] = false;
            }
        }

        output_json(1, $goods_class);
    }

    /**
     * 收藏列表
     */
    public function favoritesOp() {
        $model_favorites = Model('flea_favorites');

        $condition = array();
        $condition['fav_type'] = 'flea';
        $condition['member_id'] = $this->member_info['member_id'];
        $condition['field'] = 'flea_favorites.member_id, fav_id, fav_type, fav_time, goods_id, goods_name, goods_image, goods_store_price, goods_body';

        $page = new Page();
        $page->setStyle('admin');
        $page->setEachNum($this->page);
        $favorites_list = $model_favorites->getFavoritesList($condition, $page, 'detail');

        if (!empty($favorites_list) && is_array($favorites_list)) {
            $favorites_list = $this->_get_extend_goods($favorites_list);
        }

        output_json(1, array('list' => $favorites_list), 'SUCCESS', mobile_page($page->getTotalPage()));
    }

    /**
     * 增加买家收藏
     *
     * @param
     *
     * @return
     */
    public function add_favoritesOp() {
        $fav_id = intval(
            empty($_GET['goods_id']) ? $_POST['goods_id'] : $_GET['goods_id']
        );
        if ($fav_id > 0) {
            $favorites_class = Model('flea_favorites');
            //判断商品,店铺是否为当前会员
            $model_flea = Model('flea');
            $flea_info = $model_flea->getGoodsInfo(
                array('goods_id' => $fav_id)
            );
            if (empty($flea_info)) {
                output_json(0, false, '该商品不存在');
            }
            if ($flea_info['member_id'] == $this->member_info['member_id']) {
                output_json(0, false, '无法收藏自己的商品');
            }

            //闲置物品收藏次数增加1
            $check_rss = $favorites_class->checkFavorites(
                $fav_id, 'flea', $this->member_info['member_id']
            );
            if ($check_rss) {
                output_json(0, false, '已经收藏过了');
            }
            $condition['flea_collect_num']['value'] = 1;
            $condition['flea_collect_num']['sign'] = 'increase';
            $model_flea->updateGoods($condition, $fav_id);

            $add_rs = $favorites_class->addFavorites(
                array(
                    'member_id' => $this->member_info['member_id'],
                    'fav_id' => $fav_id,
                    'fav_type' => 'flea',
                    'fav_time' => time()
                )
            );
            if (!$add_rs) {
                output_json(0, false, '收藏失败');
            }
            output_json(1, $add_rs, '收藏成功');
        } else {
            output_json(0, false, '参数错误');
        }
    }

    /**
     * 删除收藏
     */
    public function del_favoritesOp() {
        $fav_id = empty($_GET['goods_id']) ? $_POST['goods_id'] : $_GET['goods_id'];
        if (!$fav_id) {
            output_json(0, false, Language::get('wrong_argument'));
        }

        $favorites_class = Model('flea_favorites');
        $fav_arr = explode(',', $fav_id);
        if (!empty($fav_arr) && is_array($fav_arr)) {
            foreach ($fav_arr as $value) {
                if (intval($value) > 0) {
                    if (!$favorites_class->delFavorites(
                        intval($value), 'flea'
                    )
                    ) {
                        output_json(0, false, '删除失败');
                    }
                }
            }
        } else {
            if (intval($fav_id) > 0) {
                if (!$favorites_class->delFavorites(intval($fav_id), 'flea')) {
                    output_json(0, false, '删除失败');
                }
            }
        }
        output_json(1, true, '删除成功');
    }

    private function _get_extend_goods($goods_list) {
        if (!empty($goods_list) && is_array($goods_list)) {
            foreach ($goods_list as $key => $val) {
                $val['goods_image'] = fleaThumb($val['goods_image']);

                $abstract = preg_replace('/<[^>]*>|\s+/', '', $val['goods_body']);
                if ($abstract) {
                    $val['goods_abstract'] = str_cut($abstract, 70);
                } else {
                    $val['goods_abstract'] = Language::get('flea_no_explain');
                }

                if ($val['goods_add_time']) {
                    $val['goods_add_time'] = $this->_time_comb(intval($val['goods_add_time']));
                } else if ($val['fav_time']) {
                    $val['fav_time'] = date('Y.m.d H:i', $val['fav_time']);
                }

                $val['goods_store_price'] = ncPriceFormat($val['goods_store_price']);

                unset($val['goods_body']);
                $goods_list[$key] = $val;
            }
        }

        return $goods_list;
    }

    private function _time_comb($goods_add_time) {
        $catch_time = (time() - $goods_add_time);
        if ($catch_time < 60) {
            return $catch_time . Language::get('second') . '前';
        } elseif ($catch_time < 60 * 60) {
            return intval($catch_time / 60) . Language::get('minute') . '前';
        } elseif ($catch_time < 60 * 60 * 24) {
            return intval($catch_time / 60 / 60) . Language::get('hour') . '前';
        } elseif ($catch_time < 60 * 60 * 24 * 365) {
            return intval($catch_time / 60 / 60 / 24) . Language::get('day')
            . '前';
        } else {
            return date('Y:m:d H:i', $goods_add_time);
        }
    }

}