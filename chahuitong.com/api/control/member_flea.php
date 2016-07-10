<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/6/25
 * Time: 下午3:45
 */
class member_fleaControl extends mobileMemberControl {
    
    public function __construct() {
        parent::__construct();
    }

    public function indexOp() {
        /**
         * 实例化闲置物品模型
         */
        $model_store_goods	= Model('flea');
        /**
         * 闲置分页
         */
        $page	= new Page();
        $page->setEachNum($this->page);
        $page->setStyle('admin');
        $search_array['member_id']	= $this->member_info['member_id'];
        $search_array['keyword']	= trim($_GET['keyword']);
        $search_array['order']	= 'goods_id desc';
        $list_goods	= $model_store_goods->listGoods($search_array,$page);

        if(is_array($list_goods) and !empty($list_goods)) {
            foreach ($list_goods as $key => $val) {
                $list_goods[$key]['goods_image'] = fleaThumb($val['goods_image'], $val['member_id']);
            }

            $page_count = $page->getTotalPage();
            output_json(1, array('list' => $list_goods), 'SUCCESS', mobile_page($page_count));
        }

        output_json(0, array('list' => $list_goods), '暂无数据');
    }

    public function flea_listOp() {
        //加载模型
        $flea_model		= Model('flea');

        $condition = array();
//        $condition['goods_show'] = 1;
        $condition['pic_input'] = 2;
        $condition['body_input'] = 2;
        $condition['order'] = 'goods_tag desc, goods_click desc, goods_id desc';

        $field = 'goods_id, goods_name, member_id, goods_image, goods_tag, goods_store_price, goods_show, goods_click, goods_commend, goods_add_time, goods_body, flea_pname, flea_pphone';

        $page	= new Page();
        $page->setEachNum($this->page);
        $page->setStyle('admin');
        $goods_list	= $flea_model->listGoods($condition, $page, $field);
        if($goods_list){
            $goods_list = $this->_get_extend_goods($goods_list);

            $page_count = $page->getTotalPage();
            output_json(1, array('list' => $goods_list), 'SUCCESS', mobile_page($page_count));
        }

        output_json(0, $goods_list);
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

        $model_store_goods	= Model('flea');
        $condition = array();
        $condition['goods_id'] = $goods_id;
//        $condition['goods_show'] = 1;
        $goods_info = $model_store_goods->getGoodsInfo($condition);

        if(empty($goods_info)) output_json(0, $goods_info, Language::get('error_no_goods'));

        // 标签处理
        if ($goods_info['goods_tag']) {
            $goods_info['goods_tag'] = str_replace(', ',' ',$goods_info['goods_tag']);
        }

        // 日期处理
        $goods_info['goods_add_time'] = date('Y-m-d H:i');

        /**
         * 商品多图
         */
        $condition = array();
        $condition['image_store_id'] = $goods_info['member_id'];
        $condition['item_id'] = $goods_info['goods_id'];
        $condition['image_type'] = 12;
        $field = 'file_thumb, store_id, upload_type, item_id';
        $desc_image	= $model_store_goods->getListImageGoods($condition, $field);
        if(!empty($desc_image) && is_array($desc_image)) {
            $image = '';
            foreach ($desc_image as $key => $val) {
                $image .= fleaThumb($val['file_thumb'], $goods_info['member_id']) . ',';
            }
            $goods_info['goods_image'] = $image;
        }

        /**
         * 得到商品咨询信息
         */
        $consult		= Model('flea_consult');
        $field = 'member_id,consult_id,goods_id,consult_content,consult_addtime,consult_reply,consult_reply_time';
        $consult_list	= $consult->getConsultList(array('goods_id'=>$goods_id,'order'=>'consult_id desc'),'','seller', $field);
        $goods_info['consult_list'] = $consult_list;

        /**
         * 浏览次数更新
         */
        $model_store_goods->updateGoods(array('goods_click'=>($goods_info['goods_click']+1)),$goods_id);

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
        $upload_array['store_id']		= $this->member_info['member_id'];
        $upload_array['upload_type']	= '12';
        $upload_array['item_id']		= '0';
        $upload_array['upload_time_lt']	= time()-24*60*60;
        $model_upload->delByWhere($upload_array);
        unset($upload_array);

        if (empty($_POST['goods_name'])) output_json(0, 0, Language::get('error_title_null'));

        /**
         * 实例化店铺商品模型
         */
        $model_store_goods	= Model('flea');
        $goods_array			= array();
        $goods_array['goods_name']		    = $_POST['goods_name'];
        $goods_array['gc_id']			    = $_POST['cate_id'];
        $goods_array['gc_name']			    = $_POST['cate_name'];
        $goods_array['member_id']			= $this->member_info['member_id'];
        $goods_array['flea_pname']		    = $_POST['flea_pname'];
        $goods_array['flea_area_id']	    = $_POST['area_id'];
        $goods_array['flea_area_name']	    = $_POST['area_info'];
        $goods_array['flea_pphone']		    = $_POST['flea_pphone'];
        $goods_array['goods_tag']		    = $_POST['goods_tag'];
        $goods_array['goods_store_price']   = $_POST['price'];
        $goods_array['goods_show']		    = '1';
        $goods_array['goods_commend']	    = 0;
        $goods_array['goods_body']		    = $_POST['g_body'];
        $goods_array['goods_keywords']		= empty($_POST['seo_keywords']) ? $_POST['goods_tag'] : $_POST['seo_keywords'];
        $goods_array['goods_description']   = empty($_POST['seo_description']) ? $_POST['goods_name'].','.str_cut($_POST['g_body'], 120) : $_POST['seo_description'];
        $state = $model_store_goods->saveGoods($goods_array);
        if($state) {
            /**
             * 更新闲置物品多图
             */
            $upload_array = array();
            $upload_array['store_id']	= $this->member_info['member_id'];
            $upload_array['item_id']	= '0';
            $upload_array['upload_type_in'] = "'12','13'";
            $upload_array['upload_id_in']	= "'".implode("','", $_POST['goods_file_id'])."'";
            $model_upload->updatebywhere(array('item_id'=>$state),$upload_array);

            /**
             * 商品封面图片修改
             */
            if(!empty($_POST['goods_file_id'])) {
                $image_info	= $model_store_goods->getListImageGoods(array('upload_id'=>intval($_POST['goods_file_id'])));
                $goods_image	= $image_info[0]['file_thumb'];
                $model_store_goods->updateGoods(array('goods_image'=>$goods_image),$state);
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
        if($_POST['upload_id'] != ''){
            $model_store_goods	= Model('flea');
            $model_store_goods->dropImageGoods(array('upload_id'=>intval($_POST['upload_id'])));
        }

        /**
         * 上传图片
         */
        $upload = new UploadFile();
        $upload_dir = ATTACH_MALBUM.DS.$this->member_info['member_id'].DS;
        $upload->set('default_dir',$upload_dir.$upload->getSysSetPath());
        $thumb_width = '240,1024';
        $thumb_height = '2048,1024';
        $upload->set('max_size',C('image_max_filesize'));
        $upload->set('thumb_width',	$thumb_width);
        $upload->set('thumb_height',$thumb_height);
        $upload->set('fprefix',$this->member_info['member_id']);
        $upload->set('thumb_ext',	'_240,_1024');

        $result = $upload->upfile('image');
        if ($result){
            $_POST['pic'] 		= $upload->getSysSetPath().$upload->file_name;
            $_POST['pic_thumb'] = $upload->getSysSetPath().$upload->thumb_image;
        }else {
            output_json(0, array(), '图片上传失败');
        }

        $img_path = $_POST['pic'];
        /**
         * 取得图像大小
         */
        list($width, $height, $type, $attr) = getimagesize(BASE_UPLOAD_PATH.DS.$upload_dir.$img_path);

        /**
         * 图片数据入库
         */
        $model_upload = Model('flea_upload');
        $insert_array = array();
        $image_type	  = array('goods_image'=>12,'desc_image'=>13);//debug
        $insert_array['file_name']	= $_POST['pic'];
        $insert_array['file_thumb']	= $_POST['pic_thumb'];
        $insert_array['file_size']	= intval($_FILES['image']['size']);
        $insert_array['upload_time']= time();
        $insert_array['item_id']	= intval($_POST['item_id']);
        $insert_array['store_id']	= $this->member_info['member_id'];
        $insert_array['upload_type']= 12;
        $result2 = $model_upload->add($insert_array);

        $data = array();
        $data['upload_id']	= $result2;
        $data['file_name']	= $_POST['pic_thumb'];
        $data['file_path']	= $_POST['pic_thumb'];
        output_json(1, $data);
    }

    /**
     * 删除闲置物品
     */
    public function drop_goodsOp() {
        /**
         * 实例化闲置物品模型
         */
        $model_store_goods	= Model('flea');
        /**
         * 检查商品是否属于店铺
         */
        $goods_id = trim(empty($_GET['goods_id']) ? $_POST['goods_id'] : $_GET['goods_id']);
        if(empty($goods_id)) output_json(0, 0, Language::get('wrong_argument'));

        //统计输入数量
        $goods_id_array = explode(',',$goods_id);
        $input_goods_count = count($goods_id_array);
        //统计确认的数量
        $para = array();
        $para['member_id'] = $this->member_info['member_id'];
        $para['goods_id_in'] = $goods_id;
        $verify_count = intval($model_store_goods->countGoods($para));
        //判断输入和确认是否一致
        if($input_goods_count !== $verify_count) output_json(0, 0, Language::get('wrong_argument'));

        $state	= $model_store_goods->dropGoods($goods_id);
        if($state) {
            output_json(1, $state, '删除成功');
        } else {
            output_json(0, 0, '删除失败');
        }
    }

    /**
     * 编辑闲置物品保存
     */
    public function edit_goodsOp() {
        $goods_id	= intval($_POST['goods_id']);

        if (empty($_POST['goods_name'])) output_json(0, 0, Language::get('error_title_null'));

        /**
         * 实例化闲置物品模型
         */
        $model_store_goods	= Model('flea');
        $goods_array			= array();
        $goods_array['goods_name']		= $_POST['goods_name'];
        if (intval($_POST['cate_id']) != 0) {
            $goods_array['gc_id']	    = $_POST['cate_id'];
            $goods_array['gc_name']		= $_POST['cate_name'];
        }
        $goods_array['flea_pname']		= $_POST['flea_pname'];
        $goods_array['flea_pphone']		= $_POST['flea_pphone'];
        $goods_array['flea_area_id']	= $_POST['area_id'];
        $goods_array['flea_area_name']	= $_POST['area_info'];
        $goods_array['goods_tag']		= $_POST['goods_tag'];
        $goods_array['goods_store_price']= $_POST['price'];
        $goods_array['goods_show']		= '1';
        $goods_array['goods_commend']	= 0;
        $goods_array['goods_body']		= $_POST['g_body'];
        $goods_array['goods_keywords']		= empty($_POST['seo_keywords']) ? $_POST['goods_tag'] : $_POST['seo_keywords'];
        $goods_array['goods_description']   = empty($_POST['seo_description']) ? $_POST['goods_name'].','.str_cut($_POST['g_body'], 120) : $_POST['seo_description'];
        $state = $model_store_goods->updateGoods($goods_array,$goods_id);
        if($state) {
            /**
             * 闲置物品封面图片修改
             */
            if(!empty($_POST['goods_file_id'])) {
                $image_info	= $model_store_goods->getListImageGoods(array('upload_id'=>intval($_POST['goods_file_id'])));
                $goods_image	= $image_info[0]['file_thumb'];
                $model_store_goods->updateGoods(array('goods_image'=>$goods_image),$goods_id);
            }
            output_json(1, $state);
        } else {
            output_json(0, 0, '添加超时,请重试');
        }
    }

    /**
     * 闲置物品咨询添加
     */
    public function save_consultOp(){
        $goods_id = intval(empty($_GET['goods_id']) ? $_POST['goods_id'] : $_GET['goods_id']);
        if ($goods_id <= 0) output_json(1, array(), Language::get('wrong_argument'));
        if(trim($_POST['content'])==="") output_json(0, array(), Language::get('error_content_null'));

        $goods	= Model('flea');
        $condition	= array();
        $condition['goods_id']	= $goods_id;
        $goods_info	= $goods->getGoodsInfo($condition);
        if (empty($goods_info)) output_json(0, $goods_info, '商品不存在');

        /**
         * 接收数据并保存
         */
        $input	= array();
        $input['seller_id']			= $goods_info['member_id'];
        $input['member_id']			= $_POST['hide_name']?0:(empty($this->member_info['member_id'])?0:$this->member_info['member_id']);
        $input['goods_id']			= $goods_id;
        $input['consult_content']	= $_POST['content'];
        $input['type_name']	        = 'flea';
        $consult = Model('flea_consult');
        if($result = $consult->addConsult($input)){
            /*	闲置物品表增加评论次数	*/
            $condition['commentnum']['value']='1';
            $condition['commentnum']['sign']='increase';
            $goods->updateGoods($condition, $goods_id);
            output_json(1, $result, '留言发布成功');
        }else{
            output_json(0, 0, '留言发布超时');
        }
    }

    public function class_listOp() {
        $id = intval(empty($_POST['class_id']) ? $_GET['class_id'] : $_POST['class_id']);

        $model_goods_class = Model('flea_class');
        $condition = array();
        $condition['gc_show'] = 1;
        $condition['gc_parent_id'] = $id;
        $goods_class = $model_goods_class->getClassList($condition);
        output_json(1, $goods_class);
    }
    
    private function _get_extend_goods($goods_list) {
        if (!empty($goods_list) && is_array($goods_list)) {
            foreach ($goods_list as $key => $val) {
                $goods_list[$key]['goods_image_url'] = fleaThumb($val['goods_image'], $val['member_id']);

                $abstract = preg_replace('/<[^>]*>|\s+/', '', $val['goods_body']);
                if ($abstract) {
                    $goods_list[$key]['goods_abstract'] = str_cut($abstract,140);
                } else {
                    $goods_list[$key]['goods_abstract'] = Language::get('flea_no_explain');
                }

                $goods_list[$key]['goods_add_time'] = $this->_time_comb(intval($val['goods_add_time'])) . '前';

                unset($goods_list[$key]['goods_image']);
                unset($goods_list[$key]['goods_body']);
            }
        }

        return $goods_list;
    }

    private function _time_comb($goods_add_time){
        $now_time	= time();
        $last_time	= $now_time - $goods_add_time;
        if($last_time>2592000)	return intval($last_time/2592000).Language::get('flea_index_mouth');
        if($last_time>86400)	return intval($last_time/86400).Language::get('flea_index_day');
        if($last_time>3600)		return intval($last_time/3600).Language::get('flea_index_hour');
        if($last_time>60)		return intval($last_time/60).Language::get('flea_index_minute');
        return $last_time.Language::get('flea_index_seconds');
    }

}