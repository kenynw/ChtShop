<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/5/26
 * Time: 下午7:20
 */
class member_sns_homeControl extends mobileSNSControl {

    /**
     * 个人主页
     */
    public function indexOp() {
        // 用户基本信息
        $model_member = Model('member');
        $field_member = 'member_id, member_name, member_truename, member_avatar, member_sex, member_areainfo, member_intro';
        $member_info= $model_member->getMemberInfoByID($this->master_id, $field_member);
        $member_info['member_avatar'] = getMemberAvatar($member_info['member_avatar']);

        // 获取关注好友
        $model_friend = Model('sns_friend');
        $member_info['relation'] = $this->relation;
        $member_info['following'] = $model_friend->countFriend(array('friend_frommid' => $this->master_id));
        $member_info['followers'] = $model_friend->countFriend(array('friend_tomid' => $this->master_id));

        // 获取动态相关
        $model_trace = Model('sns_tracelog');
        $member_info['trace_count'] = $model_trace->countTrace(array('trace_memberid' => $this->master_id, 'trace_state' => 0));
        $condition_trace = array();
        $condition_trace['trace_memberid']	= $this->master_id;
        $condition_trace['trace_state']		= 0;
        $field_trace = 'trace_id,trace_originalid,trace_title,trace_image,trace_memberid,trace_addtime,trace_state,trace_privacy,trace_commentcount,trace_likecount';
        switch ($this->relation){
            case 2:
                $condition_trace['trace_privacy']	= array('in', array(0,1));
                break;
            default:
                $condition_trace['trace_privacy']	= 0;
        }
        $page = new Page();
        $page->setStyle('admin');
        $page->setEachNum($this->page);
        $trace_list = $model_trace->getTracelogList($condition_trace, $page, $field_trace);

        $member_info['trace_list'] = $this->_get_list_extend($trace_list);

        output_json(1, $member_info);
    }

    /**
     * 首页动态列表
     */
    public function trace_listOp() {
        $tracelog_model = Model('sns_tracelog');
        $condition = array();
        $condition['trace_state'] = 0;
        $condition['trace_originalid'] = 0; // 原创
        if (!empty($_POST['commend'])) $condition['trace_commend_flag'] = 1;

        $filed = 'trace_id,trace_originalid,trace_memberid,trace_membername,trace_memberavatar,trace_title,trace_image,trace_addtime,trace_state,trace_privacy,trace_commentcount,trace_likecount';

        $page = new Page();
        $page->setEachNum($this->page);
        $page->setStyle('admin');
        $trace_list = $tracelog_model->getTracelogList($condition, $page, $filed);

        $page_count = $page->getTotalPage();
        output_json(1, array('list' => $this->_get_list_extend($trace_list)), 'SUCCESS', mobile_page($page_count));
    }

}