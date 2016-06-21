<?php
/**
 * CMS评论
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class article_commentControl extends mobileCMSControl {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 评论保存
     **/
    public function comment_addOp() {
        $comment_object_id = intval($_GET['object_id']);
        $comment_type = intval($_GET['comment_type']) <= 0 ? self::ARTICLE : intval($_GET['comment_type']);
        $comment_message = trim($_GET['comment_message']);
        if ($comment_type == self::PICTURE) {
            $model_name = 'cms_picture';
            $count_field = 'picture_comment_count';
            $comment_object_key = 'picture_id';
        } else {
            $comment_type = self::ARTICLE;
            $model_name = 'cms_article';
            $count_field = 'article_comment_count';
            $comment_object_key = 'article_id';
        }

        if($comment_object_id <= 0 || empty($comment_type) || empty($comment_message)) {
            output_json(0, array(), '内容不能为空');
        }

        $model_comment = Model('cms_comment');
        $param = array();
        $param['comment_type'] = $comment_type;
        $param["comment_object_id"] = $comment_object_id;
        $param['comment_message'] = $comment_message;
        $param['comment_member_id'] = $this->member_info['member_id'];
        $param['comment_time'] = time();
        if(!empty($_POST['comment_id'])) {
            $comment_detail = $model_comment->getOne(array('comment_id'=>$_POST['comment_id']));
            if(empty($comment_detail['comment_quote'])) {
                $param['comment_quote'] = $_POST['comment_id'];
            } else {
                $param['comment_quote'] = $comment_detail['comment_quote'].','.$_POST['comment_id'];
            }
        } else {
            $param['comment_quote'] = '';
        }

        $result = $model_comment->save($param);
        if($result) {
            //评论计数加1
            $model = Model($model_name);
            $update = array();
            $update[$count_field] = array('exp',$count_field.'+1');
            $condition = array();
            $condition[$comment_object_key] = $comment_object_id;
            $model->modify($update, $condition);

            output_json(1, $result, '评论发表成功');
        }

        output_json(0, array(), '评论发表失败');
    }

    /**
     * 评论列表
     **/
    public function comment_listOp() {
        // 默认按热度排序
        $order = 'comment_up desc, comment_id desc';
        if(intval($_GET['order']) == 1) {
            $order = 'comment_id desc';
        }
        $comment_object_id = intval($_GET['object_id']);
        $comment_type = intval($_GET['type']) <= 0 ? 1 : intval($_GET['type']);

        $field = 'comment_id,comment_type,comment_object_id,comment_message,comment_member_id,comment_time,comment_quote,comment_up,member_id,member_name,member_avatar';

        if($comment_object_id > 0 && $comment_type > 0) {
            $condition = array();
            $condition["comment_object_id"] = $comment_object_id;
            $condition["comment_type"] = $comment_type;
            $model_cms_comment = Model('cms_comment');
            $comment_list = $model_cms_comment->getListWithUserInfo($condition, $this->page, $order, $field);

            if (!empty($comment_list)) {
                $comment_quote_id = '';
                $comment_quote_list = array();

                foreach ($comment_list as $key=>$value) {
                    $comment_list[$key]['member_avatar'] = getMemberAvatar($value['member_avatar']);
                    if(!empty($value['comment_quote'])) {
                        $comment_quote_id .= $value['comment_quote'].',';
                    }
                }

                if(!empty($comment_quote_id)) {
                    $comment_quote_list = $model_cms_comment->getListWithUserInfo(array('comment_id'=>array('in', $comment_quote_id)));
                }
                if(!empty($comment_quote_list)) {
                    $comment_quote_list = array_under_reset($comment_quote_list, 'comment_id');
                }
            }

            output_json(1, $comment_list);
        } else {
            output_json(0, array(), Language::get('wrong_argument'));
        }
    }

    /**
     * 评论删除
     **/
    public function comment_delOp() {
        $comment_id = intval($_POST['comment_id']);
        if($comment_id <= 0) output_json(0, array(), Language::get('wrong_argument'));

        $model_comment = Model('cms_comment');
        $comment_info = $model_comment->getOne(array('comment_id'=>$comment_id));
        if($comment_info['comment_member_id'] == $this->member_info['member_id']) {
            $result = $model_comment->drop(array('comment_id'=>$comment_id));
            if($result) {
                $comment_type = intval($_GET['type']) <= 0 ? self::ARTICLE : intval($_GET['type']);
                if ($comment_type == self::ARTICLE) {
                    $model_name = 'cms_article';
                    $count_field = 'article_comment_count';
                    $comment_object_key = 'article_id';
                } else {
                    $model_name = 'cms_picture';
                    $count_field = 'picture_comment_count';
                    $comment_object_key = 'picture_id';
                }

                //评论计数减1
                $model = Model($model_name);
                $update = array();
                $update[$count_field] = array('exp',$count_field.'-1');
                $condition = array();
                $condition[$comment_object_key] = $comment_info['comment_object_id'];
                $model->modify($update, $condition);

                output_json(1, $result);
            }
        }
    }

    /**
     * 评论顶
     **/
    public function comment_upOp() {
        $comment_id = intval($_POST['comment_id']);
        if ($comment_id <= 0) output_json(0, array(), Language::get('wrong_argument'));

        $model_comment = Model('cms_comment');
        $comment_info = $model_comment->getOne(array('comment_id' => $comment_id));
        if (empty($comment_info)) output_json(0, $comment_info, '评论已不存在');

        $model_comment_up = Model('cms_comment_up');
        $param = array();
        $param['comment_id'] = $comment_id;
        $param['up_member_id'] = $this->member_info['member_id'];
        $is_exist = $model_comment_up->isExist($param);
        if(!$is_exist) {
            $param['up_time'] = time();
            $model_comment_up->save($param);

            $model_comment->modify(array('comment_up'=>array('exp', 'comment_up+1')), array('comment_id'=>$comment_id));
            output_json(1, $model_comment);
        } else {
            output_json(0, array(), '您已经赞过了');
        }
    }

}
