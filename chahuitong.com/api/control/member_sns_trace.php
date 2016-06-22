<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/5/25
 * Time: 下午3:40
 */
class member_sns_traceControl extends mobileMemberControl {
    
    public function __construct() {
        parent::__construct();
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
        $condition['limit'] =$this->page;

        $file = 'trace_id,trace_originalid,trace_memberid,trace_membername,trace_memberavatar,trace_title,trace_addtime,trace_state,trace_privacy,trace_commentcount';

        $trace_list = $tracelog_model->getTracelogList($condition, '', $file);

        // 数据处理
        if (empty($trace_list)) {
            output_json(0, array(), '暂无数据');
        } else {
            foreach ($trace_list as $key=>$value) {
                $trace_list[$key]['trace_memberavatar'] = getMemberAvatar($value['trace_memberavatar']);
                $trace_list[$key]['trace_addtime'] = date('Y.m.d h:i', $value['trace_addtime']);
            }
        }

        $page_count = $tracelog_model->gettotalpage();

        output_json(1, array('list' => $trace_list), 'SUCCESS', mobile_page($page_count));
    }

    /**
     * 一条SNS动态及其评论
     */
    public function trace_detailOp(){
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        //查询动态详细
        $tracelog_model = Model('sns_tracelog');
        $condition = array();
        $condition['trace_id'] = $id;
        $condition['trace_privacy'] = 0;
        $condition['trace_state'] = 0;
        $trace_info = $tracelog_model->getTracelogRow($condition);
        // 图片信息
        $model_trace_image = Model('sns_trace_images');
        $image_list = $model_trace_image->where(array('trace_id' => $id))->select();
        foreach ($image_list as $image) {
            $trace_info['trace_image'] .= snsThumb($image['trace_image']) . ',';
        }

        if (empty($trace_info)) {
            output_json(0, $trace_info, '暂无数据');
        }

        // 与主人的关系。0-游客(未登录);1-未关注;2-互相关注;3-自己;4-已关注
        $trace_info['relation'] = $this->_check_relation($trace_info['trace_memberid']);
        $trace_info['trace_addtime'] = date('Y.m.d H:i', $trace_info['trace_addtime']);

        // 查询评论列表
        $comment_model = Model('sns_comment');
        $condition = array();
        $condition['comment_originalid'] = $id;
        $condition['comment_originaltype'] = '0'; //原帖类型 0表示动态信息 1表示分享商品
        $condition['comment_state'] = "0"; //0表示正常，1表示屏蔽
        $condition['limit'] = $this->page;

        if (empty($_GET['show_comment'])) {
            $comment_list = $comment_model->getCommentList($condition);
            if (!empty($comment_list)) {
                foreach ($comment_list as $key => $value) {
                    $comment_list[$key]['comment_memberavatar'] = getMemberAvatar($value['comment_memberavatar']);
                    $comment_list[$key]['comment_addtime'] = date('Y.m.d H:i', $value['comment_addtime']);
                }
                $page_count = $comment_model->gettotalpage();
                $trace_info['comment_list'] = array_merge(array('list' => $comment_list), mobile_page($page_count));
            }
        }

        output_json(1, $trace_info);
    }

    /**
     * 添加新动态
     */
    public function trace_addOp() {
        $obj_validate = new Validate();
        $validate_arr[] = array("input"=>$_POST['content'], "require"=>'true', "message"=>'输入内容不能空');
        $obj_validate -> validateparam = $validate_arr;
        $error = $obj_validate -> validate();
        if ($error != '') {
            output_json(0, $error, 'error');
        }

        $tracelog_model = Model('sns_tracelog');
        $insert_arr = array();
        $insert_arr['trace_originalid'] = '0';
        $insert_arr['trace_originalmemberid'] = '0';
        $insert_arr['trace_memberid'] = $this->member_info['member_id'];
        $insert_arr['trace_membername'] = $this->member_info['member_name'];
        $insert_arr['trace_memberavatar'] = $this->member_info['member_avatar'];
        $insert_arr['trace_title'] = $_POST['content'];
        $insert_arr['trace_content'] = '';
        $insert_arr['trace_addtime'] = time();
        $insert_arr['trace_state'] = '0';
        $insert_arr['trace_privacy'] = intval($_POST["privacy"])>0?intval($_POST["privacy"]):0;
        $insert_arr['trace_commentcount'] = 0;
        $insert_arr['trace_copycount'] = 0;
        $result = $tracelog_model->tracelogAdd($insert_arr);
        if ($result) {
            output_json(1, $result);
        } else {
            output_json(0, $result, '发表失败,请稍后重试');
        }
    }

