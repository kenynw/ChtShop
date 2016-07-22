<?php
/**
 * 我的商城
 *
 *
 *
 *
 
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
define("ImgPath","../data/upload/shop/avatar/");
class member_indexControl extends mobileMemberControl {

	public function __construct(){
		parent::__construct();
	}

    /**
     * 我的商城
     */
	public function indexOp() {
        $member_info = array();

        if(isset($_POST['version']) && $_POST['version'] == VERSION_3_0) {
            $member_info['member_name'] = $this->member_info['member_name'];
            $member_info['member_avatar'] = getMemberAvatarForID($this->member_info['member_id']);
            $member_info['member_points'] = $this->member_info['member_points'];
            $member_info['available_predeposit'] = $this->member_info['available_predeposit'];
            // 头衔
            $member_info['member_exppoints'] = $experience = $this->member_info['member_exppoints'];
            $member_info['member_title'] = $experience > 3000 ? '茶界泰斗' : ($experience > 2000 ? '茶专家' :
                ($experience > 1000 ? '品茶师' : ($experience > 500 ? '茶鬼' : '茶农')));

            $model_order = Model('order');
            $condition = array();
            $condition['buyer_id'] = $this->member_info['member_id'];
            // 待付款订单数量
            $order_new_count = $model_order -> getOrderStateNewCount($condition);
            // 待发货订单数量
            $order_pay_count = $model_order -> getOrderStatePayCount($condition);
            // 待收货订单数量
            $order_send_count = $model_order -> getOrderStateSendCount($condition);
            // 待评价订单数量
            $order_eval_count = $model_order -> getOrderStateEvalCount($condition);
            $member_info['order_new_count'] = $order_new_count;
            $member_info['order_pay_count'] = $order_pay_count;
            $member_info['order_send_count'] = $order_send_count;
            $member_info['order_eval_count'] = $order_eval_count;

            output_json(1, $member_info);
        } else {
            $member_info['user_name'] = $this->member_info['member_name'];
            $member_info['avator'] = getMemberAvatarForID($this->member_info['member_id']);
            $member_info['point'] = $this->member_info['member_points'];
            $member_info['predepoit'] = $this->member_info['available_predeposit'];
            output_data(array('member_info' => $member_info));
        }
	}

	public function upload_avatarOp() {
        //上传图片
        $upload = new UploadFile();
        $upload->set('thumb_width',	500);
        $upload->set('thumb_height',499);
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $upload->set('file_name',"avatar_{$this->member_info['member_id']}.$ext");
        $upload->set('thumb_ext','_new');
        $upload->set('ifremove',true);
        $upload->set('default_dir',ATTACH_AVATAR);
        $result = $upload->upfile('image');
        if (!$result){
            output_json(0, true, $upload->error);
        }
        output_json(1, false);
    }

    public function member_infoOp(){
        $member_info = array();
        $member_info['member_name'] = $this->member_info['member_name'];
        $member_info['member_avatar'] = getMemberAvatarForID($this->member_info['member_id']);
        $member_info['member_birthday'] = $this->member_info['member_birthday'];
        $member_info['member_sex'] = $this->member_info['member_sex'] == '1' ? '男' : '女';;
        $member_info['member_areainfo'] = $this->member_info['member_areainfo'];
        $member_info['member_intro'] = $this->member_info['member_intro'];
        output_json(1, $member_info, '获取成功');
    }

    /**
     * 更新个人资料
     */
    public function update_member_infoOp() {
        if (!empty($_POST['member'])) {
            var_dump($_POST['member']);
        }

        $member_array	= array();
        $member_array['member_name']	    = $_POST['member_name'];
        $member_array['member_sex']			= $_POST['member_sex'];
        $member_array['member_areaid']		= $_POST['area_id'];
        $member_array['member_cityid']		= $_POST['city_id'];
        $member_array['member_provinceid']	= $_POST['province_id'];
        $member_array['member_areainfo']	= $_POST['area_info'];
        $member_array['member_intro']	    = $_POST['member_intro'];
        if (strlen($_POST['birthday']) == 10){
            $member_array['member_birthday']	= $_POST['birthday'];
        }

        $model_member= Model('member');
        $result=$model_member->editMember(array('member_id' => $this->member_info['member_id']), $member_array);
        if($result)output_json(1,true,'更新成功');
        else output_json(0,false,'更新失败');
    }

    public function update_member_pwdOp(){
        $member_id=$this->member_info['member_id'];
        if(md5($_POST['oldpwd'])!=$this->member_info['member_passwd']){
            output_json(0,'','旧密码不正确');
            die();
        }
        if(empty($_POST['newpwd'])){
            output_json(0,'','新密码不能为空');
            die();
        }
        $data=array();
        $data['member_passwd']=md5($_POST['newpwd']);
        $memberModel=Model("member");
        $updateResult=$memberModel->where("member_id='$member_id'")->update($data);
        if($updateResult){
            output_json(1,$updateResult,'更新成功');
            die();
        }else{
            output_json(0,'','更新失败');
            die();
        }

    }

}
