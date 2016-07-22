<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/5/26
 * Time: 下午7:20
 */
class member_sns_homeControl extends mobileHomeControl {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 个人主页
     */
    public function indexOp() {
        $key = empty($_GET['key']) ? $_POST['key'] : $_GET['key'];
        $model_mb_user_token = Model('mb_user_token');
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);

        $mid = intval(empty($_GET['mid']) ? $_POST['mid'] : $_GET['mid']);
        if ($mid <= 0) {
            if (empty($mb_user_token_info)) {
                output_json(-1, array(), '请登录');
            }
            $mid = intval($mb_user_token_info['member_id']);
        }

        // 用户基本信息
        $model_member = Model('member');
        $this->member_info = $model_member->getMemberInfoByID($mid);
        $member_info['member_id'] = $this->member_info['member_id'];
        $member_info['member_name'] = $this->member_info['member_name'];
        $member_info['member_truename'] = $this->member_info['member_truename'];
        $member_info['member_avatar'] = getMemberAvatarForID($this->member_info['member_avatar']);
        $member_info['member_sex'] = $this->member_info['member_sex'];
        $member_info['member_areainfo'] = $this->member_info['member_areainfo'];
        $member_info['member_intro'] = $this->member_info['member_intro'];

        // 获取关注好友
        $model_friend = Model('sns_friend');
        $relation = 0;
        if ($mid == $mb_user_token_info['member_id']) {
            $relation = 3;
        } else {
            $condition_friend = array();
            $condition_friend['friend_frommid'] = $mb_user_token_info['member_id'];
            $condition_friend['friend_tomid'] = $mid;
            $friend_info = $model_friend->getFriendRow($condition_friend);
            if (empty($friend_info)) {
                $relation = 1;
            } elseif($friend_info['friend_followstate'] == 2) {
                $relation = 2;
            } elseif($friend_info['friend_followstate'] == 1) {
                $relation = 4;
            }
        }
        $member_info['relation'] = $relation;
        $member_info['following'] = $model_friend->countFriend(array('friend_frommid' => $mid));
        $member_info['followers'] = $model_friend->countFriend(array('friend_tomid' => $mid));

        // 获取动态相关
        $model_trace = Model('sns_tracelog');
        $member_info['trace_count'] = $model_trace->countTrace(array('trace_memberid' => $mid, 'trace_state' => 0));
        $condition_trace = array();
        $condition_trace['trace_memberid']	= $mid;
        $condition_trace['trace_state']		= 0;
        $field_trace = 'trace_id,trace_originalid,trace_title,trace_image,trace_addtime,trace_state,trace_privacy,trace_commentcount,trace_likecount';
        switch ($relation){
            case 2:
                $condition_trace['trace_privacy']	= array('in', array(0,1));
                break;
            case 1:
            default:
                $condition_trace['trace_privacy']	= 0;
        }
        $page = new Page();
        $page->setStyle('admin');
        $page->setEachNum($this->page);
        $trace_list = $model_trace->getTracelogList($condition_trace, $page, $field_trace);

        $member_info['trace_list'] = $this->_get_extend($trace_list);

        output_json(1, $member_info);
    }

    /**
     * 首页动态列表
     */
    public function trace_listOp() {
        $key = empty($_GET['key']) ? $_POST['key'] : $_GET['key'];
        $model_mb_user_token = Model('mb_user_token');
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        $mid = intval(empty($_GET['mid']) ? $_POST['mid'] : $_GET['mid']);
        if ($mid <= 0) $mid = intval($mb_user_token_info['member_id']);

        $tracelog_model = Model('sns_tracelog');
        $condition = array();
        $condition['trace_state'] = 0;
        $condition['trace_originalid'] = 0; // 原创
        if ($mid > 0) $condition['trace_memberid'] = $mid;
        if (!empty($_POST['commend'])) $condition['trace_commend_flag'] = 1;

        $filed = 'trace_id,trace_originalid,trace_memberid,trace_membername,trace_memberavatar,trace_title,trace_image,trace_addtime,trace_state,trace_privacy,trace_commentcount,trace_likecount';

        $page = new Page();
        $page->setEachNum($this->page);
        $page->setStyle('admin');
        $trace_list = $tracelog_model->getTracelogList($condition, $page, $filed);

        $page_count = $page->getTotalPage();
        output_json(1, array('list' => $this->_get_extend($trace_list)), 'SUCCESS', mobile_page($page_count));
    }

    private function _get_extend($trace_list) {
        if (!empty($trace_list) && is_array($trace_list)) {
            $model_trace_image = Model('sns_albumpic');
            foreach ($trace_list as $key=>$value) {
                $image_list = $model_trace_image->where(array('item_id' => $value['trace_id']))->field('ap_cover, item_id')->select();
                foreach ($image_list as $k=>$image) {
                    $image_list[$k]['thumb_mid'] = snsThumb($image['ap_cover'], 240);
                    $image_list[$k]['thumb_max'] = snsThumb($image['ap_cover'], '1024');
                }
                $value['trace_image_list'] = $image_list;

                if (!empty($value['trace_memberavatar'])) $value['trace_memberavatar'] = getMemberAvatar($value['trace_memberavatar']);
                $value['trace_addtime'] = date('Y.m.d h:i', $value['trace_addtime']);
                $value['trace_image'] = snsThumb($value['trace_image']);

                if ($value['trace_title']){
                    $value['trace_title'] = str_replace("%siteurl%", "com.cht.user://".DS, $value['trace_title']);
                }
                if(!empty($value['trace_content'])){
                    //替换内容中的siteurl
                    $value['trace_content'] = str_replace("%siteurl%", "com.cht.user://".DS, $value['trace_content']);
                }
                $trace_list[$key] = $value;
            }
            return $trace_list;
        }
        return array();
    }

}