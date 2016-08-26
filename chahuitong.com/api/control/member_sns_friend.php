<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/6/1
 * Time: 下午8:21
 */
class member_sns_friendControl extends mobileMemberControl {
    
    public function __construct() {
        parent::__construct();
    }

    public function indexOp() {
        $this->find_listOp();
    }

    /**
     * 查找好友列表
     */
    public function find_listOp() {
        if(trim($_GET['name']) != ''){

            $model_friend = Model('sns_friend');
            //查询关注会员id
            $condition = array();
            $condition['friend_frommid'] = $this->member_info['member_id'];
            $field_follow = 'friend_tomid,friend_followstate';
            $follow_list = $model_friend->listFriend($condition, $field_follow, $this->page);
            $follow_list_new = array();
            if(!empty($follow_list)){
                foreach($follow_list as $k=>$v){
                    $follow_list_new[$v['friend_tomid']] = $v;
                }
            }

            // 查询条件
            $model_member = Model('member');
            $condition = array();
            $condition['member_state']	= 1;
            $condition['member_id']		= array('neq',$this->member_info['member_id']);
            $condition['member_name']	= array('like','%'.trim($_GET['name']).'%');// 会员名称
            $field = 'member_id,member_name,member_avatar,member_sex,member_state';
            $member_list = $model_member->getMemberList($condition, $field, $this->page);

            if(!empty($member_list)){
                $follow_id_arr = array_keys($follow_list_new);
                foreach($member_list as $k=>$v){
                    if(in_array($v['member_id'],$follow_id_arr)){
                        $v['follow_state'] = $follow_list_new[$v['member_id']]['friend_followstate'];
                    } else {
                        $v['follow_state'] = 0;
                    }

                    // 头像
                    $v['member_avatar'] = getMemberAvatar($v['member_avatar']);

                    $member_list[$k] = $v;
                }
            }

            $page_count = $model_member->gettotalpage();


            output_json(1, array('list' => $member_list), 'SUCCESS', mobile_page($page_count));
        }
    }

    /**
     * 推荐好友列表,根据粉丝数排名
     */
    public function popular_listOp() {
        $model_friend = Model('sns_friend');
        //查询关注会员id
        $condition = array();
        $condition['friend_frommid'] = $this->member_info['member_id'];
        $field_follow = 'friend_tomid,friend_followstate';
        $follow_list = $model_friend->listFriend($condition, $field_follow, $this->page);
        $follow_list_new = array();
        if(!empty($follow_list)){
            foreach($follow_list as $k=>$v){
                $follow_list_new[$v['friend_tomid']] = $v;
            }
        }

        $field = 'friend_id,friend_frommid,friend_tomid,friend_followstate,member_id,member_name,member_avatar,member_sex,member_commend_flag';
        $condition = array();
        $condition['group']             = 'friend_tomid';
        $condition['no_friend_tomid']   = $this->member_info['member_id'];
        $condition['member_commend']    = 1;
        $page = new Page();
        $page->setStyle('admin');
        $page->setEachNum($this->page);
        $friend_list = $model_friend->listFriend($condition, $field, $page, 'detail');

        $member_list = array();
        if (!empty($friend_list)) {
            $follow_id_arr = array_keys($follow_list_new);

            $model_trace = Model('sns_tracelog');
            foreach ($friend_list as $key=>$value) {
                if(in_array($value['friend_tomid'],$follow_id_arr)){
                    $member_list[$key]['follow_state'] = $follow_list_new[$value['friend_tomid']]['friend_followstate'];
                } else {
                    $member_list[$key]['follow_state'] = 0;
                }

                $member_list[$key]['friend_id'] = $value['friend_id'];
                $member_list[$key]['member_id'] = $value['member_id'];
                $member_list[$key]['member_name'] = $value['member_name'];
                $member_list[$key]['member_avatar'] = getMemberAvatar($value['member_avatar']);

                // 获取动态图片
                $condition = array();
                $condition['member_id'] = $value['member_id'];
                $image_list = $model_trace->getImageList($condition, 'item_id, ap_name, member_id', 3);
                if (!empty($image_list)) {
                    foreach ($image_list as $k=>$image) {
                        $trace_image= array();
                        $trace_image['trace_id'] = $image['item_id'];
                        $trace_image['trace_image'] = snsThumb($image['ap_name']);
                        $image_list[$k] = $trace_image;
                    }

                    $member_list[$key]['trace_list'] = $image_list;
                }
            }
        }

        $page_count = $model_friend->gettotalpage();

        output_json(1, array('list' => $member_list), 'SUCCESS', mobile_page($page_count));
    }

