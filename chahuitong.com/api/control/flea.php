<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/6/25
 * Time: 下午3:34
 */
class fleaControl extends mobileHomeControl {
    
    public function __construct() {
        parent::__construct();
        if($GLOBALS['setting_config']['flea_isuse']!='1'){
            output_json(0, '闲置市场暂关闭');
        }
    }

    public function indexOp() {
        $model_chashi = Model('ecs_post');
        $model_chashi_content = Model('ecs_post_content');
        $goods_list = $model_chashi->where("user_id > 0 and pic!=''")->order('id asc')->select();

        $model_flea = Model();
        $model_flea_upload = Model();
        $model_member = Model('member');
        $flea_list = array();
        foreach ($goods_list as $key => $value) {
            $member_info = $model_member->getMemberInfoByID($value['user_id'], 'member_id, member_name');
            $chashi_content = $model_chashi_content->where('pid='.$value['id'])->find();

            $insert = array();
            $insert['goods_name'] = $value['brand'] . ' ' . $value['name'];
            $insert['gc_id'] = 0;
            $insert['gc_name'] = '';
            $insert['member_id'] = $value['user_id'];
            $insert['member_name'] = $member_info['member_name'];
            $insert['goods_image'] = $value['pic'];
            $insert['goods_tag'] = '';
            $insert['goods_price'] = 0;
            $insert['goods_store_price'] = $value['price'];
            $insert['goods_show'] = 0;
            $insert['goods_click'] = 0;
            $insert['flea_collect_num'] = 0;
            $insert['goods_commend'] = 0;
            $insert['goods_add_time'] = strtotime($value['addtime']);
            $insert['goods_keywords'] = '';
            $insert['goods_description'] = '';
            $insert['goods_body'] = $chashi_content['content'];
            $insert['commentnum'] = 0;
            $insert['salenum'] = 0;
            $insert['flea_quality'] = 0;
            $insert['flea_pname'] = $value['contact'];
            $insert['flea_pphone'] = $value['phone'];
            $insert['flea_area_id'] = 0;
            $insert['flea_area_name'] = $value['address'];

            $id = Model()->table('flea')->insert($insert);
            if ($id) {
                $image_list = array_filter(explode(',', $chashi_content['depic']));
                foreach ($image_list as $image) {
                    $image_insert = array();
                    $image_insert['file_name'] = $image;
                    $image_insert['file_thumb'] = $image;
                    $image_insert['store_id'] = $value['user_id'];
                    $image_insert['upload_type'] = 12;
                    $image_insert['upload_time'] = strtotime($value['addtime']);
                    $image_insert['item_id'] = $id;
                    $model_flea_upload->table('flea_upload')->insert($image_insert);
                    $insert['image'][] = $image_insert;
                }
            }

            $flea_list[] = $insert;
        }

        output_json(0, $goods_list);
    }

}