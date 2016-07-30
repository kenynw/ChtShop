<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/7/30
 * Time: 上午10:59
 */
class member_sns_informControl extends mobileSNSControl {

    /**
     * 举报动态或评论
     */
    public function inform_traceOp() {
        $trace_id = intval(empty($_POST['trace_id']) ? $_GET['trace_id'] : $_POST['trace_id']);
        if ($trace_id < 0) output_error(Language::get("wrong_argument"));
        $reply_id = intval(empty($_POST['reply_id']) ? $_GET['reply_id'] : $_POST['reply_id']);

        $model_inform = Model('sns_inform');
        $update = array();
        $update['trace_id'] = $trace_id;
        $update['reply_id'] = $reply_id;
        $update['member_id'] = $this->member_info['member_id'];
        $inform_info = $model_inform->where($update)->find();
        if (!empty($inform_info)) output_error('已经举报过了');

        $model_trace = Model('sns_tracelog');
        $trace_info = $model_trace->getTraceByID($trace_id, 'trace_title');
        if (empty($trace_info)) output_error('举报的动态不存在');

        $update['trace_content'] = $trace_info['trace_title'];
        $update['member_name'] = $this->member_info['member_name'];
        $update['inform_content'] = $_POST['inform_content'];
        $update['inform_time'] = TIMESTAMP;
        $update['inform_type'] = intval($_POST['type']);
        $update['inform_state'] = 0;

        $result = $model_inform->insert($update);
        if (!$result) output_error('请求超时');
        output_result(1);
    }

    /**
     * 举报主页（用户）
     */
    public function inform_homeOp() {
        $mid = intval(empty($_POST['mid']) ? $_GET['mid'] : $_POST['mid']);
        if ($mid < 0) output_error(Language::get("wrong_argument"));

        if ($mid == $this->member_info['member_id']) output_error('不能举报自己');

        $model_inform = Model('sns_inform');
        $update = array();
        $update['to_member_id'] = $mid;
        $update['member_id'] = $this->member_info['member_id'];
        $inform_info = $model_inform->where($update)->find();
        if (!empty($inform_info)) output_error('已经举报过了');

        $model_member = Model('member');
        $member_info = $model_member->getMemberInfoByID($mid, 'member_name');
        if (empty($member_info)) output_error('举报的动态不存在');

        $update['to_member_name'] = $member_info['member_name'];
        $update['member_name'] = $this->member_info['member_name'];
        $update['inform_content'] = $_POST['inform_content'];
        $update['inform_time'] = TIMESTAMP;
        $update['inform_type'] = 2;
        $update['inform_state'] = 0;

        $result = $model_inform->insert($update);
        if (!$result) output_error('请求超时');
        output_result(1);
    }

}