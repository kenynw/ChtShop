<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/8/10
 * Time: 下午5:11
 */
class member_securityControl extends mobileMemberControl {

    /**
     * 修改密码
     */
    public function modify_pwdOp() {
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array("input"=>md5($_POST["old_pwd"]), "require"=>"true", "validator"=>"Compare","operator"=>"==","to"=>$this->member_info['member_passwd'],"message"=>'旧密码输入错误'),
            array("input"=>$_POST["new_pwd"], "require"=>"true", "message"=>'请正确输入密码'),
            array("input"=>$_POST["confirm_pwd"], "require"=>"true", "validator"=>"Compare","operator"=>"==","to"=>$_POST["new_pwd"],"message"=>'两次密码输入不一致'),
        );
        $error = $obj_validate->validate();
        if ($error != '') output_json(0, false, $error);

        $model_member = Model('member');
        $update	= $model_member->editMember(array('member_id'=>$this->member_info['member_id']),array('member_passwd'=>md5($_POST['new_pwd'])));

        if ($update) output_json(1, true, '密码修改成功');
        else output_json(0, false, '密码修改失败');
    }

    /**
     * 统一发送身份验证码
     */
    public function send_auth_codeOp() {
        if (empty($_POST['mobile'])) {
            output_json(0, false, '请输入正确的手机号');
        }

        $model_member = Model('member');
        $member_info = $model_member->getMemberInfo(array('member_mobile'=>$_POST['mobile']), 'member_id,member_mobile');
        if (empty($member_info)) output_json(0, false, '该用户未注册');

        $verify_code = rand(100,999).rand(100,999);
        $data = array();
        $data['auth_code'] = $verify_code;
        $data['send_acode_time'] = TIMESTAMP;
        $update = $model_member->editMemberCommon($data,array('member_id'=>$member_info['member_id']));
        if (!$update) {
            output_json(0, false, '系统发生错误，如有疑问请与管理员联系');
        }

        $model_tpl = Model('mail_templates');
        $tpl_info = $model_tpl->getTplInfo(array('code'=>'authenticate'));

        $param = array();
        $param['send_time'] = date('Y-m-d H:i',TIMESTAMP);
        $param['verify_code'] = $verify_code;
        $param['site_name']	= C('site_name');
        $message = ncReplaceText($tpl_info['content'],$param);
        $sms = new Sms();
        $result = $sms->sendHuyi($member_info["member_mobile"], $message);

        if ($result) {
            output_json(1, true, '验证码已发出，请注意查收');
        } else {
            output_json(0, false, '验证码发送失败');
        }
    }

}