    /**
     * 关注某个用户
     */
    public function add_followOp() {
        $mid = intval(empty($_GET['mid']) ? $_POST['mid'] : $_GET['mid']);
        if ($mid <= 0) output_json(0, 0, '参数错误');

        // 查询是否有该用户
        $model_member = Model('member');
        $member_info = $model_member->getMemberInfoByID($mid);
        if (empty($member_info)) output_json(0, 0, '用户不存在');

        // 验证是否关注过
        $model_friend = Model('sns_friend');
        $condition_friend = array();
        $condition_friend['friend_frommid'] = $this->member_info['member_id'];
        $condition_friend['friend_tomid'] = $mid;
        $friend_count = $model_friend->countFriend($condition_friend);
        if ($friend_count > 0) output_json(0, 0, '已关注过该用户');

        // 查询对方是否已经关注我，从而判断关注状态
        $insert = array();
        $insert['friend_frommid'] = $this->member_info['member_id'];
        $insert['friend_frommname'] = $this->member_info['member_name'];
        $insert['friend_frommavatar'] = $this->member_info['member_avatar'];
        $insert['friend_tomid'] = $member_info['member_id'];
        $insert['friend_tomname'] = $member_info['member_name'];
        $insert['friend_tomavatar'] = $member_info['member_avatar'];
        $insert['friend_addtime'] = time();
        $friend_info = $model_friend->getFriendRow(array('friend_frommid'=>"{$mid}", 'friend_tomid' => $this->member_info['member_id']));
        if (empty($friend_info)) $insert['friend_followstate'] = 1; // 单方面关注
        else $insert['friend_followstate'] = 2; // 互相关注
        $result = $model_friend->addFriend($insert);
        if ($result) {
            // 更新对方关注状态
            if(!empty($friend_info)){
                $model_friend->editFriend(array('friend_followstate'=>'2'),array('friend_id'=>"{$friend_info['friend_id']}"));
            }

            // 添加消息通知
            $model_message = Model('message');
            $condition = array();
            $condition['from_member_id'] = $this->member_info['member_id'];
            $condition['to_member_id'] = $member_info['member_id'];
            $condition['message_type'] = 3;
            $message_info = $model_message->getRowMessage($condition);
            if (!empty($message_info)) {
                $model_message->updateCommonMessage(array('message_update_time' => TIMESTAMP), $condition);
            } else {
                $condition['from_member_name'] = $this->member_info['member_name'];
                $condition['to_member_name'] = $member_info['member_name'];
                $condition['msg_content'] = '关注了你';
                $model_message->saveMessage($condition);
            }

            output_json(1, $insert['friend_followstate']);
        } else {
            output_json(0, 0, '操作失败');
        }
    }

    /**
     * 取消关注
     */
    public function del_followOp() {
        $mid = intval(empty($_GET['mid']) ? $_POST['mid'] : $_GET['mid']);
        if ($mid <= 0) output_json(0, array(), '参数错误');

        //取消关注
        $friend_model = Model('sns_friend');
        $result = $friend_model->delFriend(array('friend_frommid'=>$this->member_info['member_id'],'friend_tomid'=>"$mid"));
        if($result){
            //更新对方的关注状态
            $friend_model->editFriend(array('friend_followstate'=>'1'),array('friend_frommid'=>"$mid",'friend_tomid'=>$this->member_info['member_id']));

            // 更新消息通知
            $model_message = Model('message');
            $param = array();
            $param['from_member_id'] = $this->member_info['member_id'];
            $param['to_member_id'] = $mid;
            $param['message_type'] = 3;
            $model_message->dropCommonMessage($param, 'msg_private');

            output_json(1, 0);
        }else{
            output_json(0, 1, '取消关注失败');
        }
    }

    /**
     * 关注我的用户列表
     */
    public function follow_listOp() {
        $mid = intval(empty($_POST['mid']) ? $_GET['mid'] : $_POST['mid']);
        $type = intval(empty($_POST['type']) ? $_GET['type'] : $_POST['type']);
        if ($mid <= 0) $mid = $this->member_info['member_id'];

        $model_follow = Model('sns_friend');

        $page = new Page();
        $page->setStyle('admin');
        $page->setEachNum($this->page);

        //查询关注会员id
        $condition = array();
        $condition['friend_frommid'] = $this->member_info['member_id'];
        $field_follow = 'friend_tomid,friend_followstate';
        $my_follow_list = $model_follow->listFriend($condition, $field_follow, $page);
        $follow_list_new = array();
        if(!empty($my_follow_list)){
            foreach($my_follow_list as $k=>$v){
                $follow_list_new[$v['friend_tomid']] = $v;
            }
        }

        $condition = array();
        if ($type == 0) {
            $condition['friend_frommid'] = $mid;
//            $condition['no_friend_tomid'] = $this->member_info['member_id'];
        }
        else $condition['friend_tomid'] = $mid;
        $field = 'friend_id,friend_frommid,friend_tomid,member_id,member_name,member_avatar,member_sex';
        $follow_list = $model_follow->listFriend($condition, $field, $page, $type == 1 ? 'fromdetail' : 'detail');

        if (!empty($follow_list)) {
            $follow_id_arr = array_keys($follow_list_new);
            foreach ($follow_list as $key=>$value) {
                if(in_array($value['friend_tomid'],$follow_id_arr)){
                    $follow_list[$key]['follow_state'] = $follow_list_new[$value['friend_tomid']]['friend_followstate'];
                } else {
                    $follow_list[$key]['follow_state'] = 0;
                }

                $follow_list[$key]['member_avatar'] = getMemberAvatar($value['member_avatar']);
            }
        }

        output_json(1, array('list' => $follow_list), 'SUCCESS', mobile_page($page->getTotalPage()));
    }

