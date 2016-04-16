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
    /*个人信息更新*/
    public function update_member_infoOp(){
        //$datas=json_decode($_POST['content'],true);
        $datas=$_POST;
        $data=array();
        if(isset($datas['member_avatar'])) {
            $originalAvatar=$this->member_info['member_id'].".jpg";
            $data['member_avatar']=$originalAvatar;
            //$newAvatar=base64_decode($datas['member_avatar']);
            if(file_exists(ImgPath.$originalAvatar)){
                list($imageName,$imageType)=explode(".",$originalAvatar);
                unlink(ImgPath.$originalAvatar);
                unlink(ImgPath.$imageName."_120.".$imageType);
                unlink(ImgPath.$imageName."_360.".$imageType);
            }
            $saveImageResult=file_put_contents(ImgPath.$originalAvatar,base64_decode($datas['member_avatar']));
            if($saveImageResult){
                $resizeImage= new ResizeImage();
                $resizeImage->newImg(ImgPath.$originalAvatar,120,120,0,"_120." , ImgPath);
                $resizeImage->newImg(ImgPath.$originalAvatar,360,360,0,"_360." , ImgPath);
                list($imageName,$imageType)=explode(".",$originalAvatar);
                $data['member_avatar']=$imageName."_120.".$imageType;
            }
        }
        $data['member_login_time']=time();
        if(isset($datas['member_truename'])) $data['member_truename']=addslashes($datas['member_truename']);
        if(isset($datas['member_name'])) $data['member_name']=addslashes($datas['member_name']);
        if(isset($datas['member_sex'])){
          if($datas['member_sex']=='男'){
              $data['member_sex']=1;
          }elseif($datas['member_sex']=='女'){
              $data['member_sex']=0;
          }else{
              $data['member_sex']=$datas['member_sex'];
          }
        }
        if(isset($datas['member_birthday'])) $data['member_birthday']=addslashes($datas['member_birthday']);
        $memberModel= model('member');
        $result=$memberModel->where("member_id='".$this->member_info['member_id']."'")->update($data);
        if($result){
           output_json(1,$result,'更新成功');
            die();
        }else{
            output_json(0,$result,'更新失败');
            die();
        }
    }
    /*获取个人信息*/
    public function get_member_infoOp(){
        $member_info = array();
        $member_info['member_name'] = $this->member_info['member_name'];
        $member_info['member_truename'] = $this->member_info['member_truename'];
        $member_info['member_avatar'] = getMemberAvatarForID($this->member_info['member_id']);
        $member_info['member_birthday'] = $this->member_info['member_birthday'];
        $member_info['member_sex'] = $this->member_info['member_sex'] == '1' ? '男' : '女';
        output_json(1, $member_info, '获取成功');
        die();
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

    /*二进制转化函数*/
    private function bin2bstr($input){
        if (!is_string($input)) return null; // Sanity check
        // Pack into a string
        $input = str_split($input, 4);
        $str = '';
        foreach ($input as $v)
        {
            $str .= base_convert($v, 2, 16);
        }
        $str =  pack('H*', $str);
        return $str;
    }




}
