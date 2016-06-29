<?php

/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/6/23
 * Time: 上午9:52
 */
class discoverControl extends mobileHomeControl {

    // 动态推荐
    const TRACE_COMMEND = 1;

    public function __construct() {
        parent::__construct();
    }

    public function indexOp() {
        $data = array();

        // 获取精选动态
        $model_trace = Model('sns_tracelog');
        $condition = array();
        $condition['trace_state'] = 0;
        $condition['trace_privacy'] = 0; // 所有人可见
        $condition['trace_originalid'] = 0; // 原创
        $condition['trace_commend_flag'] = self::TRACE_COMMEND;
        $field = 'trace_id, trace_image, trace_state, trace_privacy, trace_originalid, trace_commend_flag';
        $trace_list = $model_trace->getTracelogList($condition, 9, $field);
        // 数据处理
        if (!empty($trace_list)) {
            foreach ($trace_list as $key=>$value) {
                $trace_list[$key]['trace_image'] = snsThumb($value['trace_image']);
                unset($trace_list[$key]['trace_state']);
                unset($trace_list[$key]['trace_privacy']);
                unset($trace_list[$key]['trace_originalid']);
                unset($trace_list[$key]['trace_commend_flag']);
            }
            $data['trace_list'] = $trace_list;
        }

        // 获取推荐茶市
        $model_flea = Model('flea');
        $condition = array();
//        $condition['goods_show'] = 1;
        $condition['commend'] = 1;
        $condition['order'] = 'goods_id desc';
        $field = 'goods_id, goods_image, goods_commend';
        $page	= new Page();
        $page->setEachNum(10);
        $page->setStyle('admin');
        $flea_list	= $model_flea->listGoods($condition, $page, $field);
        if(!empty($flea_list)){
            foreach ($flea_list as $key => $val) {
                $flea_list[$key]['goods_image_url'] = fleaThumb($val['goods_image'], $val['member_id']);
                unset($flea_list[$key]['goods_image']);
            }
            $data['flea_list'] = $flea_list;
        }

        // 获取热门茶类
        $model_staple_class = Model('goods_class_staple');
        $condition = array();
        $condition['gc_id_1'] = array('gt', 0);
        $field = 'staple_id, staple_name, gc_id_1, gc_id_2, gc_id_3, counter';
        $class_list = $model_staple_class->getStapleList($condition, $field, 'counter desc', 6);
        if (!empty($class_list)) {
            foreach ($class_list as $key => $value) {
                if ($value['gc_id_3'] > 0) {
                    $class_list[$key]['gc_id'] = $value['gc_id_3'];
                } elseif($value['gc_id_2'] > 0) {
                    $class_list[$key]['gc_id'] = $value['gc_id_2'];
                } else {
                    $class_list[$key]['gc_id'] = $value['gc_id_1'];
                }

                $staple_name = explode('>', $value['staple_name']);
                $class_list[$key]['gc_name'] = end($staple_name);
                unset($class_list[$key]['gc_id_3']);
                unset($class_list[$key]['gc_id_2']);
                unset($class_list[$key]['gc_id_1']);
                unset($class_list[$key]['staple_name']);
            }
            $data['class_list'] = $class_list;
        }
        
        // 获取推荐用户
        $model_member = Model('member');
        $condition = array();
        $condition['member_state'] = 1;
        $condition['member_commend_flag'] = 1;
        $field = 'member_id, member_name, member_avatar, member_state, member_commend_flag';
        $member_list = $model_member->getMemberList($condition, $field, $this->page);
        if (!empty($member_list)) {
            foreach ($member_list as $key => $value) {
                $member_list[$key]['member_avatar'] = getMemberAvatar($value['member_avatar']);
                unset($member_list[$key]['member_state']);
                unset($member_list[$key]['member_commend_flag']);
            }
            $data['member_list'] = $member_list;
        }

        output_json(1, $data);
    }
}