    public function trace_image_testOp() {
        $model_trace_image = Model('sns_trace_images');
        $insert = array();
        $insert['trace_id']	= intval($_POST['trace_id']);
        $insert['member_id'] = $this->member_info['member_id'];
        $insert['trace_image'] = 'test.jpge';
        $insert['upload_time'] = time();
        $insert['is_default'] = intval($_POST['is_default']);
        var_dump($insert);
        $result = $model_trace_image->insert($insert);
        echo 'resutl: ' . $result;
    }
    
    public function trace_image_uploadOp() {
//        echo 'fuck' . $_FILES['image']['name'] . $_POST['trace_id'];

        /**
         * 上传图片
         */
        $upload = new UploadFile();
        $upload_dir = ATTACH_MALBUM.DS.$this->member_info['member_id'].DS;

        $upload->set('default_dir',$upload_dir.$upload->getSysSetPath());
        $thumb_width	= '240,1024';
        $thumb_height	= '2048,1024';

        $upload->set('max_size',C('image_max_filesize'));
        $upload->set('thumb_width', $thumb_width);
        $upload->set('thumb_height',$thumb_height);
        $upload->set('fprefix',$this->member_info['member_id']);
        $upload->set('thumb_ext', '_240,_1024');
        $result = $upload->upfile('image');
        if (!$result){
            output_json(0, $result . $_FILES['image']['name'], '上传失败');
        }

        $img_path = $upload->getSysSetPath().$upload->file_name;

        $model_trace_image = Model('sns_trace_images');
        $insert = array();
        $insert['trace_id']	= intval($_POST['trace_id']);
        $insert['member_id'] = $this->member_info['member_id'];
        $insert['trace_image'] = $img_path;
        $insert['upload_time'] = time();
        $insert['is_default'] = intval($_POST['is_default']);
        var_dump($insert);
        $result = $model_trace_image->insert($insert);
        if ($result) {
            if (intval($_POST['is_default']) == 1) {
                $model_trace = Model('sns_tracelog');
                $model_trace->tracelogEdit(array('trace_image' => $img_path), array('trace_id' => intval($_POST['trace_id'])));
            }

            output_json(1, $result);
        } else {
            output_json(0, '', '更新数据库失败');
        }

    }

    /**
     * 删除动态
     */
    public function trace_delOp(){
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        $tracelog_model = Model('sns_tracelog');
        //删除动态
        $condition = array();
        $condition['trace_id'] = $id;
        $condition['trace_memberid'] = $this->member_info['member_id'];
        $result = $tracelog_model->delTracelog($condition);
        if ($result){
            //修改该动态的转帖信息
            $tracelog_model->tracelogEdit(array('trace_originalstate'=>'1'),array('trace_originalid'=>"$id"));
            //删除对应的评论
            $comment_model = Model('sns_comment');
            $condition = array();
            $condition['comment_originalid'] = "$id";
            $condition['comment_originaltype'] = "0";
            $comment_model->delComment($condition);
            output_json(1, $result, '删除成功');
        } else {
            output_json(0, array(), '删除失败');
        }
    }

