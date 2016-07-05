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

        $field = 'friend_frommid,friend_tomid,friend_tomname,friend_tomavatar,friend_followstate';
        $condition = 'friend_tomid != ' . $this->member_info['member_id'];
        $friend_list = $model_friend->friendListGroupByToMid($condition, $field, $this->page);

        $member_list = array();
        if (!empty($friend_list)) {
            $follow_id_arr = array_keys($follow_list_new);
            $model_trace_images = Model('sns_trace_images');
            foreach ($friend_list as $key=>$value) {
                if(in_array($value['member_id'],$follow_id_arr)){
                    $member_list[$key]['follow_state'] = $follow_list_new[$value['member_id']]['friend_followstate'];
                } else {
                    $member_list[$key]['follow_state'] = 0;
                }

                $member_list[$key]['member_id'] = $value['friend_tomid'];
                $member_list[$key]['member_name'] = $value['friend_tomname'];
                $member_list[$key]['member_avatar'] = getMemberAvatar($value['friend_tomavatar']);

                $condition = array();
                $condition['member_id'] = $value['friend_tomid'];
                $trace_image_list = $model_trace_images->field('trace_id,trace_image')->where($condition)->limit(3)->select();

                if (!empty($trace_image_list)) {
                    foreach ($trace_image_list as $k=>$image) {
                        $trace_image_list[$k]['trace_image'] = snsThumb($image['trace_image']);
                    }

                    $member_list[$key]['trace_list'] = $trace_image_list;
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
        if ($mid <= 0) output_json(0, array(), '参数错误');

        // 查询是否有该用户
        $model_member = Model('member');
        $member_info = $model_member->getMemberInfoByID($mid);
        if (empty($member_info)) output_json(0, $member_info, '用户不存在');

        // 验证是否关注过
        $model_friend = Model('sns_friend');
        $condition_friend = array();
        $condition_friend['friend_frommid'] = $this->member_info['member_id'];
        $condition_friend['friend_tomid'] = $mid;
        $friend_count = $model_friend->countFriend($condition_friend);
        if ($friend_count > 0) output_json(0, array(), '已关注过该用户');

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

            $param = array();
            $param['from_member_id'] = $this->member_info['member_id'];
            $param['from_member_name'] = $this->member_info['member_name'];
            $param['to_member_id'] = $member_info['member_id'];
            $param['to_member_name'] = $member_info['member_name'];
            $param['msg_content'] = $this->member_info['member_name'] . '&关注了你';
            $param['message_type'] = 3;
            Model('message')->saveMessage($param);

            output_json(1, $insert['friend_followstate']);
        } else {
            output_json(0, $result, '操作失败');
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
            output_json(1, $result);
        }else{
            output_json(0, $result, '取消关注失败');
        }
    }

    /**
     * 我关注的用户列表
     */
    public function follow_listOp() {
        $model_follow = Model('sns_friend');
        $condition = array();
        $condition['friend_frommid'] = $this->member_info['member_id'];

        $follow_list = $model_follow->getFriendList($condition, '*', $this->page);

        $page_count = $model_follow->gettotalpage();

        output_json(1, array('list' => $follow_list), 'SUCCESS', mobile_page($page_count));
    }

    /**
     * 关注我的用户列表
     */
    public function follower_listOp() {
        $model_follow = Model('sns_friend');
        $condition = array();
        $condition['friend_tomid'] = $this->member_info['member_id'];
        
        $page = new Page();
        $page->setEachNum($this->page);
        $page->setStyle('admin');
        $follow_list = $model_follow->listFriend($condition, '*', $page);

        $page_count = $model_follow->gettotalpage();

        output_json(1, array('list' => $follow_list), 'SUCCESS', mobile_page($page_count));
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