    /**
     * 查询关注的动态列表
     */
    public function trace_listOp() {
        //查询关注以及好友列表
        $friend_model = Model('sns_friend');
        $friend_list = $friend_model->listFriend(array('friend_frommid'=>$this->member_info['member_id']));
        $mutual_follow_id_arr = array();
        $follow_id_arr = array();
        if (!empty($friend_list)){
            foreach ($friend_list as $k=>$v){
                $follow_id_arr[] = $v['friend_tomid'];
                if ($v['friend_followstate'] == 2){
                    $mutual_follow_id_arr[] = $v['friend_tomid'];
                }
            }
        }

        $tracelog_model = Model('sns_tracelog');
        $condition = array();
        $condition['allowshow'] = '1';
        $condition['allowshow_memberid'] = $this->member_info['member_id'];
        $condition['allowshow_followerin'] = "";
        if (!empty($follow_id_arr)){
            $condition['allowshow_followerin'] = implode("','",$follow_id_arr);
        }
        $condition['allowshow_friendin'] = "";
        if (!empty($mutual_follow_id_arr)){
            $condition['allowshow_friendin'] = implode("','",$mutual_follow_id_arr);
        }
        $condition['trace_state'] = "0";
        $condition['trace_originalid'] = '0'; // 原创

        $file = 'trace_id,trace_originalid,trace_memberid,trace_membername,trace_memberavatar,trace_title,trace_image,trace_addtime,trace_state,trace_privacy,trace_commentcount,trace_likecount';

        $page = new Page();
        $page->setEachNum($this->page);
        $page->setStyle('admin');
        $trace_list = $tracelog_model->getTracelogList($condition, $page, $file);

        // 数据处理
        if (!empty($trace_list)) {
            foreach ($trace_list as $key=>$value) {
                $trace_list[$key]['trace_memberavatar'] = getMemberAvatar($value['trace_memberavatar']);
                $trace_list[$key]['trace_addtime'] = date('m.d h:i', $value['trace_addtime']);
                $trace_list[$key]['trace_image'] = snsThumb($value['trace_image']);

                // 处理@
                if ($value['trace_title']){
                    $trace_list[$key]['trace_title'] = str_replace("%siteurl%", "com.cht.user://".DS, $value['trace_title']);
                }
                if(!empty($value['trace_content'])){
                    //替换内容中的siteurl
                    $trace_list[$key]['trace_content'] = str_replace("%siteurl%", "com.cht.user://".DS, $value['trace_content']);
                }

                // 查询点赞状态
                $model_like = Model('sns_like');
                $like_info = $model_like->getLikeInfo(array(
                    'like_memberid' => $this->member_info['member_id'],
                    'like_originalid' => $value['trace_id'],
                    'like_originaltype' => 0,
                    'like_state' => 0
                ));
                if (empty($like_info)) $trace_list[$key]['is_like'] = false;
                else $trace_list[$key]['is_like'] = true;

                // 关系
                $trace_list[$key]['relation'] = $this->_check_relation($value['trace_memberid']);
            }
        }

        $page_count = $page->getTotalPage();

        output_json(1, array('list' => $trace_list), 'SUCCESS', mobile_page($page_count));
    }

    private function _check_relation($mid) {
        if ($mid <= 0) output_json(0, array(), Language::get('wrong_argument'));

        if ($mid == $this -> member_info['member_id']) {
            $relation = 3;
        } else {
            $relation = 1;

            $model_friend = Model('sns_friend');
            $condition_friend = array();
            $condition_friend['friend_frommid'] = $this -> member_info['member_id'];
            $condition_friend['friend_tomid'] = $mid;
            $friend_info = $model_friend->getFriendRow($condition_friend);
            if (!empty($friend_info) && $friend_info['friend_followstate'] == 2) {
                $relation = 2;
            } elseif ($friend_info['friend_followstate'] == 1) {
                $relation = 4;
            }
        }

        return $relation;
    }

}