    /**
     * 评论列表
     */
    public function comment_listOp(){
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        $comment_model = Model('sns_comment');
        //查询评论总数
        $condition = array();
        $condition['comment_originalid'] = $id;
        $condition['comment_originaltype'] = '0'; //原帖类型 0表示动态信息 1表示分享商品
        $condition['comment_state'] = "0"; //0表示正常，1表示屏蔽
        $condition['limit'] = $this->page;

        //评价列表
        $comment_list = $comment_model->getCommentList($condition);
        if (!empty($comment_list)) {
            foreach ($comment_list as $key => $value) {
                $comment_list[$key]['comment_memberavatar'] = getMemberAvatar($value['comment_memberavatar']);
                $comment_list[$key]['comment_addtime'] = date('Y.m.d H:i', $value['comment_addtime']);
            }
        }

        $page_count = $comment_model->gettotalpage();

        output_json(1, array('list' => $comment_list), 'SUCCESS', mobile_page($page_count));
    }

    /**
     * 添加评论
     */
    public function comment_addOp() {
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        $obj_validate = new Validate();
        $validate_arr[] = array("input"=>$_GET['content'], "require"=>"true","message"=>'评论不能空');
        $validate_arr[] = array("input"=>$_GET['content'], "validator"=>'Length',"min"=>0,"max"=>140,"message"=>'评论不能超过140个中文字符');
        $obj_validate -> validateparam = $validate_arr;
        $error = $obj_validate->validate();
        if ($error != ''){
            output_json(0, array(), $error);
        }

        //查询原动态信息
        $tracelog_model = Model('sns_tracelog');
        $tracelog_info = $tracelog_model->getTracelogRow(array('trace_id'=>"{$id}",'trace_state'=>'0'));
        if (empty($tracelog_info)){
            output_json(0, array(), '动态已不存在');
        }

        $comment_model = Model('sns_comment');
        $insert_arr = array();
        $insert_arr['comment_memberid'] = $this->member_info['member_id'];
        $insert_arr['comment_membername'] = $this->member_info['member_name'];
        $insert_arr['comment_memberavatar'] = $this->member_info['member_avatar'];
        $insert_arr['comment_originalid'] = $id;
        $insert_arr['comment_originaltype'] = 0;
        $insert_arr['comment_content'] = _['content'];
        $insert_arr['comment_addtime'] = time();
        $insert_arr['comment_ip'] = getIp();
        $insert_arr['comment_state'] = '0'; //正常
        $result = $comment_model->commentAdd($insert_arr);
        if ($result){
            // 发送消息
            if ($tracelog_info['trace_memberid'] != $this->member_info['member_id']) {
                $insert = array();
                $insert['member_id'] = $tracelog_info['trace_memberid'];
                $insert['to_member_name'] = $tracelog_info['member_name'];
                $insert['msg_content'] = $tracelog_info['trace_id'] . '&回复了你:' . $_GET['content'];
                $insert['message_type'] = 4;
                $this->_send_msg($insert);
            }

            //更新动态统计信息
            $update_arr = array();
            $update_arr['trace_commentcount'] = array('sign'=>'increase','value'=>'1');
            if (intval($tracelog_info['trace_originalid']) == 0){
                $update_arr['trace_orgcommentcount'] = array('sign'=>'increase','value'=>'1');
            }
            $tracelog_model->tracelogEdit($update_arr,array('trace_id'=>"$id"));
            unset($update_arr);
            //更新所有转帖的原帖评论次数
            if (intval($tracelog_info['trace_originalid']) == 0){
                $tracelog_model->tracelogEdit(array('trace_orgcommentcount'=>$tracelog_info['trace_orgcommentcount']+1),array('trace_originalid'=>"$id"));
            }
        }

        output_json(1, $result);
    }

    /**
     * 删除评论
     */
    public function comment_delOp() {
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        //查询评论信息
        $comment_model = Model('sns_comment');
        $comment_info = $comment_model->getCommentRow(array('comment_id'=>$id,'comment_memberid'=>$this->member_info['member_id']));
        if (empty($comment_info)){
            output_json(0, $comment_info, '评论已不存在');
        }

        //删除评论
        $condition = array();
        $condition['comment_id'] = "$id";
        $result = $comment_model->delComment($condition);
        if ($result){
            //更新动态统计信息
            $tracelog_model = Model('sns_tracelog');
            $update_arr = array();
            $update_arr['trace_commentcount'] = array('sign'=>'decrease','value'=>'1');
            $tracelog_model->tracelogEdit($update_arr,array('trace_id'=>"{$comment_info['comment_originalid']}"));
            output_json(1, $result, 'SUCCESS');
        } else {
            output_json(0, $comment_info, '评论已不存在');
        }
    }

    /**
     * 点赞
     */
    public function like_addOp() {
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        $model_comment = Model('sns_comment');
        $comment_info = $model_comment->getCommentRow(array('comment_id' => $id));
        if (empty($comment_info)) output_json(0, array(), '原评论已不存在');

        $model_like = Model('sns_like');
        $like_info = $model_like->getLikeInfo(array('like_originalid' => $id));
        if (empty($like_info)) {
            $insert = array();
            $insert['like_memberid'] = $this->member_info['member_id'];
            $insert['like_membername'] = $this->member_info['member_name'];
            $insert['like_memberavatar'] = $this->member_info['member_avatar'];
            $insert['like_originalid'] = $id;
            $insert['like_originaltype'] = intval($_POST['type'])<=0 ? 0 : intval($_POST['type']);
            $insert['like_addtime'] = time();
            $insert['like_ip'] = getIp();
            $insert['like_state'] = '0'; //正常
            $result = $model_like->addLike($insert);

            if ($result && $like_info['like_memberid'] != $this->member_info['member_id']) {
                $params = array();
                $params['member_id'] = $comment_info['comment_memberid'];
                $params['to_member_name'] = $comment_info['comment_membername'];
                $params['msg_content'] = $comment_info['comment_id'] . '&赞了你:';
                $params['message_type'] = 4;
                $this->_send_msg($params);
            }
        } else {
            if ($like_info['like_state'] == 0) {
                output_json(1, array(), '已经点过赞了');
            }

            $result = $model_like->editLike(array('like_id' => $like_info['like_id']), array('like_state' => 0));
        }

        // 更改点赞数
        $action = array('sign'=>'increase','value'=>'1');
        if (intval($_POST['type']) == 0) {
            $model_trace = Model('sns_tracelog');
            $model_trace->tracelogEdit(array('trace_likecount' => $action),array('trace_id'=>$id));
        } elseif(intval($_POST['type']) == 2) {
            $model_comment = Model('sns_comment');
            $model_comment->commentEdit(array('comment_likecount' => $action),array('comment_id'=>$id));
        }

        output_json(1, $result);
    }

    /**
     * 取消赞
     */
    public function like_cancelOp() {
        $id = intval($_GET['id']);
        if ($id <= 0) {
            $id = intval($_POST['id']);
        }
        if ($id <= 0) {
            output_json(0, array(), '参数错误');
        }

        $model_like = Model('sns_like');
        $like_info = $model_like->getLikeInfo(array('like_originalid' => $id));
        if (empty($like_info)) {
            output_json(1, array(), '动态已被删除');
        } elseif($like_info['like_state'] == 1) {
            output_json(1, array(), '状态已经改变了');
        }

        $result = $model_like->cancelLike(array('like_id' => $like_info['like_id']));

        // 更改点赞数
        if ($result) {
            $action = array('sign'=>'decrease','value'=>'1');
            if (intval($_POST['type']) == 0) {
                $model_trace = Model('sns_tracelog');
                $model_trace->tracelogEdit(array('trace_likecount' => $action),array('trace_id'=>$id));
            } elseif(intval($_POST['type']) == 2) {
                $model_comment = Model('sns_comment');
                $model_comment->commentEdit(array('comment_likecount' => $action),array('comment_id'=>$id));
            }
        }

        output_json(1, $result);
    }

    private function _send_msg($param) {
        $model_message = Model('message');
        $param['from_member_id'] = $this->member_info['member_id'];
        $param['from_member_name'] = $this->member_info['member_name'];
        $model_message->saveMessage($param);
    }

    private function _check_relation($mid) {
        if ($mid <= 0) {
            output_json(0, array(), '数据出错');
        }

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